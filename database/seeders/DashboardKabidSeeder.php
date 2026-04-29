<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardKabidSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Layanan Surat Izin Penelitian
        $layanan = DB::table('layanan')->where('nama', 'Surat Permohonan Izin Penelitian')->first();
        if (!$layanan) {
            $this->command->warn('Tabel layanan kosong atau tidak sesuai. Jalankan ServiceSeeder terlebih dahulu!');
            return;
        }

        // 2. Ambil user mahasiswa untuk dijadikan pemohon
        $mahasiswa = DB::table('users')->where('role', 'mahasiswa')->first();
        if (!$mahasiswa) {
            $this->command->warn('User Mahasiswa tidak ditemukan. Jalankan UserSeeder terlebih dahulu!');
            return;
        }

        // 3. Buat beberapa Operator Dummy tambahan agar data petugas bervariasi
        $operatorIds = [];
        $names = ['Agus Operator', 'Budi Service', 'Siti Support', 'Dewi Kominfo'];

        foreach ($names as $name) {
            $opUuid = (string) Str::uuid();
            $username = Str::slug($name);

            // Cek apakah sudah ada untuk menghindari duplicate entry
            $exists = DB::table('users')->where('username', $username)->first();
            
            if (!$exists) {
                DB::table('users')->insert([
                    'uuid' => $opUuid,
                    'nama' => $name,
                    'username' => $username,
                    'password' => Hash::make('password'),
                    'role' => 'operator',
                    'email' => $username . '@simdokum.local',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('operator')->insert([
                    'uuid' => (string) Str::uuid(),
                    'users_id' => $opUuid,
                    'nip' => '198' . rand(100000000000000, 999999999999999),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $operatorIds[] = $opUuid;
            } else {
                $operatorIds[] = $exists->uuid;
            }
        }

        // Tambahkan operator bawaan dari UserSeeder jika ada
        $defaultOp = DB::table('users')->where('role', 'operator')->whereNotIn('uuid', $operatorIds)->first();
        if ($defaultOp) {
            $operatorIds[] = $defaultOp->uuid;
        }

        // 4. Buat 50 Data Tiket Acak
        $statuses = [
            'draft', 'diajukan', 'verifikasi kelengkapan', 
            'verifikasi lengkap', 'verifikasi gagal', 'diterima', 'ditolak'
        ];

        for ($i = 1; $i <= 50; $i++) {
            $status = $statuses[array_rand($statuses)];
            $tiketUuid = (string) Str::uuid();
            $createdAt = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 24));

            // Petugas diisi jika status sudah melewati tahap 'diajukan' atau 'draft'
            $petugasId = (!in_array($status, ['draft', 'diajukan'])) 
                ? $operatorIds[array_rand($operatorIds)] 
                : null;

            // A. Insert Tabel Tiket
            DB::table('tiket')->insert([
                'uuid'       => $tiketUuid,
                'no_tiket'   => 'TKT-LIT-DASH-' . strtoupper(Str::random(6)) . $i,
                'users_id'   => $mahasiswa->uuid,
                'layanan_id' => $layanan->uuid,
                'petugas_id' => $petugasId,
                'status'     => $status,
                'deskripsi'  => 'Data simulasi tiket ke-' . $i . ' untuk monitoring dashboard Kabid.',
                'created_at' => $createdAt,
                'updated_at' => $createdAt->copy()->addHours(2),
            ]);

            // B. Insert Tabel Detail (surat_permohonan_izin_penelitian) agar tidak error saat view
            DB::table('surat_permohonan_izin_penelitian')->insert([
                'uuid'                 => (string) Str::uuid(),
                'tiket_id'             => $tiketUuid,
                'nama'                 => 'Pemohon Simulasi ' . $i,
                'tempat_lahir'         => 'Indramayu',
                'tanggal_lahir'        => '2000-01-01',
                'pekerjaan_pendidikan' => 'Mahasiswa',
                'institusi_pendidikan' => 'Politeknik Negeri',
                'kegiatan'             => 'Penelitian ' . $i,
                'dalam_rangka'         => 'Tugas Akhir',
                'tanggal_mulai'        => $createdAt->copy()->addDays(5)->format('Y-m-d'),
                'tanggal_selesai'      => $createdAt->copy()->addDays(35)->format('Y-m-d'),
                'lokasi_kegiatan'      => 'Diskominfo',
                'judul_pembicara'      => 'Judul Penelitian ' . $i,
                'penanggung_jawab_1'   => 'Dosen Pembimbing',
                'banyak_peserta'       => 1,
                'jenis_kelamin'        => 'Laki-laki',
                'agama'                => 'Islam',
                'status_perkawinan'    => 'Belum Kawin',
                'alamat_lengkap'       => 'Jl. Lohbener',
                'no_hp'                => '0812345678' . rand(10, 99),
                'created_at'           => $createdAt,
                'updated_at'           => $createdAt,
            ]);

            // C. Insert Tabel Riwayat Status Tiket
            DB::table('riwayat_status_tiket')->insert([
                'uuid'       => (string) Str::uuid(),
                'tiket_id'   => $tiketUuid,
                'users_id'   => ($petugasId) ? $petugasId : $mahasiswa->uuid,
                'status'     => $status,
                'created_at' => $createdAt->copy()->addHour(),
                'updated_at' => $createdAt->copy()->addHour(),
            ]);
        }

        $this->command->info('Berhasil! 50 data simulasi tiket (beserta detail & riwayatnya) telah ditambahkan untuk dashboard Kabid.');
    }
}