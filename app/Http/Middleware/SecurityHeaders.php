<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Vite;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Generate Nonce unik untuk setiap request
        $nonce = Str::random(32);

        // 2. Bagikan nonce ke semua view Blade
        View::share('csp_nonce', $nonce);

        Vite::useCspNonce($nonce);

        $response = $next($request);

        // Dapatkan base URL dan WebSocket URL untuk digunakan dalam CSP
        $baseUrl = $request->getSchemeAndHttpHost();
        $wsUrl = "ws://" . $request->getHost() . ":*";
        $allowedHosts = "{$baseUrl} http://127.0.0.1:* http://localhost:*";

        // $baseUrl = $request->getSchemeAndHttpHost();
        
        
        // $wsUrl = "ws://" . $request->getHost() . ":5173";
        
        // $viteHost = "http://" . $request->getHost() . ":5173"; 
        
        // $allowedHosts = "{$baseUrl} {$viteHost} http://127.0.0.1:5173 http://localhost:5173";


        // 3. Konfigurasi Content Security Policy (CSP)
        $cspPolicy = [
            "default-src 'self'",

            /*  */

            // 'unsafe-eval' diperlukan oleh beberapa fungsi library Chart.js/Flowbite
            "script-src 'self' 'nonce-{$nonce}' 'unsafe-inline' 'unsafe-eval' data: https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.xcom https://cdn.tailwindcss.com {$allowedHosts}",

            // Menangani inline event handlers seperti onclick/onchange di HTML
            "script-src-attr 'unsafe-inline'",

            // Style: Mendukung Vite, Google Fonts, dan JSDelivr (untuk Tabler Icons)
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net {$allowedHosts}",

            // Image: Mendukung S3 Amazon, UI-Avatars, port MinIO/S3 lokal (9000), dan data URI
            "img-src 'self' data: https://flowbite.s3.amazonaws.com https://ui-avatars.com https://*.ui-avatars.com {$allowedHosts}",

            // Font: Mendukung Google Fonts dan Font-face dari JSDelivr
            "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",

            // Connect: Penting untuk WebSocket Vite (HMR) dan pemanggilan API eksternal
            "connect-src 'self' data: {$wsUrl} {$allowedHosts} https://cdn.jsdelivr.net",

            "object-src 'none'",
            "base-uri 'self'",
            // "upgrade-insecure-requests", // Aktifkan jika semua konten harus dimuat melalui HTTPS
        ];

        // 4. Set Semua Security Headers
        $response->headers->set('Content-Security-Policy', implode('; ', $cspPolicy));
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(), geolocation=()');

        // Menghapus X-Powered-By agar versi PHP tidak terlihat
        $response->headers->remove('X-Powered-By');

        // 5. HSTS (Hanya aktif jika menggunakan HTTPS)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}