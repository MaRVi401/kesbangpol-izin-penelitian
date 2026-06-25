<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Tiket;

class FileController extends Controller
{
    public function show($path)
    {
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $user = auth()->user();

        if (in_array($user->role, ['super_admin', 'operator'])) {
            return Storage::disk('local')->response($path);
        }

        if (str_contains($path, $user->uuid)) {
            return Storage::disk('local')->response($path);
        }

        if (str_contains($path, 'surat_izin/signed/signed_')) {
            $filename = basename($path); 
            $noTiket = str_replace(['signed_', '.pdf'], '', $filename);

            $tiketMilikUser = Tiket::where('no_tiket', $noTiket)
                                   ->where('users_id', $user->uuid)
                                   ->exists();

            if ($tiketMilikUser) {
                return Storage::disk('local')->response($path);
            }
        }

        abort(403);
    }
}