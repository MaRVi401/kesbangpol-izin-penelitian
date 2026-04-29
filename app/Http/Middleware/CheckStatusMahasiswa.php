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
            $status = Auth::user()->mahasiswa->status_akun;

            if ($status !== 'aktif') {
                Auth::logout();

                $message = ($status === 'ditolak')
                    ? 'Pendaftaran Anda ditolak. Hubungi admin.'
                    : 'Akun Anda belum aktif.';

                return redirect('/login')->withErrors(['username' => $message]);
            }
        }
        return $next($request);
    }
}
