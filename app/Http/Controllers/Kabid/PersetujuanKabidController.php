<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\RiwayatStatusTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\WordTemplateServiceIzinPenelitian;
use App\Models\PenandatanganSurat;
use Illuminate\Support\Facades\Storage;

class PersetujuanKabidController extends Controller
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
                \App\Models\KomentarTiket::create([
                    'tiket_id' => $tiket->uuid,
                    'users_id' => auth()->user()->uuid,
                    'komentar' => $request->komentar
                ]);
            }

            DB::commit();

            $pesan = $request->status == 'diterima' 
                ? 'Tiket berhasil disetujui/diterima.' 
                : 'Tiket telah ditolak.';

            return redirect()->route('kabid.dashboard')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses tiket: ' . $e->getMessage());
        }
    }

    public function previewPdf($uuid, WordTemplateServiceIzinPenelitian $service)
    {
        $tiket = Tiket::with('suratIzinPenelitian')->where('uuid', $uuid)->firstOrFail();
        $penandatangan = PenandatanganSurat::first();        
        
        $pdfPath = $service->generatePdfPreview($tiket->suratIzinPenelitian, $tiket->no_tiket, $penandatangan);
        
        return Storage::disk('local')->response($pdfPath);
    }
}