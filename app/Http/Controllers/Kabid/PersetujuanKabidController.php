<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tiketMenunggu = Tiket::with(['layanan', 'users'])
            ->where('status', 'verifikasi lengkap')
            ->latest()
            ->paginate(10);

        $totalMenunggu = Tiket::where('status', 'verifikasi lengkap')->count();
        $totalDiterima = Tiket::where('status', 'diterima')->count();
        $totalDitolak = Tiket::where('status', 'ditolak')->count();

        return view('pages.kabid.dashboard', compact(
            'tiketMenunggu',
            'totalMenunggu',
            'totalDiterima',
            'totalDitolak'
        ));
    }
}