<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($path)
    {
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        // Izinkan super_admin melihat semua file, 
        if (auth()->user()->role !== 'super_admin' && !str_contains($path, auth()->id())) {
            abort(403);
        }

        return Storage::disk('local')->response($path);
    }
}
