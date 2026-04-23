<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SuperAdmin;
use App\Models\PenggunaAsn;
use App\Models\Kabid;
use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use App\Models\JejakAudit;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the users with Search & Pagination.
     */
    public function index(Request $request)
    {
        $query = User::query()->where('uuid', '!=', Auth::id());

        // Filter logic
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search Logic
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    // Cari di tabel relasi detail (NIP)
                    ->orWhereHas('superAdmin', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('penggunaAsn', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('kabid', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('operator', function ($sq) use ($search) {
                        $sq->where('nip', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Use paginate for Flowbite pagination support
        $users = $query->latest()->paginate(10);

        return view('pages.super-admin.user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('pages.super-admin.user-management.create');
    }

    /**
     * Store a newly created user in Minio (S3).
     */
    public function store(Request $request)
    {
        $rules = [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'role'     => 'required|in:super_admin,pengguna_asn,kabid,operator',
            'nip'      => 'required|numeric|digits:18',
            'no_wa'    => 'nullable|numeric|digits_between:10,13',
            'password' => 'required|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
        $messages = $this->customMessages();

        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = 'avatars/' . Str::random(40) . '.webp';
                $image = Image::read($file)->scale(width: 500)->encodeByExtension('webp', quality: 75);
                Storage::disk('s3')->put($filename, (string) $image);
                $avatarPath = $filename;
            }

            // Simpan User Utama
            $user = User::create([
                'nama'     => $request->nama,
                'email'    => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
                'alamat'   => $request->alamat,
                'no_wa'    => $request->no_wa,
                'avatar'   => $avatarPath,
            ]);

            // Simpan Detail Role (NIP)
            $this->getRoleModel($request->role)::create([
                'uuid'     => (string) Str::uuid(),
                'users_id' => $user->uuid,
                'nip'      => $request->nip,
            ]);

            // Catat Audit setelah data berhasil dibuat
            JejakAudit::create([
                'users_id' => Auth::id(),
                'aksi' => 'create',
                'nama_tabel' => 'users',
                'record_id' => $user->uuid,
                'data_baru' => $user->toArray(),
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            return redirect()->route('user-management.index')->with('success', 'User baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal sistem: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roleRelation = Str::camel($user->role);
        $nip = $user->$roleRelation ? $user->$roleRelation->nip : '';

        return view('pages.super-admin.user-management.edit', compact('user', 'nip'));
    }

    /**
     * Update user data and sync Minio (S3) storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->uuid . ',uuid',
            'username' => 'required|string|unique:users,username,' . $user->uuid . ',uuid',
            'role'     => 'required|in:super_admin,pengguna_asn,kabid,operator',
            'nip'      => 'required|numeric|digits:18',
            'no_wa'    => 'nullable|numeric|digits_between:10,13',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ];
        $messages = $this->customMessages();
        $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $oldRole = $user->getOriginal('role');
            $dataLama = $user->getRawOriginal();

            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->no_wa = $request->no_wa;
            $user->alamat = $request->alamat;
            $user->role = $request->role;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('s3')->delete($user->avatar);
                }
                $filename = 'avatars/' . Str::random(40) . '.webp';
                $image = Image::read($request->file('avatar'))->scale(width: 500)->encodeByExtension('webp', quality: 75);
                Storage::disk('s3')->put($filename, (string) $image);
                $user->avatar = $filename;
            }

            $user->save();

            // Sinkronisasi Tabel Role
            if ($oldRole !== $request->role) {
                $this->getRoleModel($oldRole)::where('users_id', $user->uuid)->delete();
                $this->getRoleModel($request->role)::create([
                    'uuid' => (string) Str::uuid(),
                    'users_id' => $user->uuid,
                    'nip' => $request->nip,
                ]);
            } else {
                // Gunakan updateOrCreate untuk memastikan record detail role ada
                $this->getRoleModel($request->role)::updateOrCreate(
                    ['users_id' => $user->uuid],
                    ['nip' => $request->nip]
                );
            }

            JejakAudit::create([
                'users_id' => Auth::id(),
                'aksi' => 'update',
                'nama_tabel' => 'users',
                'record_id' => $user->uuid,
                'data_lama' => $dataLama,
                'data_baru' => $user->fresh()->toArray(),
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            return redirect()->route('user-management.index')->with('success', 'Profil user diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove user and clean up Minio (S3) storage.
     */
    public function destroy(User $user)
    {
        // 1. Validasi: Jangan hapus diri sendiri
        if ($user->uuid === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        // 2. Validasi Relasi: Cek apakah user ini masih dirujuk oleh tabel tiket
        if ($user->tiketDitangani()->exists() || $user->tiketDibuat()->exists()) {
            return back()->with('error', 'User ini masih memiliki riwayat tiket yang terdaftar.');
        }

        // 3. Proses hapus jika tidak ada relasi
        DB::beginTransaction();
        try {
            if ($user->avatar) {
                Storage::disk('s3')->delete($user->avatar);
            }

            JejakAudit::create([
                'users_id' => Auth::id(),
                'aksi' => 'delete',
                'nama_tabel' => 'users',
                'record_id' => $user->uuid,
                'data_lama' => $user->toArray(),
                'ip_address' => request()->ip()
            ]);

            $user->delete();
            DB::commit();

            return redirect()->route('user-management.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Helper to get Role Model class.
     */
    private function getRoleModel($role)
    {
        return [
            'super_admin'  => SuperAdmin::class,
            'pengguna_asn' => PenggunaAsn::class,
            'kabid'        => Kabid::class,
            'operator'     => Operator::class,
        ][$role];
    }

    private function customMessages()
    {
        return [
            'nama.required'     => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar di sistem.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan.',
            'nip.required'      => 'NIP wajib diisi.',
            'nip.numeric'       => 'NIP harus berupa angka.',
            'nip.digits'        => 'NIP harus berjumlah 18 digit.',
            'no_wa.numeric'     => 'Nomor WhatsApp harus berupa angka.',
            'no_wa.digits_between' => 'Nomor WhatsApp harus berjumlah antara 10 sampai 13 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'avatar.image'      => 'File yang diunggah harus berupa gambar.',
            'avatar.mimes'      => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'avatar.max'        => 'Ukuran foto terlalu besar, maksimal adalah 2MB.',
        ];
    }
}
