<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\JejakAudit;

class DetailSuratIzinPermohonan extends Controller
{
    public function index(Request $request)
    {
        $query = Tiket::with('layanan')->where('users_id', Auth::user()->uuid);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', '!=', 'selesai');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('status', 'LIKE', "%{$search}%")
                ->orWhereHas('layanan', function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'LIKE', "%{$search}%");
                });
            });
        }

        $tickets = $query->latest()->paginate(10);

        return view('pages.mahasiswa.DetailSuratIzin.index', compact('tickets'));
    }

    public function show($uuid)
    {
        $ticket = Tiket::with([
            'layanan',
            'detailEmailGov',
            'detailSubdomain',
            'detailApps',
            'detailPengaduan',
            'komentar.user'
        ])
        ->where('uuid', $uuid)
        ->where('users_id', Auth::user()->uuid)
        ->firstOrFail();

        $kategoriEmail = null;

        if ($ticket->detailEmailGov) {
            if (!empty($ticket->detailEmailGov->pd_jenis_layanan) || !empty($ticket->detailEmailGov->pd_instansi_nama)) {
                $kategoriEmail = 'perangkat_daerah';
            } elseif (!empty($ticket->detailEmailGov->asn_jenis_layanan) || !empty($ticket->detailEmailGov->asn_nip)) {
                $kategoriEmail = 'asn';
            }
        }

        // Menghitung jumlah revisi berdasarkan riwayat komentar dari admin
        $jumlahRevisi = $ticket->komentar->count();

        return view('pages.pengguna-asn.submission.show', compact('ticket', 'kategoriEmail', 'jumlahRevisi'));
    }

    public function destroy($uuid)
    {
        $ticket = Tiket::where('uuid', $uuid)
            ->where('users_id', Auth::user()->uuid)
            ->firstOrFail();


        if ($ticket->lampiran) {

            if (Storage::disk('s3')->exists($ticket->lampiran)) {
                Storage::disk('s3')->delete($ticket->lampiran);
            }
        }
        JejakAudit::create([
            'users_id' => Auth::id(),
            'aksi' => 'delete',
            'nama_tabel' => 'tiket',
            'record_id' => $ticket->uuid,
            'data_lama' => $ticket->toArray(),
            'ip_address' => request()->ip()
        ]);

        $ticket->delete();

        return redirect()->route('detail.index')->with('success', 'Tiket dan lampiran dokumen berhasil dihapus.');
    }

}
