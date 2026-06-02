<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\JejakAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserManagementController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'mahasiswa')
            ->whereHas('mahasiswa', function ($query) {
                $query->where('status_akun', 'pending');
            })
            ->with('mahasiswa')
            ->latest()
            ->paginate(10);

        return view('pages.operator.user-management.pending', compact('pendingUsers'));
    }

    public function activate(Request $request, string $uuid)
    {
        $request->validate([
            'status' => 'required|in:aktif,ditolak'
        ]);

        DB::beginTransaction();
        try {
            $mahasiswa = Mahasiswa::where('users_id', $uuid)->firstOrFail();
            $statusLama = $mahasiswa->status_akun;

            $mahasiswa->update([
                'status_akun' => $request->status
            ]);

            JejakAudit::create([
                'users_id' => Auth::id(),
                'aksi' => 'update',
                'nama_tabel' => 'mahasiswa',
                'record_id' => $mahasiswa->uuid,
                'data_lama' => ['status_akun' => $statusLama],
                'data_baru' => ['status_akun' => $request->status],
                'ip_address' => request()->ip()
            ]);

            DB::commit();
            $msg = $request->status == 'aktif' ? 'Akun berhasil diaktifkan.' : 'Akun telah ditolak.';
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses aktivasi: ' . $e->getMessage());
        }
    }
}