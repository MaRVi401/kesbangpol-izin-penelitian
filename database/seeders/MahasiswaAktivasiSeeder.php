<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MahasiswaAktivasiSeeder extends Seeder
{
    public function run(): void
    {
        // ======================================================================
        // 1. PROSES BERSIHKAN DATA SEBELUMNYA (Agar bisa dijalankan berkali-kali)
        // ======================================================================
        Schema::disableForeignKeyConstraints();

        // Target username mahasiswa yang dibuat oleh seeder ini
        $targetUsernames = ['budi_mhs', 'siti_mhs', 'rian_mhs'];

        // Dapatkan semua UUID users berdasarkan username target
        $userUuids = DB::table('users')
            ->whereIn('username', $targetUsernames)
            ->pluck('uuid')
            ->toArray();

        if (!empty($userUuids)) {
            // Hapus anak tabel (mahasiswa) terlebih dahulu untuk menghindari relasi eror
            DB::table('mahasiswa')->whereIn('users_id', $userUuids)->delete();
            
            // Hapus tabel master (users)
            DB::table('users')->whereIn('uuid', $userUuids)->delete();
        }

        Schema::enableForeignKeyConstraints();
        // ======================================================================


        // 2. Data Mahasiswa PENDING (Untuk ditesting aktivasi/persetujuannya)
        $pendingData = [
            [
                'nama' => 'Budi Santoso',
                'username' => 'budi_mhs',
                'email' => 'budi@student.ac.id',
                'nim' => '2301001',
            ],
            [
                'nama' => 'Siti Aminah',
                'username' => 'siti_mhs',
                'email' => 'siti@student.ac.id',
                'nim' => '2301002',
            ],
        ];

        foreach ($pendingData as $mhs) {
            $userUuid = (string) Str::uuid();
            
            // Insert ke tabel users
            DB::table('users')->insert([
                'uuid' => $userUuid,
                'nama' => $mhs['nama'],
                'username' => $mhs['username'],
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'email' => $mhs['email'],
                'no_wa' => '0851' . rand(10000000, 99999999),
                'alamat' => 'Alamat Rumah ' . $mhs['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert ke tabel mahasiswa dengan status 'pending'
            DB::table('mahasiswa')->insert([
                'uuid' => (string) Str::uuid(),
                'users_id' => $userUuid,
                'nim' => $mhs['nim'],
                'status_akun' => 'pending',
                'ktm_path' => 'uploads/ktm/sample_ktm.jpg',
                'surat_rekomendasi_path' => 'uploads/rekomendasi/sample_surat.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Data Mahasiswa DITOLAK (Sebagai pembanding/riwayat di dashboard)
        $ditolakUserUuid = (string) Str::uuid();
        DB::table('users')->insert([
            'uuid' => $ditolakUserUuid,
            'nama' => 'Rian Hidayat',
            'username' => 'rian_mhs',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'email' => 'rian@student.ac.id',
            'no_wa' => '085211223344',
            'alamat' => 'Jl. Merdeka No. 10',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        DB::table('mahasiswa')->insert([
            'uuid' => (string) Str::uuid(),
            'users_id' => $ditolakUserUuid,
            'nim' => '2301003',
            'status_akun' => 'ditolak',
            'ktm_path' => 'uploads/ktm/rian_ktm.jpg',
            'surat_rekomendasi_path' => 'uploads/rekomendasi/rian_surat.pdf',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        // Ganti teks info output log
        $this->command->info('Berhasil: MahasiswaAktivasiSeeder berhasil di-refresh dan data testing siap digunakan kembali.');
    }
}