<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Analytic Operator
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $userUuid = $user->uuid; 

        // 1. Statistik Global (Tiket yang belum diambil oleh siapapun)
        $totalMasuk = Tiket::where('status', 'diajukan')
            ->whereNull('petugas_id')
            ->count();

        // 2. Statistik Meja Kerja (Tiket yang sedang ditangani oleh operator login)
        $sedangDitangani = Tiket::where('status', 'ditangani')
            ->where('petugas_id', $userUuid)
            ->count();

        // 3. Statistik Performa Pribadi (Total tiket yang sudah diselesaikan/ditolak)
        $totalSelesai = Tiket::where('status', 'selesai')
            ->where('petugas_id', $userUuid)
            ->count();

        $totalDitolak = Tiket::where('status', 'ditolak')
            ->where('petugas_id', $userUuid)
            ->count();

        // 4. Data Tren Penanganan (7 Hari Terakhir) untuk keperluan grafik
        $trenData = DB::table('riwayat_status_tiket')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('users_id', $userUuid)
            ->whereIn('status', ['selesai', 'ditolak'])
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 5. List Tiket Terbaru di Meja Kerja untuk ringkasan dashboard
        $recentTickets = Tiket::with(['user', 'layanan'])
            ->where('petugas_id', $userUuid)
            ->where('status', 'ditangani')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.operator.dashboard', compact(
            'totalMasuk', 
            'sedangDitangani', 
            'totalSelesai', 
            'totalDitolak', 
            'trenData',
            'recentTickets'
        ));
    }
}