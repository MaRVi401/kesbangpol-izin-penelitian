<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function showFile($type, $filename)
    {

        $path = "verifikasi/{$type}/{$filename}";

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('local')->get($path);
        $mime = Storage::disk('local')->mimeType($path);

        return response($file, 200)->header('Content-Type', $mime);
    }
}
