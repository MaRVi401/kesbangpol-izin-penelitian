<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kabidProfile = $request->user()->kabid;

        if (!$kabidProfile) {
            abort(403, 'Akses ditolak. Profil Kabid tidak ditemukan.');
        }

        $tiketMenunggu = Tiket::with(['layanan', 'user', 'suratIzinPenelitian'])
            ->where('status', 'verifikasi lengkap')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                $query->where('penandatangan_id', $kabidProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kabid::class);
            })
            ->latest()
            ->paginate(10, ['*'], 'antrean_page');

        $tiketHistory = Tiket::with(['layanan', 'user', 'suratIzinPenelitian'])
            ->whereIn('status', ['ditandatangani', 'ditolak']) // Ubah 'diterima' menjadi 'ditandatangani'
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                $query->where('penandatangan_id', $kabidProfile->uuid)
                    ->where('penandatangan_type', \App\Models\Kabid::class);
            })
            ->latest()
            ->paginate(10, ['*'], 'history_page');

        $totalMenunggu = Tiket::where('status', 'verifikasi lengkap')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                $query->where('penandatangan_id', $kabidProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kabid::class);
            })->count();
            
        $totalDiterima = Tiket::where('status', 'diterima')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                $query->where('penandatangan_id', $kabidProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kabid::class);
            })->count();
            
        $totalDitolak = Tiket::where('status', 'ditolak')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabidProfile) {
                $query->where('penandatangan_id', $kabidProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kabid::class);
            })->count();

        return view('pages.kabid.dashboard', compact(
            'tiketMenunggu',
            'tiketHistory',
            'totalMenunggu',
            'totalDiterima',
            'totalDitolak'
        ));
    }
}