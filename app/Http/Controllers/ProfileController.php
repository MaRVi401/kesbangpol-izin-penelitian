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
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        $roleRelation = Str::camel($user->role);
        $labelIdentitas = ($user->role === 'mahasiswa') ? 'NIM' : 'NIP';

        // Ambil nilai identitas dari relasi
        $identitas = $user->$roleRelation ? ($user->$roleRelation->nip ?? $user->$roleRelation->nim ?? '-') : '-';

        return view('pages.edit-profile', compact('user', 'labelIdentitas', 'identitas'));
    }

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
        return back()->with('info', 'Tidak ada perubahan data profil.');
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

            // Proses gambar
            $image = Image::read($file)->scale(width: 500)->encodeByExtension('webp', quality: 75);

            // Simpan ke storage/app/avatars (Disk Local = Private)
            Storage::disk('local')->put($newFilename, (string) $image);

            $user->avatar = $newFilename;
        }

        $user->save();

        JejakAudit::create([
            'users_id' => Auth::id(),
            'aksi' => 'update',
            'nama_tabel' => 'users',
            'record_id' => $user->uuid,
            'data_lama' => $dataLama,
            'data_baru' => $user->fresh()->toArray(),
            'ip_address' => $request->ip()
        ]);

        DB::commit();
        return back()->with('success', 'Profil berhasil diperbarui!');

    } catch (\Exception $e) { // Baris 113 yang sebelumnya error
        DB::rollBack();

        if ($newFilename) {
            Storage::disk('local')->delete($newFilename);
        }

        return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
    }
}
}
