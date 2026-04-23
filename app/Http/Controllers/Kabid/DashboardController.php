<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PrioritasTiketKadis;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $countStatus = Tiket::selectRaw("
        count(*) as total,
        count(case when status = 'diajukan' then 1 end) as diajukan,
        count(case when status = 'ditangani' then 1 end) as ditangani,
        count(case when status = 'selesai' then 1 end) as selesai,
        count(case when status = 'ditolak' then 1 end) as ditolak
    ")->first();

    $layananAktif = Layanan::count();

    $totalDiproses = $countStatus->selesai + $countStatus->ditangani;
    $tingkatPenyelesaian = $totalDiproses > 0
        ? round(($countStatus->selesai / $totalDiproses) * 100)
        : 0;

    $tiketSudahDiusulkan = PrioritasTiketKadis::pluck('tiket_id')->toArray();

    $operatorPerformance = User::where('role', 'operator')
        ->withCount([
            'tiketDitangani as total_handle',
            'tiketDitangani as total_selesai' => function ($query) {
                $query->where('status', 'selesai');
            },
            'tiketDitangani as total_eligible' => function ($query) use ($tiketSudahDiusulkan) {
                $query->whereIn('status', ['selesai', 'ditolak'])
                      ->whereNotIn('uuid', $tiketSudahDiusulkan);
            }
        ])
        ->paginate(5, ['*'], 'op_page');

    $chartData = [
        'labels' => ['Diajukan', 'Ditangani', 'Selesai', 'Ditolak'],
        'data'   => [
            (int) $countStatus->diajukan,
            (int) $countStatus->ditangani,
            (int) $countStatus->selesai,
            (int) $countStatus->ditolak
        ]
    ];

    $stats = [
        'total'   => $countStatus->total,
        'selesai' => $countStatus->selesai,
        'proses'  => $countStatus->ditangani,
    ];

    if ($request->ajax()) {
        return view('pages.kabid._operator_table', compact('operatorPerformance', 'stats'))->render();
    }

    $tiketEligible = Tiket::with(['layanan', 'komentar.user'])
        ->whereIn('status', ['ditolak', 'selesai'])
        ->whereNotIn('uuid', $tiketSudahDiusulkan)
        ->get();
            
    $kadis = User::where('role', 'kadis')->first();

    $usulanTerkirim = PrioritasTiketKadis::with(['tiket'])
        ->where('pengusul_id', auth()->user()->uuid)
        ->latest()
        ->paginate(5, ['*'], 'usulan_page');

    return view('pages.kabid.dashboard', compact(
        'layananAktif',
        'tingkatPenyelesaian',
        'stats',
        'chartData',
        'operatorPerformance',
        'tiketEligible',
        'kadis',
        'usulanTerkirim'
    ));
}
}
