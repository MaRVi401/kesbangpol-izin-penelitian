<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_wa' => 'required|string|max:15',
            'alamat' => 'required|string',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'ktm' => 'required|image|mimes:jpg,png,jpeg|max:5120',
            'surat_rekomendasi' => 'required|mimes:pdf|max:2048',
        ]);

        $uploadedFiles = [];
        DB::beginTransaction();

        try {
            $user = User::create([
                'nama' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat,
            ]);

            // --- PROSES KOMPRESI GAMBAR KTM KE WEBP ---
            $fileKtm = $request->file('ktm');
            $fileNameKtm = 'KTM_' . $request->nim . '_' . time() . '.webp';
            $pathKtm = 'verifikasi/ktm/' . $fileNameKtm;

            // Baca gambar, ubah ke WebP, dan kompres kualitas ke 70-80% (biasanya cukup untuk < 200kb)
            $img = Image::read($fileKtm)
                ->scale(width: 1200) // Resize lebar ke 1200px agar ukuran file turun drastis
                ->encodeByExtension('webp', quality: 75); 

            Storage::disk('public')->put($pathKtm, (string) $img);
            $uploadedFiles[] = $pathKtm;

            // --- PROSES SURAT REKOMENDASI (PDF TETAP PDF) ---
            $pathSurat = $request->file('surat_rekomendasi')->store('verifikasi/rekomendasi', 'public');
            $uploadedFiles[] = $pathSurat;

            Mahasiswa::create([
                'users_id' => $user->uuid, 
                'nim' => $request->nim,
                'ktm_path' => $pathKtm,
                'surat_rekomendasi_path' => $pathSurat,
                'status_akun' => 'pending',
            ]);

            DB::commit();
            return redirect('/login')->with('success', 'Registrasi berhasil.');

        } catch (\Exception $e) {
            DB::rollback();
            foreach ($uploadedFiles as $file) {
                Storage::disk('public')->delete($file);
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}