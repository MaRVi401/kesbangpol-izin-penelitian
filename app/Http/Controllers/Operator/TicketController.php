<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\JejakAudit;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        // Memperbaiki eager loading dari 'detailPengaduan' menjadi 'suratIzinPenelitian'
        // dan menghapus logic PrioritasTiketKadis yang tidak ada di skema.
        $query = Tiket::with(['user', 'layanan', 'suratIzinPenelitian'])
            ->where('status', 'diajukan')
            ->whereNull('petugas_id');

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function (Builder $qu) use ($search) {
                        $qu->where('nama', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('layanan', function (Builder $ql) use ($search) {
                        $ql->where('nama', 'ilike', "%{$search}%");
                    });
            });
        }

        $tickets = $query->latest()->paginate(10);

        return view('pages.operator.ticket.index', compact('tickets'));
    }

    public function revisiKadis(Request $request): View
    {
        $search = $request->input('search');

        // Menghapus dependency $revisiTiketIds karena model kadis terkait sudah tidak relevan
        $query = Tiket::with(['user', 'layanan', 'suratIzinPenelitian'])
            ->where('status', 'diajukan')
            ->where('petugas_id', $request->user()->uuid);

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function (Builder $qu) use ($search) {
                        $qu->where('nama', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('layanan', function (Builder $ql) use ($search) {
                        $ql->where('nama', 'ilike', "%{$search}%");
                    });
            });
        }

        $tickets = $query->latest()->paginate(10);

        return view('pages.operator.ticket.revisi', compact('tickets'));
    }

    public function handle(Request $request, string $uuid): RedirectResponse
    {
        $ticket = Tiket::where('uuid', $uuid)
            ->whereNull('petugas_id')
            ->firstOrFail();

        DB::transaction(function () use ($ticket, $request) {
            // Menyesuaikan status ke ENUM yang ada (verifikasi kelengkapan) 
            $ticket->update([
                'petugas_id' => $request->user()->uuid,
                'status'     => 'verifikasi kelengkapan', 
            ]);

            DB::table('riwayat_status_tiket')->insert([
                'uuid'       => (string) Str::uuid(),
                'tiket_id'   => $ticket->uuid,
                'users_id'   => $request->user()->uuid,
                'status'     => 'verifikasi kelengkapan',
                'created_at' => now(),
            ]);

            JejakAudit::create([
                'users_id' => $request->user()->uuid,
                'aksi' => 'update',
                'nama_tabel' => 'tiket',
                'record_id' => $ticket->uuid,
                'data_lama' => ['status' => 'diajukan', 'petugas_id' => null],
                'data_baru' => ['status' => 'verifikasi kelengkapan', 'petugas_id' => $request->user()->uuid],
                'ip_address' => $request->ip()
            ]);
        });

        return redirect()
            ->route('ticket.workdesk')
            ->with('success', 'Tiket berhasil dipindahkan ke meja kerja Anda.');
    }

    public function workDesk(Request $request): View
    {
        $search = $request->input('search');

        $query = Tiket::with(['user', 'layanan', 'suratIzinPenelitian'])
            ->where('petugas_id', $request->user()->uuid)
            ->where('status', 'verifikasi kelengkapan');

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function (Builder $qu) use ($search) {
                        $qu->where('nama', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('layanan', function (Builder $ql) use ($search) {
                        $ql->where('nama', 'ilike', "%{$search}%");
                    });
            });
        }

        $tickets = $query->latest()->paginate(10);

        return view('pages.operator.ticket.workdesk', compact('tickets'));
    }

    public function show(string $uuid): View
    {
        $ticket = Tiket::with(['user', 'layanan', 'riwayatStatus', 'komentar.user'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('pages.operator.ticket.show', compact('ticket'));
    }

    public function update(Request $request, string $uuid): RedirectResponse
    {
        // Validasi disesuaikan dengan rule enum migration
        $request->validate([
            'status'   => 'required|in:verifikasi lengkap,verifikasi gagal,diterima,ditolak',
            'komentar' => 'required|string|min:1',
        ]);

        $ticket = Tiket::where('uuid', $uuid)->firstOrFail();

        DB::transaction(function () use ($request, $ticket) {
            $ticket->update([
                'status' => $request->status,
            ]);

            DB::table('komentar_tiket')->insert([
                'uuid'       => (string) Str::uuid(),
                'tiket_id'   => $ticket->uuid,
                'users_id'   => $request->user()->uuid,
                'komentar'   => $request->komentar,
                'created_at' => now(),
            ]);

            DB::table('riwayat_status_tiket')->insert([
                'uuid'       => (string) Str::uuid(),
                'tiket_id'   => $ticket->uuid,
                'users_id'   => $request->user()->uuid,
                'status'     => $request->status,
                'created_at' => now(),
            ]);
        });

        return redirect()
            ->route('ticket.workdesk')
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    public function history(Request $request): View
    {
        $search = $request->input('search');
        $filterTime = $request->input('filter_time');
        $userUuid = $request->user()->uuid;

        // Mengganti ENUM penyelesaian yang sesuai dengan database
        $query = Tiket::with(['user', 'layanan', 'suratIzinPenelitian'])
            ->where('petugas_id', $userUuid)
            ->whereIn('status', ['verifikasi lengkap', 'verifikasi gagal', 'diterima', 'ditolak']);

        if ($filterTime) {
            $now = now();
            if ($filterTime === 'hari') {
                $query->whereDate('updated_at', $now->toDateString());
            } elseif ($filterTime === 'minggu') {
                $query->whereBetween('updated_at', [$now->startOfWeek(), $now->endOfWeek()]);
            } elseif ($filterTime === 'bulan') {
                $query->whereMonth('updated_at', $now->month)
                      ->whereYear('updated_at', $now->year);
            }
        }

        if ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('no_tiket', 'ilike', "%{$search}%")
                    ->orWhereHas('user', function (Builder $qu) use ($search) {
                        $qu->where('nama', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('layanan', function (Builder $ql) use ($search) {
                        $ql->where('nama', 'ilike', "%{$search}%");
                    });
            });
        }

        $tickets = $query->latest('updated_at')->paginate(10);

        return view('pages.operator.ticket.history', compact('tickets'));
    }
}