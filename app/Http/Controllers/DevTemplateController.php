<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DevTemplateController extends Controller
{
    public function index()
    {
        return view('dev.upload-template');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'template_file' => 'required|file|mimes:docx|max:2048', 
            'target_name'   => 'required|string', 
        ]);

        try {
            // 2. Ambil File
            $file = $request->file('template_file');
            $targetName = $request->target_name;

            // 3. Tentukan Disk (Sesuai config filesystems.php Anda)
            $disk = 's3'; 

            // 4. Upload ke MinIO (Timpa jika ada)
            $path = $file->storeAs('', $targetName, $disk);

            if ($path) {
                return back()->with('success', "Berhasil upload: <strong>$targetName</strong> ke MinIO ($disk).");
            } else {
                return back()->with('error', "Gagal upload ke MinIO.");
            }

        } catch (\Exception $e) {
            return back()->with('error', "Error: " . $e->getMessage());
        }
    }
}