<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratPermohonanIzinPenelitian;
use App\Models\RiwayatStatusTiket;
use Illuminate\Support\Str;

class ServiceHistoryTicketController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Tiket::with('layanan')
            ->where('users_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('no_tiket', 'like', '%' . $search . '%')
                  ->orWhereHas('layanan', function($qLayanan) use ($search) {
                      $qLayanan->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        $tickets = $query->latest('updated_at')->paginate(10);

        return view('pages.mahasiswa.history_ticket.index', compact('tickets'));
    }


    public function revisi($uuid)
    {
        
        $tiket = Tiket::where('uuid', $uuid)
            ->where('users_id', Auth::user()->uuid)
            ->firstOrFail();

        
        if (!in_array(strtolower($tiket->status), ['ditolak', 'verifikasi gagal'])) {
            return redirect()->back()->with('error', 'Hanya tiket dengan status Ditolak atau Verifikasi Gagal yang dapat direvisi.');
        }

        
        $surat = SuratPermohonanIzinPenelitian::where('tiket_id', $tiket->uuid)->first();
        
        $payload = [];
        if ($surat) {
            $payload = $surat->toArray();
            
            
        }

        
        $tiket->update([
            'status' => 'draft',
            'payload_draft' => $payload 
        ]);

        // 5. Catat ke riwayat
        RiwayatStatusTiket::create([
            'uuid'      => (string) Str::uuid(), 
            'tiket_id'  => $tiket->uuid,
            'users_id'  => Auth::user()->uuid, 
            'status'    => 'draft',
            'catatan'   => 'Mahasiswa mengajukan revisi. Status dikembalikan ke draft.'
        ]);

        
        return redirect()->route('services.index')->with('success', 'Silakan perbarui data pengajuan Anda.');
    }
}