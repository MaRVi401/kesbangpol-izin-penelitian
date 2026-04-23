<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            // Dashboard Super Admin
            'super_admin'  => app(Admin\DashboardController::class)->index(),

            // Dashboard Operator
            'operator'     => app(Operator\DashboardController::class)->index(request()),
            
            // Dashboard Kabid
            'kabid'        => app(Kabid\DashboardController::class)->index(request()),
            
            // Dashboard Kadis
            'kadis'        => app(Kadis\DashboardController::class)->index(),

            // Dashboard Pengguna ASN
            'pengguna_asn' => app(PenggunaAsn\DashboardControllerPenggunaAsn::class)->index(request()),

            default        => abort(403, 'Role tidak dikenali.'),
        };
    }
}
