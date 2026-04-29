<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:mahasiswa',
            'ktm' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'surat_rekomendasi' => 'required|file|mimes:pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan user baru
            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
            ]);

            // 2. Upload dokumen ke storage/app/public
            $ktmPath = $request->file('ktm')->store('dokumen/mahasiswa/ktm', 'public');
            $suratPath = $request->file('surat_rekomendasi')->store('dokumen/mahasiswa/rekomendasi', 'public');

            // 3. Simpan data spesifik mahasiswa (status otomatis pending dari DB)
            Mahasiswa::create([
                'users_id' => $user->uuid,
                'nim' => $request->nim,
                'status_akun' => 'pending',
                'ktm_path' => $ktmPath,
                'surat_rekomendasi_path' => $suratPath,
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan tunggu verifikasi admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat registrasi.');
        }
    }
}
