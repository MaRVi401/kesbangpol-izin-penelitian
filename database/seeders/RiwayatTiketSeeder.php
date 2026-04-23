<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RiwayatTiketSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel terlebih dahulu sesuai permintaan Anda
        DB::table('riwayat_status_tiket')->truncate();

        // Cari user dengan role operator untuk dikaitkan dengan riwayat
        $operator = DB::table('users')->where('role', 'operator')->first();

        if (!$operator) {
            $this->command->error('User dengan role operator tidak ditemukan. Silakan buat user operator terlebih dahulu.');
            return;
        }

        // Cari beberapa tiket yang ada untuk referensi tiket_id (UUID)
        $tickets = DB::table('tiket')->limit(10)->pluck('uuid')->toArray();
        
        if (empty($tickets)) {
            $this->command->error('Tabel tiket kosong. Harap isi tabel tiket terlebih dahulu.');
            return;
        }

        // Data simulasi jumlah tiket selesai/ditolak per hari (7 hari terakhir)
        $dataStatistik = [
            7 => 3, 6 => 5, 5 => 2, 4 => 8, 3 => 4, 2 => 9, 1 => 6, 0 => 2
        ];

        foreach ($dataStatistik as $hariLalu => $jumlahTiket) {
            $tanggal = Carbon::now()->subDays($hariLalu);

            for ($i = 0; $i < $jumlahTiket; $i++) {
                DB::table('riwayat_status_tiket')->insert([
                    'uuid'       => (string) Str::uuid(), // Database Anda menggunakan UUID
                    'tiket_id'   => $tickets[array_rand($tickets)], // Menggunakan UUID tiket yang valid
                    'users_id'   => $operator->uuid, // Kolom yang benar adalah users_id
                    'status'     => rand(0, 1) ? 'selesai' : 'ditolak',
                    'created_at' => $tanggal->copy()->addHours(rand(1, 12)),
                    'updated_at' => $tanggal,
                ]);
            }
        }

        $this->command->info('Seeder Riwayat Tiket berhasil dijalankan dengan data dinamis!');
    }
}