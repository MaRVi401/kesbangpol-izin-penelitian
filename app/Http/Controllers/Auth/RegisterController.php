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
        // Definisi Aturan Validasi
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_wa' => 'required|string|max:15',
            'alamat' => 'required|string',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'ktm' => 'required|image|mimes:jpg,png,jpeg|max:5120',
            'surat_rekomendasi' => 'required|mimes:pdf|max:2048',
        ];

        // Memanggil Pesan Custom
        $messages = $this->customMessages();

        // Eksekusi Validasi dengan Pesan Custom
        $request->validate($rules, $messages);

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

            $img = Image::read($fileKtm)
                ->scale(width: 1200)
                ->encodeByExtension('webp', quality: 75); 

            Storage::disk('local')->put($pathKtm, (string) $img);
            $uploadedFiles[] = $pathKtm;

            // --- PROSES SURAT REKOMENDASI ---
            $pathSurat = $request->file('surat_rekomendasi')->store('verifikasi/rekomendasi', 'local');
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
                Storage::disk('local')->delete($file);
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Definisi Pesan Error Custom
     */
    private function customMessages()
    {
        return [
            'name.required'              => 'Nama lengkap wajib diisi.',
            'username.required'          => 'Username wajib diisi.',
            'username.unique'            => 'Username sudah digunakan oleh orang lain.',
            'email.required'             => 'Alamat email wajib diisi.',
            'email.email'                => 'Format email tidak valid.',
            'email.unique'               => 'Email sudah terdaftar di sistem.',
            'password.required'          => 'Password wajib diisi.',
            'password.min'               => 'Password minimal harus 8 karakter.',
            'password.confirmed'         => 'Konfirmasi password tidak cocok.',
            'no_wa.required'             => 'Nomor WhatsApp wajib diisi.',
            'no_wa.max'                  => 'Nomor WhatsApp maksimal 15 digit.',
            'alamat.required'            => 'Alamat lengkap wajib diisi.',
            'nim.required'               => 'NIM wajib diisi.',
            'nim.unique'                 => 'NIM ini sudah terdaftar.',
            'ktm.required'               => 'Foto KTM wajib diunggah.',
            'ktm.image'                  => 'File KTM harus berupa gambar.',
            'ktm.mimes'                  => 'Format KTM harus JPG, PNG, atau JPEG.',
            'ktm.max'                    => 'Ukuran foto KTM maksimal 5MB.',
            'surat_rekomendasi.required' => 'Surat rekomendasi wajib diunggah.',
            'surat_rekomendasi.mimes'    => 'Surat rekomendasi harus berformat PDF.',
            'surat_rekomendasi.max'      => 'Ukuran file surat rekomendasi maksimal 2MB.',
        ];
    }
}