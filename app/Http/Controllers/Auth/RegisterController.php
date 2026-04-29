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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_wa' => 'required|string|max:15',
            'alamat' => 'required|string',
            'nim' => 'required|string|max:20',
            'ktm' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'surat_rekomendasi' => 'required|mimes:pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan ke tabel Users (sesuaikan kolom 'nama')
            $user = User::create([
                'nama' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat,
            ]);

            // 2. Handle Upload File
            $pathKtm = $request->file('ktm')->store('verifikasi/ktm', 'public');
            $pathSurat = $request->file('surat_rekomendasi')->store('verifikasi/rekomendasi', 'public');

            // 3. Simpan ke tabel Mahasiswa
            Mahasiswa::create([
                'users_id' => $user->uuid, // Menggunakan uuid sesuai schema kamu
                'nim' => $request->nim,
                'ktm_path' => $pathKtm,
                'surat_rekomendasi_path' => $pathSurat,
                'status_akun' => 'pending',
            ]);

            DB::commit();
            return redirect('/login')->with('success', 'Registrasi berhasil. Silakan tunggu verifikasi admin.');
        } catch (\Exception $e) {
            DB::rollback();
            // Log error jika perlu: Log::error($e->getMessage());
            return back()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }
}
