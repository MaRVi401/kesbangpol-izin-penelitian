<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $roleData = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', \Carbon\Carbon::today())->count(),
            'total_roles' => $roleData->count(),
        ];

        $chartData = [
            'labels' => $roleData->pluck('role')->map(fn($role) => Str::title(str_replace(['_', '-'], ' ', $role))),
            'data' => $roleData->pluck('total'),
        ];

        return view('pages.super-admin.dashboard', compact('stats', 'chartData'));
    }
}
