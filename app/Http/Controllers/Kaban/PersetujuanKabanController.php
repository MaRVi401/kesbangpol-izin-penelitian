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
    public function proses(Request $request, $uuid)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'komentar' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $tiket = Tiket::where('uuid', $uuid)
                ->where('status', 'verifikasi lengkap')
                ->firstOrFail();

            $tiket->update([
                'status' => $request->status
            ]);

            RiwayatStatusTiket::create([
                'tiket_id' => $tiket->uuid,
                'users_id' => auth()->user()->uuid,
                'status' => $request->status
            ]);

            if ($request->filled('komentar')) {
                KomentarTiket::create([
                    'tiket_id' => $tiket->uuid,
                    'users_id' => auth()->user()->uuid,
                    'komentar' => $request->komentar
                ]);
            }

            DB::commit();

            $pesan = $request->status == 'diterima' 
                ? 'Tiket berhasil disetujui/diterima.' 
                : 'Tiket telah ditolak.';

            return redirect()->route('dashboard.kaban')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses tiket: ' . $e->getMessage());
        }
    }

    public function previewPdf(WordTemplateServiceIzinPenelitian $service, $uuid)
    {
        $tiket = Tiket::with('suratIzinPenelitian')->where('uuid', $uuid)->firstOrFail();
        
        $penandatangan = auth()->user()->kaban; 
        
        $pdfPath = $service->generatePDFKaban($tiket->suratIzinPenelitian, $tiket->no_tiket, $penandatangan); 
        
        return Storage::disk('local')->response($pdfPath);
    }
}