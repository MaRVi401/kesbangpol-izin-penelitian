<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Set CSP Nonce untuk Vite agar bisa digunakan di Blade templates
        Vite::useCspNonce(request()->attributes->get('csp_nonce'));

        // Gate untuk Middleware 'can:super-admin-only'
        Gate::define('super-admin-only', function (User $user) {
            return $user->role === 'super_admin';
        });

        // Gate untuk Middleware 'can:pengguna_asn
        Gate::define('pengguna_asn-only', function (User $user) {
            return $user->role === 'pengguna_asn';
        });

        // Gate untuk Middleware 'can:operator-only'
        Gate::define('operator-only', function (User $user) {
            return $user->role === 'operator';
        });

        // Gate untuk Middleware 'can:kabid-only'
        Gate::define('kabid-only', function (User $user) {
            return $user->role === 'kabid';
        });

        // Gate untuk Middleware 'can:kadis-only'
        Gate::define('kadis-only', function (User $user) {
            return $user->role === 'kadis';
        });

        // View Composer hanya berjalan saat view 'partials.dashboard.sidebar' dipanggil
        View::composer('partials.dashboard.sidebar', function ($view) {

            // Mengambil file JSON
            $path = resource_path('json/menu.json');
            $menuData = json_decode(file_get_contents($path), true);

            // Gunakan Auth::user() yang lebih eksplisit
            $user = Auth::user();
            $userRole = $user ? $user->role : null;

            // Cari menu yang sesuai dengan role
            $filteredMenu = collect($menuData['menu'])->firstWhere('role', $userRole);

            // Kirim data ke view
            $view->with('verticalMenu', $filteredMenu['items'] ?? []);
        });
    }
}