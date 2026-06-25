<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function cekKeaslian($uuid)
    {
        $tiket = Tiket::with('suratIzinPenelitian')
            ->where('uuid', $uuid)
            ->first();

        if (!$tiket) {
            return view('verifikasi.dokumen', [
                'isValid' => false,
                'message' => 'Dokumen tidak ditemukan di dalam sistem kami.'
            ]);
        }

        if ($tiket->status !== 'ditandatangani') {
            return view('verifikasi.dokumen', [
                'isValid' => false,
                'message' => 'Dokumen ini belum berstatus ditandatangani secara sah (Status saat ini: ' . $tiket->status . ').'
            ]);
        }

        return view('verifikasi.dokumen', [
            'isValid' => true,
            'tiket' => $tiket,
            'surat' => $tiket->suratIzinPenelitian
        ]);
    }
}