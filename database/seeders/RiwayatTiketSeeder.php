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
        DB::table('riwayat_status_tiket')->truncate();

        // Cari user dengan role operator
        $operator = DB::table('users')->where('role', 'operator')->first();

        if (!$operator) {
            $this->command->error('Gagal: User operator tidak ditemukan. Silakan jalankan UserSeeder dahulu.');
            return;
        }

        // Ambil tiket yang sudah ada
        $tickets = DB::table('tiket')->pluck('uuid')->toArray();
        
        if (empty($tickets)) {
            $this->command->error('Gagal: Tabel tiket kosong. Harap jalankan TiketSeeder terlebih dahulu.');
            return;
        }

        // Data simulasi jumlah log per hari (7 hari terakhir)
        $dataStatistik = [
            7 => 3, 6 => 5, 5 => 2, 4 => 8, 3 => 4, 2 => 9, 1 => 6, 0 => 2
        ];

        // ENUM yang sudah disamakan dengan tabel master tiket
        // Saya ambil status yang umumnya dikerjakan oleh operator/admin
        $statusEnum = [
            'Verifikasi kelengkapan', 
            'verifikasi lengkap', 
            'verifikasi gagal', 
            'diterima', 
            'ditolak'
        ];

        foreach ($dataStatistik as $hariLalu => $jumlahTiket) {
            $tanggal = Carbon::now()->subDays($hariLalu);

            for ($i = 0; $i < $jumlahTiket; $i++) {
                DB::table('riwayat_status_tiket')->insert([
                    'uuid'       => (string) Str::uuid(),
                    'tiket_id'   => $tickets[array_rand($tickets)], 
                    'users_id'   => $operator->uuid, 
                    'status'     => $statusEnum[array_rand($statusEnum)], // Mengambil status random dari ENUM baru
                    'created_at' => $tanggal->copy()->addHours(rand(1, 12)),
                    'updated_at' => $tanggal,
                ]);
            }
        }

        $this->command->info('Berhasil: RiwayatTiketSeeder dijalankan dengan ENUM yang sudah tersinkronisasi!');
    }
}