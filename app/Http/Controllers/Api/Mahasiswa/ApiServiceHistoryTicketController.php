<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\SuratPermohonanIzinPenelitian;
use App\Models\RiwayatStatusTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiServiceHistoryTicketController extends Controller
{
    /**
     * Mendapatkan daftar riwayat tiket milik mahasiswa saat ini.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->uuid;

        $query = Tiket::with(['layanan', 'riwayatStatusTiket'])
            ->where('users_id', $userId);

        // Fitur Pencarian via API (berdasarkan nomor tiket atau nama layanan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_tiket', 'like', '%' . $search . '%')
                  ->orWhereHas('layanan', function($qLayanan) use ($search) {
                      $qLayanan->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        // Menggunakan pagination standar JSON API
        $tickets = $query->latest('updated_at')->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $tickets
        ], 200);
    }

    /**
     * Mengajukan proses revisi dari tiket yang ditolak kembali menjadi draft via API.
     */
    public function revisi(Request $request, $uuid)
    {
        $userId = $request->user()->uuid;

        $tiket = Tiket::where('uuid', $uuid)
            ->where('users_id', $userId)
            ->first();

        if (!$tiket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tiket pengajuan tidak ditemukan.'
            ], 404);
        }

        if (!in_array(strtolower($tiket->status), ['ditolak', 'verifikasi gagal'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya tiket dengan status Ditolak atau Verifikasi Gagal yang dapat direvisi.'
            ], 400);
        }

        $surat = SuratPermohonanIzinPenelitian::where('tiket_id', $tiket->uuid)->first();
        $payload = $surat ? $surat->toArray() : [];

        $tiket->update([
            'status' => 'draft',
            'payload_draft' => $payload 
        ]);

        RiwayatStatusTiket::create([
            'uuid'      => (string) Str::uuid(), 
            'tiket_id'  => $tiket->uuid,
            'users_id'  => $userId, 
            'status'    => 'draft',
            'catatan'   => 'Mahasiswa mengajukan revisi via API. Status dikembalikan ke draft.'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status tiket berhasil dikembalikan ke draft. Silakan perbarui data Anda.',
            'tiket_uuid' => $tiket->uuid
        ], 200);
    }

    /**
     * Mengunduh berkas dokumen PDF Surat Izin yang sudah disetujui/TTE.
     */
    public function downloadSignedDocument(Request $request, $uuid)
    {
        $userId = $request->user()->uuid;

        // Cari tiket milik pengguna saat ini
        $tiket = Tiket::where('uuid', $uuid)
            ->where('users_id', $userId)
            ->first();

        if (!$tiket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen tidak ditemukan.'
            ], 404);
        }

        // Validasi status penyelesaian dokumen
        if (strtolower($tiket->status) !== 'selesai') {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen belum selesai diproses atau belum ditandatangani secara elektronik (TTE).'
            ], 403);
        }

        // Path penyimpanan file PDF keluaran resmi yang sudah ditandatangani
        // Sesuaikan nama field path jika tersimpan berbeda (misal: $tiket->path_dokumen_final)
        $filePath = 'private/dokumen_selesai/' . $tiket->uuid . '.pdf';

        if (!Storage::exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File fisik dokumen tidak ditemukan di server penyimpanan.'
            ], 404);
        }

        // Return berkas langsung sebagai download stream response
        return Storage::download($filePath, 'Surat_Izin_Penelitian_' . $tiket->no_tiket . '.pdf');
    }
}