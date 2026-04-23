<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TiketSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Kosongkan tabel
        DB::table('riwayat_status_tiket')->truncate();
        DB::table('komentar_tiket')->truncate();
        DB::table('detail_tiket_layanan_pengaduan_sistem_elektronik')->truncate();
        DB::table('detail_tiket_layanan_email_gov')->truncate();
        DB::table('detail_tiket_layanan_subdomain')->truncate();
        DB::table('detail_tiket_layanan_pembuatan_apps')->truncate();
        DB::table('tiket')->truncate();

        // 2. Ambil User urutan ke-4 (Operator)
        $userKe4 = DB::table('users')->offset(3)->first();
        $layanans = DB::table('layanan')->limit(4)->get();

        if (!$userKe4 || $layanans->count() < 4) {
            $this->command->error("Gagal: Pastikan UserSeeder dan LayananSeeder sudah dijalankan!");
            return;
        }

        foreach ($layanans as $index => $layanan) {
            $tiketUuid = (string) Str::uuid();

            // 3. Insert Master Tiket (PASTIKAN LAMPIRAN JPG)
            DB::table('tiket')->insert([
                'uuid'       => $tiketUuid,
                'users_id'   => $userKe4->uuid,
                'layanan_id' => $layanan->uuid,
                'no_tiket'   => 'TKT-' . date('Ymd') . '-000' . ($index + 1),
                'lampiran'   => 'testing.jpeg', 
                'deskripsi'  => "Laporan layanan " . $layanan->nama . " oleh " . $userKe4->nama,
                'status'     => 'diajukan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Insert Detail (Menangani kolom NOT NULL di database)
            if ($index == 0) {
                DB::table('detail_tiket_layanan_pengaduan_sistem_elektronik')->insert([
                    'uuid' => Str::uuid(),
                    'tiket_id' => $tiketUuid,
                    'detail_pengaduan' => 'Kendala pada modul pelaporan.',
                    'created_at' => now(),
                ]);
            } 
            elseif ($index == 1) {
                DB::table('detail_tiket_layanan_email_gov')->insert([
                    'uuid' => Str::uuid(),
                    'tiket_id' => $tiketUuid,
                    'pd_no_surat' => '001/EMAIL/2026',
                    'pd_tgl' => now(),
                    'asn_no_surat' => 'ASN/001/2026',
                    'asn_tgl' => now(),
                    'created_at' => now(),
                ]);
            } 
            elseif ($index == 2) {
                DB::table('detail_tiket_layanan_subdomain')->insert([
                    'uuid' => Str::uuid(),
                    'tiket_id' => $tiketUuid,
                    'no_surat' => 'SUB/001/2026',
                    'tanggal' => now(),
                    'halaman' => 1,
                    'instansi_opd' => 'Dinas Kesehatan',
                    'instansi_bidang' => 'Teknologi Informasi',
                    'instansi_nama_kepala' => 'Kepala Dinas',
                    'instansi_alamat' => 'Alamat Kantor',
                    'instansi_telp' => '021-123456',
                    'instansi_email' => 'dinkes@example.com',
                    'pj_admin_nama' => 'Admin Utama',
                    'pj_admin_nip' => '123456789',
                    'pj_admin_jabatan' => 'Staf IT',
                    'pj_admin_email' => 'admin@example.com',
                    'pj_admin_telp' => '0812345678',
                    'pj_teknis_nama' => 'Tim Teknis',
                    'pj_teknis_instansi' => 'Dinas Kesehatan',
                    'pj_teknis_alamat' => 'Alamat Kantor',
                    'pj_teknis_email' => 'teknis@example.com',
                    'pj_teknis_telp' => '0812345679',
                    'subdomain_nama' => 'subdomain-test',
                    'subdomain_alamat' => 'test.kabupaten.go.id',
                    'subdomain_ip' => '127.0.0.1',
                    'subdomain_deskripsi' => 'Deskripsi layanan subdomain.',
                    'subdomain_jenis' => 'permohonan baru',
                    'created_at' => now(),
                ]);
            } 
            elseif ($index == 3) {
                DB::table('detail_tiket_layanan_pembuatan_apps')->insert([
                    'uuid' => Str::uuid(),
                    'tiket_id' => $tiketUuid,
                    'ajuan_no_surat' => 'APP/001/2026',
                    'created_at' => now(),
                ]);
            }

            // 5. Log Riwayat
            DB::table('riwayat_status_tiket')->insert([
                'uuid'       => (string) Str::uuid(),
                'tiket_id'   => $tiketUuid,
                'users_id'   => $userKe4->uuid,
                'status'     => 'diajukan',
                'created_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
        $this->command->info("Selesai! 4 tiket dengan lampiran JPG pada parent berhasil dibuat.");
    }
}