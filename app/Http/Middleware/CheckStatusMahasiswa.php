<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStatusMahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'mahasiswa') {
            if (Auth::user()->mahasiswa->status_akun !== 'aktif') {
                Auth::logout();
                return redirect('/login')->withErrors(['username' => 'Akun Anda belum aktif.']);
            }
        }
        return $next($request);
    }
}
