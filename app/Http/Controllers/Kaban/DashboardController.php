<?php

namespace App\Http\Controllers\Kaban;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kabanProfile = $request->user()->kaban;

        if (!$kabanProfile) {
            abort(403, 'Akses ditolak. Profil Kaban tidak ditemukan.');
        }

        $tiketMenunggu = Tiket::with(['layanan', 'user', 'suratIzinPenelitian'])
            ->where('status', 'verifikasi lengkap')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                $query->where('penandatangan_id', $kabanProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kaban::class);
            })
            ->latest()
            ->paginate(10, ['*'], 'antrean_page');

        $tiketHistory = Tiket::with(['layanan', 'user', 'suratIzinPenelitian'])
            ->whereIn('status', ['ditandatangani', 'ditolak']) 
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                $query->where('penandatangan_id', $kabanProfile->uuid)
                    ->where('penandatangan_type', \App\Models\Kaban::class);
            })
            ->latest()
            ->paginate(10, ['*'], 'history_page');

        $totalMenunggu = Tiket::where('status', 'verifikasi lengkap')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                $query->where('penandatangan_id', $kabanProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kaban::class);
            })->count();
            
        $totalDiterima = Tiket::where('status', 'diterima')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                $query->where('penandatangan_id', $kabanProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kaban::class);
            })->count();
            
        $totalDitolak = Tiket::where('status', 'ditolak')
            ->whereHas('suratIzinPenelitian', function ($query) use ($kabanProfile) {
                $query->where('penandatangan_id', $kabanProfile->uuid)
                      ->where('penandatangan_type', \App\Models\Kaban::class);
            })->count();

        return view('pages.kaban.dashboard', compact(
            'tiketMenunggu',
            'tiketHistory',
            'totalMenunggu',
            'totalDiterima',
            'totalDitolak'
        ));
    }
}