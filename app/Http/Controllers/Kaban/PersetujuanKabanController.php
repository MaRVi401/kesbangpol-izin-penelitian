<?php

namespace App\Http\Controllers\Kaban;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\RiwayatStatusTiket;
use App\Models\KomentarTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WordTemplateServiceIzinPenelitian;
use Illuminate\Support\Facades\Storage;

class PersetujuanKabanController extends Controller
{
    public function proses(Request $request, $uuid, WordTemplateServiceIzinPenelitian $service)
    {
        $request->validate([
            'status' => 'required|in:ditandatangani,ditolak',
            'passphrase' => 'required_if:status,ditandatangani|string',
            'komentar' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $kabanProfile = auth()->user()->kaban;

            $tiket = Tiket::with('suratIzinPenelitian')
                ->where('uuid', $uuid)
                ->where('status', 'diterima') 
                ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                    $query->where('penandatangan_id', $kabanProfile->uuid)
                          ->where('penandatangan_type', \App\Models\Kaban::class);
                })
                ->firstOrFail();

            if ($request->status === 'ditolak') {
                $tiket->update(['status' => 'ditolak']);
                
                RiwayatStatusTiket::create([
                    'tiket_id' => $tiket->uuid,
                    'users_id' => auth()->user()->uuid,
                    'status' => 'ditolak'
                ]);

                if ($request->filled('komentar')) {
                    KomentarTiket::create([
                        'tiket_id' => $tiket->uuid,
                        'users_id' => auth()->user()->uuid,
                        'komentar' => $request->komentar
                    ]);
                }
                
                DB::commit();
                return redirect()->route('dashboard.kaban')->with('success', 'Tiket telah ditolak.');
            }

            $linkVerifikasi = route('verifikasi.dokumen', $tiket->uuid);
            $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->margin(1)->generate($linkVerifikasi);
            $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage);

            $pdfPathDraf = $service->generatePDFKaban($tiket->suratIzinPenelitian, $tiket->no_tiket, $kabanProfile, $qrCodeBase64);
            $absolutePdfPath = \Illuminate\Support\Facades\Storage::disk('public')->path($pdfPathDraf);

            $responseTte = \Illuminate\Support\Facades\Http::withBasicAuth(
                    config('services.bsre.username'), 
                    config('services.bsre.password')
                )
                ->attach('file', file_get_contents($absolutePdfPath), 'surat_izin.pdf')
                ->post(config('services.bsre.url') . '/api/sign/pdf', [
                    'nik' => $kabanProfile->nik, 
                    'passphrase' => $request->passphrase,
                    'tampilan' => 'invisible',
                ]);

            if (!$responseTte->successful()) {
                throw new \Exception('API BSrE Error: ' . $responseTte->body());
            }

            $signedPdfContent = $responseTte->body();
            $signedFileName = 'signed_' . str_replace('/', '_', $tiket->no_tiket) . '.pdf';
            $signedFilePath = 'surat_izin/signed/' . $signedFileName;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($signedFilePath, $signedPdfContent);

            $tiket->suratIzinPenelitian->update([
                'file_surat_signed_path' => $signedFilePath
            ]);

            $tiket->update([
                'status' => 'ditandatangani'
            ]);

            RiwayatStatusTiket::create([
                'tiket_id' => $tiket->uuid,
                'users_id' => auth()->user()->uuid,
                'status' => 'ditandatangani'
            ]);

            if ($request->filled('komentar')) {
                KomentarTiket::create([
                    'tiket_id' => $tiket->uuid,
                    'users_id' => auth()->user()->uuid,
                    'komentar' => $request->komentar
                ]);
            }

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($pdfPathDraf)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pdfPathDraf);
            }

            DB::commit();

            return redirect()->route('dashboard.kaban')->with('success', 'Dokumen berhasil ditandatangani secara elektronik.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses TTE: ' . $e->getMessage());
        }
    }

    public function previewPdf(WordTemplateServiceIzinPenelitian $service, $uuid)
    {
        $kabanProfile = auth()->user()->kaban;

        $tiket = Tiket::with('suratIzinPenelitian')
            ->where('uuid', $uuid)
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                $query->where('penandatangan_id', $kabanProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kaban::class);
            })
            ->firstOrFail();
        
        $pdfPath = $service->generatePDFKaban($tiket->suratIzinPenelitian, $tiket->no_tiket, $kabanProfile); 
        
        return Storage::disk('local')->response($pdfPath);
    }
}