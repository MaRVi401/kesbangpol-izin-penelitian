<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Storage, DB};
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use App\Models\JejakAudit;

class ApiProfileController extends Controller
{
    /**
     * Mendapatkan data profil pengguna yang sedang login.
     */
    public function show(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $roleRelation = Str::camel($user->role);
        
        // Mengambil data identitas (NIM/NIP) dari relasi role
        $identitas = $user->$roleRelation ? ($user->$roleRelation->nip ?? $user->$roleRelation->nim ?? '-') : '-';
        $labelIdentitas = ($user->role === 'mahasiswa') ? 'NIM' : 'NIP';

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'label_identitas' => $labelIdentitas,
                'identitas' => $identitas
            ]
        ], 200);
    }

    /**
     * Memperbarui profil pengguna melalui API.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'no_wa'    => 'nullable|string|min:10|max:15|regex:/^[0-9]+$/',
            'alamat'   => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $dataLama = $user->getRawOriginal();

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_wa = $request->no_wa;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $hasNewFile = $request->hasFile('avatar');

        if (!$user->isDirty() && !$hasNewFile) {
            return response()->json([
                'status' => 'info',
                'message' => 'Tidak ada perubahan data profil.'
            ], 200);
        }

        DB::beginTransaction();
        $newFilename = null;

        try {
            if ($hasNewFile) {
                // Hapus file lama dari storage privat jika ada
                if ($user->avatar) {
                    Storage::disk('local')->delete($user->avatar);
                }

                $file = $request->file('avatar');
                $newFilename = 'avatars/' . Str::random(40) . '.webp';

                // Proses kompresi gambar
                $image = Image::read($file)->scale(width: 500)->encodeByExtension('webp', quality: 75);

                // Simpan ke storage/app/avatars (Disk Local)
                Storage::disk('local')->put($newFilename, (string) $image);

                $user->avatar = $newFilename;
            }

            $user->save();

            // Pencatatan log aktivitas sistem
            JejakAudit::create([
                'users_id' => $user->id,
                'aksi' => 'update',
                'nama_tabel' => 'users',
                'record_id' => $user->uuid,
                'data_lama' => $dataLama,
                'data_baru' => $user->fresh()->toArray(),
                'ip_address' => $request->ip()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui!',
                'data' => $user->fresh()
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($newFilename) {
                Storage::disk('local')->delete($newFilename);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }
}