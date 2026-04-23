<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage, DB};
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use App\Models\JejakAudit;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil dengan data NIP.
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        $roleRelation = Str::camel($user->role);
        $nip = $user->$roleRelation ? $user->$roleRelation->nip : '-';

        return view('pages.edit-profile', compact('user', 'nip'));
    }

    /**
     * Memproses pembaruan profil secara atomik (DB & S3).
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->uuid, 'uuid')],
            'no_wa'    => 'nullable|string|min:10|max:15|regex:/^[0-9]+$/',
            'alamat'   => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'avatar.max'         => 'Ukuran foto profil tidak boleh lebih dari 2 MB.',
            'avatar.image'       => 'File yang diunggah harus berupa gambar.',
            'avatar.mimes'       => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'no_wa.max'          => 'Nomor WhatsApp tidak boleh lebih dari 15 digit.',
            'no_wa.min'          => 'Nomor WhatsApp minimal 10 digit.',
            'no_wa.regex'        => 'Nomor WhatsApp hanya boleh berisi angka.',
        ]);

        $inputData = $request->only(['nama', 'username', 'email', 'no_wa', 'alamat']);
        $user->fill($inputData);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $hasNewFile = $request->hasFile('avatar');

        if (!$user->isDirty() && !$hasNewFile) {
            return back()->with('info', 'Tidak ada perubahan data profil.');
        }

        DB::beginTransaction();
        $newFilename = null;

        try {
            $oldAvatar = $user->getOriginal('avatar');

            if ($hasNewFile) {
                $file = $request->file('avatar');
                $newFilename = 'avatars/avatar_' . $user->uuid . '_' . time() . '.webp';
                $image = Image::read($file);
                $image->scale(width: 500);
                $encoded = $image->toWebp(quality: 75);

                Storage::disk('s3')->put($newFilename, (string) $encoded);

                $user->avatar = $newFilename;
            }

            $user->save();
            if ($hasNewFile && $oldAvatar && Storage::disk('s3')->exists($oldAvatar)) {
                Storage::disk('s3')->delete($oldAvatar);
            }

            JejakAudit::create([
                'users_id' => Auth::id(),
                'aksi' => 'update',
                'nama_tabel' => 'users',
                'record_id' => $user->uuid,
                'data_lama' => $user->getOriginal(),
                'data_baru' => $user->fresh()->toArray(),
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($newFilename && Storage::disk('s3')->exists($newFilename)) {
                Storage::disk('s3')->delete($newFilename);
            }

            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
