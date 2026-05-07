<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tiketMenunggu = Tiket::with(['layanan', 'user', 'suratIzinPenelitian'])
            ->where('status', 'verifikasi lengkap')
            ->latest()
            ->paginate(10, ['*'], 'antrean_page');

        $tiketHistory = Tiket::with(['layanan', 'user', 'suratIzinPenelitian'])
            ->whereIn('status', ['diterima', 'ditolak'])
            ->latest()
            ->paginate(10, ['*'], 'history_page');

        $totalMenunggu = Tiket::where('status', 'verifikasi lengkap')->count();
        $totalDiterima = Tiket::where('status', 'diterima')->count();
        $totalDitolak = Tiket::where('status', 'ditolak')->count();

        return view('pages.kabid.dashboard', compact(
            'tiketMenunggu',
            'tiketHistory',
            'totalMenunggu',
            'totalDiterima',
            'totalDitolak'
        ));
    }
}