<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogKeamanan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AuthController extends Controller
{
    /**
     * Login API
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required', 'min:8'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        if (!Auth::attempt($credentials)) {

            $failedCount = LogKeamanan::where('ip_address', $ipAddress)
                ->where('tipe_event', 'login_gagal')
                ->where('created_at', '>=', now()->subMinutes(10))
                ->count();

            LogKeamanan::create([
                'users_id' => null,
                'username_attempt' => $request->username,
                'tipe_event' => 'login_gagal',
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'is_suspicious' => $failedCount >= 4,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Kredensial tidak cocok.',
            ], 401);
        }

        $user = Auth::user();

        /**
         * Cek status mahasiswa
         */
        if ($user->role === 'mahasiswa') {

            $status = $user->mahasiswa->status_akun ?? null;

            if ($status !== 'aktif') {

                Auth::logout();

                $message = 'Akun Anda belum aktif. Silakan tunggu verifikasi admin.';

                if ($status === 'ditolak') {
                    $message = 'Mohon maaf, pendaftaran akun Anda ditolak. Silakan hubungi admin.';
                }

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 403);
            }
        }

        LogKeamanan::create([
            'users_id' => $user->uuid,
            'username_attempt' => $user->username,
            'tipe_event' => 'login_sukses',
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'is_suspicious' => false,
        ]);

        $token = $user->createToken('flutter')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'token' => $token,
            'token_type' => 'Bearer',
            'data' => $user->load('mahasiswa'),
        ]);
    }

    /**
     * Register API
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_wa' => 'required|regex:/^[0-9]+$/|min:10|max:15',
            'alamat' => 'required|string',
            'nim' => 'required|string|max:20|unique:mahasiswa,nim',
            'ktm' => 'required|image|mimes:jpg,png,jpeg|max:5120',
            'surat_rekomendasi' => 'required|mimes:pdf|max:2048',
        ];

        $messages = $this->customMessages();

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

            /**
             * KTM
             */
            $fileKtm = $request->file('ktm');

            $fileNameKtm = 'KTM_' . $request->nim . '_' . time() . '.webp';

            $pathKtm = 'verifikasi/ktm/' . $fileNameKtm;

            $img = Image::read($fileKtm)
                ->scale(width: 1200)
                ->encodeByExtension('webp', quality: 75);

            Storage::disk('local')->put($pathKtm, (string) $img);

            $uploadedFiles[] = $pathKtm;

            /**
             * Surat rekomendasi
             */
            $pathSurat = $request->file('surat_rekomendasi')
                ->store('verifikasi/rekomendasi', 'local');

            $uploadedFiles[] = $pathSurat;

            Mahasiswa::create([
                'users_id' => $user->uuid,
                'nim' => $request->nim,
                'ktm_path' => $pathKtm,
                'surat_rekomendasi_path' => $pathSurat,
                'status_akun' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil. Silakan tunggu verifikasi admin.',
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            foreach ($uploadedFiles as $file) {
                Storage::disk('local')->delete($file);
            }

            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout API
     */
    public function logout(Request $request)
    {
        LogKeamanan::create([
            'users_id' => $request->user()->uuid,
            'username_attempt' => $request->user()->username,
            'tipe_event' => 'logout',
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'is_suspicious' => false,
        ]);

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * Custom Validation Messages
     */
    private function customMessages()
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh angka.',
            'no_wa.min' => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 15 digit.',
            'alamat.required' => 'Alamat wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'ktm.required' => 'Foto KTM wajib diunggah.',
            'ktm.image' => 'KTM harus berupa gambar.',
            'ktm.mimes' => 'Format KTM harus JPG, JPEG, atau PNG.',
            'ktm.max' => 'Ukuran KTM maksimal 5MB.',
            'surat_rekomendasi.required' => 'Surat rekomendasi wajib diunggah.',
            'surat_rekomendasi.mimes' => 'Surat rekomendasi harus PDF.',
            'surat_rekomendasi.max' => 'Ukuran surat rekomendasi maksimal 2MB.',
        ];
    }
}