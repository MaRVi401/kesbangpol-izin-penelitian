<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari user mahasiswa (sebagai pemohon)
        $user = DB::table('users')->where('role', 'mahasiswa')->first();

        if (!$user) {
            $this->command->error('User "mahasiswa" tidak ditemukan! Pastikan UserSeeder berjalan lebih dulu.');
            return;
        }

        // 2. Ambil UUID Layanan
        $layanan = DB::table('layanan')->where('nama', 'Surat Permohonan Izin Penelitian')->first();

        if (!$layanan) {
            $this->command->error('Layanan tidak ditemukan! Pastikan ServiceSeeder dipanggil sebelum LayananSeeder.');
            return;
        }

        DB::beginTransaction();

        try {
            /* =========================================================
               SKENARIO TIKET UNTUK TESTING DASHBOARD
               ========================================================= */

            // Data template untuk detail surat (agar tidak mengulang pengetikan)
            $templateDetail = [
                'nama'                 => $user->nama,
                'tempat_lahir'         => 'Indramayu',
                'tanggal_lahir'        => '2005-08-17',
                'pekerjaan_pendidikan' => 'Mahasiswa',
                'semester'             => '6',
                'institusi_pendidikan' => 'Politeknik Negeri',
                'kegiatan'             => 'Penelitian Tugas Akhir',
                'lokasi_kegiatan'      => 'Dinas Komunikasi dan Informatika',
                'penanggung_jawab_1'   => 'Dosen Pembimbing',
                'banyak_peserta'       => 1,
                'jenis_kelamin'        => 'Laki-laki',
                'agama'                => 'Islam',
                'status_perkawinan'    => 'Belum Kawin',
                'alamat_lengkap'       => 'Jl. Lohbener Lama, Indramayu',
                'no_hp'                => '081234567890',
            ];

            // 1. Tiket Baru (Hanya Diajukan)
            $this->createTiketSimulation(
                $user->uuid, $layanan->uuid, 
                'diajukan', 
                'Pengajuan izin penelitian untuk perancangan sistem ePOS',
                ['diajukan'],
                array_merge($templateDetail, [
                    'dalam_rangka'    => 'Penyusunan Sistem Warung Nenek',
                    'judul_pembicara' => 'Perancangan ePOS Terintegrasi',
                    'tanggal_mulai'   => Carbon::now()->addDays(2)->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::now()->addDays(30)->format('Y-m-d'),
                ])
            );

            // 2. Tiket Sedang Diverifikasi (Tahap Awal)
            $this->createTiketSimulation(
                $user->uuid, $layanan->uuid, 
                'Verifikasi kelengkapan', 
                'Pengajuan izin pengumpulan data SIMDOKUM',
                ['diajukan', 'Verifikasi kelengkapan'],
                array_merge($templateDetail, [
                    'dalam_rangka'    => 'Magang & Pengumpulan Data',
                    'judul_pembicara' => 'Implementasi SIEM Logging di Laravel',
                    'tanggal_mulai'   => Carbon::now()->addDays(5)->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::now()->addDays(40)->format('Y-m-d'),
                ])
            );

            // 3. Tiket Selesai / Diterima
            $this->createTiketSimulation(
                $user->uuid, $layanan->uuid, 
                'diterima', 
                'Pengajuan izin observasi jaringan',
                ['diajukan', 'Verifikasi kelengkapan', 'verifikasi lengkap', 'diterima'],
                array_merge($templateDetail, [
                    'dalam_rangka'    => 'Observasi Jaringan Kampus',
                    'judul_pembicara' => 'Analisis Keamanan Server Arch Linux',
                    'tanggal_mulai'   => Carbon::now()->subDays(10)->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::now()->addDays(10)->format('Y-m-d'),
                ])
            );

            // 4. Tiket Ditolak (Karena dokumen/verifikasi gagal)
            $this->createTiketSimulation(
                $user->uuid, $layanan->uuid, 
                'ditolak', 
                'Pengajuan izin akses server utama',
                ['diajukan', 'Verifikasi kelengkapan', 'verifikasi gagal', 'ditolak'],
                array_merge($templateDetail, [
                    'dalam_rangka'    => 'Uji Penetrasi Sistem (CTF)',
                    'judul_pembicara' => 'Eksploitasi Kerentanan Web',
                    'tanggal_mulai'   => Carbon::now()->addDays(1)->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::now()->addDays(7)->format('Y-m-d'),
                ])
            );

            DB::commit();
            $this->command->info("Berhasil membuat 4 simulasi tiket dengan status workflow yang berbeda!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Gagal menjalankan seeder: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk membuat Tiket, Detail Tiket, dan Log Riwayat sekaligus
     */
    private function createTiketSimulation($userId, $layananId, $statusAkhir, $deskripsi, array $alurStatus, array $detailData)
    {
        $tiketUuid = (string) Str::uuid();

        // 1. Insert Master Tiket
        DB::table('tiket')->insert([
            'uuid'       => $tiketUuid,
            'users_id'   => $userId,
            'layanan_id' => $layananId,
            'no_tiket'   => 'TKT-LIT-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
            'lampiran'   => 'proposal_penelitian_dummy.pdf', 
            'deskripsi'  => $deskripsi,
            'status'     => $statusAkhir,
            'created_at' => now()->subDays(rand(1, 5)),
            'updated_at' => now(),
        ]);

        // 2. Insert Detail Surat Permohonan
        $detailData['uuid'] = (string) Str::uuid();
        $detailData['tiket_id'] = $tiketUuid;
        $detailData['created_at'] = now();
        $detailData['updated_at'] = now();
        
        DB::table('surat_permohonan_izin_penelitian')->insert($detailData);

        // 3. Insert Riwayat Flow
        $timeOffset = count($alurStatus); 
        foreach ($alurStatus as $index => $status) {
            DB::table('riwayat_status_tiket')->insert([
                'uuid'       => (string) Str::uuid(),
                'tiket_id'   => $tiketUuid,
                'users_id'   => $userId,
                'status'     => $status,
                'created_at' => now()->subHours($timeOffset - $index),
                'updated_at' => now()->subHours($timeOffset - $index)
            ]);
        }
    }
}