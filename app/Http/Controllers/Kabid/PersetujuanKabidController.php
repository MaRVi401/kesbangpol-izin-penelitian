<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\RiwayatStatusTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WordTemplateServiceIzinPenelitian;
use Illuminate\Support\Facades\Storage;

class PersetujuanKabidController extends Controller
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

            $kabidProfile = auth()->user()->kabid;

            $tiket = Tiket::with('suratIzinPenelitian')
                ->where('uuid', $uuid)
                ->where('status', 'verifikasi lengkap') 
                ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                    $query->where('penandatangan_id', $kabidProfile->uuid)
                        ->where('penandatangan_type', \App\Models\Kabid::class);
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
                return redirect()->route('dashboard')->with('success', 'Tiket telah ditolak.');
            }

            $linkVerifikasi = route('verifikasi.dokumen', $tiket->uuid);
            $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->margin(1)->generate($linkVerifikasi);
            $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeImage);

            $pdfPathDraf = $service->generatePDFKabid($tiket->suratIzinPenelitian, $tiket->no_tiket, $kabidProfile, $qrCodeBase64);
            $absolutePdfPath = \Illuminate\Support\Facades\Storage::disk('local')->path($pdfPathDraf);

            $responseTte = \Illuminate\Support\Facades\Http::withHeaders([
                'Expect' => '' 
            ])
            ->timeout(60) 
            ->withBasicAuth(
                config('services.bsre.username'), 
                config('services.bsre.password')
            )
            ->attach('file', file_get_contents($absolutePdfPath), 'surat_izin.pdf')
            ->post(config('services.bsre.url') . '/api/sign/pdf', [
                'nik' => $kabidProfile->nik,
                'passphrase' => $request->passphrase,
                'tampilan' => 'invisible',
            ]);

            if (!$responseTte->successful()) {
                throw new \Exception('API BSrE Error: ' . $responseTte->body());
            }

            $signedPdfContent = $responseTte->body();
            $signedFileName = 'signed_' . str_replace('/', '_', $tiket->no_tiket) . '.pdf';
            $signedFilePath = 'surat_izin/signed/' . $signedFileName;
            
            \Illuminate\Support\Facades\Storage::disk('local')->put($signedFilePath, $signedPdfContent);

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

            if (\Illuminate\Support\Facades\Storage::disk('local')->exists($pdfPathDraf)) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($pdfPathDraf);
            }

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Dokumen berhasil ditandatangani secara elektronik.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses TTE: ' . $e->getMessage());
        }
    }

    public function previewPdf(WordTemplateServiceIzinPenelitian $service, $uuid)
    {
        $kabidProfile = auth()->user()->kabid;

        $tiket = Tiket::with('suratIzinPenelitian')
            ->where('uuid', $uuid)
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                $query->where('penandatangan_id', $kabidProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kabid::class);
            })
            ->firstOrFail();
        
        $pdfPath = $service->generatePDFKabid($tiket->suratIzinPenelitian, $tiket->no_tiket, $kabidProfile);
        
        return Storage::disk('local')->response($pdfPath);
    }
}