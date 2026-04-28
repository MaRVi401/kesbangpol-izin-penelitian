<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TiketSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Kosongkan tabel terkait (Sesuai skema baru)
        DB::table('riwayat_status_tiket')->truncate();
        DB::table('komentar_tiket')->truncate();
        DB::table('surat_permohonan_izin_penelitian')->truncate();
        DB::table('tiket')->truncate();
        DB::table('layanan')->truncate();

        // 2. Buat Master Layanan tunggal
        $layananUuid = (string) Str::uuid();
        DB::table('layanan')->insert([
            'uuid'             => $layananUuid,
            'nama'             => 'Surat Permohonan Izin Penelitian',
            'status_arsip'     => false,
            'status_prioritas' => 'sedang',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // 3. Ambil User dengan role Mahasiswa sebagai pemohon
        $mahasiswa = DB::table('users')->where('role', 'mahasiswa')->first();

        if (!$mahasiswa) {
            $this->command->error("Gagal: Pastikan UserSeeder sudah dijalankan dan terdapat user dengan role mahasiswa!");
            return;
        }

        // 4. Insert Master Tiket
        $tiketUuid = (string) Str::uuid();
        DB::table('tiket')->insert([
            'uuid'       => $tiketUuid,
            'users_id'   => $mahasiswa->uuid,
            'layanan_id' => $layananUuid,
            'no_tiket'   => 'TKT-LIT-' . date('Ymd') . '-0001',
            'lampiran'   => 'proposal_penelitian.pdf', 
            'deskripsi'  => "Pengajuan permohonan izin penelitian oleh mahasiswa " . $mahasiswa->nama,
            'status'     => 'diajukan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Insert Detail Surat Permohonan Izin Penelitian (Memenuhi semua constraint NOT NULL)
        DB::table('surat_permohonan_izin_penelitian')->insert([
            'uuid'                 => (string) Str::uuid(),
            'tiket_id'             => $tiketUuid,
            
            // Data Pribadi & Institusi
            'nama'                 => $mahasiswa->nama,
            'tempat_lahir'         => 'Jakarta',
            'tanggal_lahir'        => '2005-01-01',
            'pekerjaan_pendidikan' => 'Mahasiswa',
            'semester'             => '6',
            'institusi_pendidikan' => 'Politeknik Negeri',
            'nomor_mahasiswa'      => '2203001',
            
            // Data Kegiatan
            'kegiatan'             => 'Penelitian Tugas Akhir',
            'dalam_rangka'         => 'Penyusunan Laporan Proyek SIMDOKUM',
            'tanggal_mulai'        => Carbon::now()->addDays(3)->format('Y-m-d'),
            'tanggal_selesai'      => Carbon::now()->addMonths(1)->format('Y-m-d'),
            'lokasi_kegiatan'      => 'Dinas Komunikasi dan Informatika',
            'judul_pembicara'      => 'Implementasi SIEM Logging pada Sistem Terpusat',
            'penanggung_jawab_1'   => 'Dosen Pembimbing Utama',
            'banyak_peserta'       => 1,
            
            // Data Tambahan Wajib
            'jenis_kelamin'        => 'Laki-laki',
            'agama'                => 'Islam',
            'status_perkawinan'    => 'Belum Kawin',
            'alamat_lengkap'       => $mahasiswa->alamat ?? 'Alamat Pemohon',
            'no_hp'                => $mahasiswa->no_wa ?? '081234567890',
            
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // 6. Log Riwayat Status Tiket
        DB::table('riwayat_status_tiket')->insert([
            'uuid'       => (string) Str::uuid(),
            'tiket_id'   => $tiketUuid,
            'users_id'   => $mahasiswa->uuid,
            'status'     => 'diajukan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::enableForeignKeyConstraints();
        $this->command->info("Selesai! Data Layanan dan 1 Tiket Izin Penelitian berhasil dibuat.");
    }
}