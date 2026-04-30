<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($path)
    {
        // 1. Cek eksistensi file di disk local
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        // 2. Logika Keamanan Tambahan (Opsional)
        if (auth()->user()->role !== 'super-admin' && !str_contains($path, auth()->id())) {
            abort(403);
        }

        // 3. Mengembalikan file untuk ditampilkan di browser
        return Storage::disk('local')->response($path);
    }
}
