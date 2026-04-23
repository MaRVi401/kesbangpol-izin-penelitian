<?php

namespace App\Http\Controllers\PenggunaAsn;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardControllerPenggunaAsn extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $userUuid = $user->uuid; 

        // 1. Tiket Menunggu (Belum diproses / Sedang Antre)
        $totalDiajukan = Tiket::where('users_id', $userUuid)
            ->whereIn('status', ['belum diajukan', 'diajukan'])
            ->count();

        // 2. Tiket Sedang Diproses (Sudah diambil oleh operator)
        $totalDiproses = Tiket::where('users_id', $userUuid)
            ->where('status', 'ditangani')
            ->count();

        // 3. Total Tiket Selesai
        $totalSelesai = Tiket::where('users_id', $userUuid)
            ->where('status', 'selesai')
            ->count();

        // 4. Total Tiket Ditolak
        $totalDitolak = Tiket::where('users_id', $userUuid)
            ->where('status', 'ditolak')
            ->count();

        // 5. Data Tren Pengajuan Layanan (7 Hari Terakhir)
        $trenData = DB::table('tiket')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('users_id', $userUuid)
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 6. List Tiket Terbaru milik pengguna
        $recentTickets = Tiket::with(['layanan'])
            ->where('users_id', $userUuid)
            ->latest()
            ->take(5)
            ->get();

        return view('pages.pengguna-asn.dashboard', compact(
            'totalDiajukan', 
            'totalDiproses', 
            'totalSelesai', 
            'totalDitolak', 
            'trenData',
            'recentTickets'
        ));
    }
}