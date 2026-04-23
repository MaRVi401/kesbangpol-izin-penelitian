<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Layanan;
use App\Models\Tiket;
use App\Models\RiwayatStatusTiket;
use App\Models\DetailTiketLayananPengaduanElektronik;
use App\Models\DetailTiketLayananEmailGov;
use App\Models\DetailTiketLayananSubdomain;
use App\Models\DetailTiketLayananPembuatanApp;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari user pengguna_asn3
        $user = User::where('username', 'pengguna_asn3')->first();

        if (!$user) {
            $this->command->error('User "pengguna_asn3" tidak ditemukan! Pastikan UserSeeder berjalan lebih dulu.');
            return;
        }

        // 2. Ambil UUID Layanan dari ServiceSeeder (Pastikan ejaannya persis dengan ServiceSeeder)
        $idPengaduan = Layanan::where('nama', 'Pengaduan Sistem')->value('uuid');
        $idEmail     = Layanan::where('nama', 'Email E-Gov')->value('uuid');
        $idSubdomain = Layanan::where('nama', 'Subdomain')->value('uuid');
        $idApp       = Layanan::where('nama', 'Pembuatan & Pengembangan apps')->value('uuid');

        if (!$idPengaduan || !$idEmail || !$idSubdomain || !$idApp) {
            $this->command->error('Gagal mengambil data layanan! Pastikan ServiceSeeder dipanggil sebelum LayananSeeder di DatabaseSeeder.php.');
            return;
        }

        DB::beginTransaction();

        try {
            // Upload file seeder.png ke MinIO untuk pengaduan
            $pengaduanPath = null;
            $fileSource = storage_path('app/seeder.png'); 
            if (file_exists($fileSource)) {
                $filename = Str::uuid() . '.png';
                Storage::disk('s3')->put('pengaduan/' . $filename, file_get_contents($fileSource));
                $pengaduanPath = 'pengaduan/' . $filename;
            }

            /* =========================================================
               BAGIAN 1: 6 TIKET AWAL (STATUS "DIAJUKAN")
               ========================================================= */

            // 1. Pengaduan Sistem (Diajukan)
            $t1 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idPengaduan,
                'no_tiket' => 'TKT-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'diajukan', 'deskripsi' => 'Pengaduan Error Dashboard'
            ]);
            DetailTiketLayananPengaduanElektronik::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t1->uuid,
                'detail_pengaduan' => 'Terdapat error 500 saat mencoba mengakses halaman laporan bulan lalu.',
                'lampiran_screenshot' => $pengaduanPath
            ]);
            $this->createRiwayatFlow($t1->uuid, $user->uuid, ['diajukan']);

            // 2. Email E-Gov ASN (Diajukan)
            $t2 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idEmail,
                'no_tiket' => 'TEG-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'belum diajukan', 'deskripsi' => 'Asn - Permohonan baru'
            ]);
            DetailTiketLayananEmailGov::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t2->uuid, 'pd_no_surat' => '-', 'pd_tgl' => now(),
                'asn_no_surat' => '-', 'asn_tgl' => now(), 'asn_nama_lengkap' => 'Budi Santoso, S.Kom',
                'asn_nip' => '199001012020121001', 'asn_jabatan' => 'Pranata Komputer', 'asn_instansi' => 'Diskominfo',
                'asn_kontak' => '081234567891', 'asn_jenis_layanan' => 'permohonan baru'
            ]);
            $this->createRiwayatFlow($t2->uuid, $user->uuid, ['diajukan']);

            // 3. Email E-Gov PD (Diajukan)
            $t3 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idEmail,
                'no_tiket' => 'TEG-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'belum diajukan', 'deskripsi' => 'Perangkat_daerah - Permohonan baru'
            ]);
            DetailTiketLayananEmailGov::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t3->uuid, 'asn_no_surat' => '-', 'asn_tgl' => now(),
                'pd_no_surat' => '-', 'pd_tgl' => now(), 'pd_instansi_nama' => 'Dinas Kesehatan',
                'pd_nama_kepala_instansi' => 'Dr. Hj. Siti', 'pd_bidang' => 'Pelayanan Medis', 'pd_alamat' => 'Jl. Kesehatan No. 2',
                'pd_telp' => '026012345', 'pd_email' => 'dinkes@subang.go.id', 'pd_pj_nama' => 'Agus Setiawan',
                'pd_pj_nip' => '198502022010121002', 'pd_pj_jabatan' => 'Kasubag TU', 'pd_pj_email' => 'agus@gmail.com',
                'pd_pj_kontak' => '081299998888', 'pd_jenis_layanan' => 'permohonan baru'
            ]);
            $this->createRiwayatFlow($t3->uuid, $user->uuid, ['diajukan']);

            // 4. Subdomain (Diajukan)
            $t4 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idSubdomain,
                'no_tiket' => 'TSD-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'belum diajukan', 'deskripsi' => 'Permohonan Subdomain: e-puskesmas'
            ]);
            DetailTiketLayananSubdomain::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t4->uuid, 'no_surat' => '-', 'tanggal' => now(), 'halaman' => 1,
                'instansi_opd' => 'Dinas Kesehatan', 'instansi_bidang' => 'Bina Pelayanan', 'instansi_nama_kepala' => 'Dr. Hj. Siti',
                'instansi_alamat' => 'Jl. Kesehatan No. 2', 'instansi_telp' => '026012345', 'instansi_email' => 'dinkes@subang.go.id',
                'pj_admin_nama' => 'Agus Setiawan', 'pj_admin_nip' => '198502022010121002', 'pj_admin_jabatan' => 'Kasubag TU',
                'pj_admin_email' => 'agus@gmail.com', 'pj_admin_telp' => '081299998888', 'pj_teknis_nama' => 'Vendor IT Corp',
                'pj_teknis_instansi' => 'PT Solusi Digital', 'pj_teknis_alamat' => 'Jl. Teknologi', 'pj_teknis_email' => 'tech@solusidigital.com',
                'pj_teknis_telp' => '081122334455', 'subdomain_nama' => 'e-puskesmas', 'subdomain_alamat' => 'e-puskesmas.subang.go.id',
                'subdomain_ip' => '103.22.33.44', 'subdomain_deskripsi' => 'Aplikasi Rekam Medis Puskesmas Terpadu', 'subdomain_jenis' => 'permohonan baru'
            ]);
            $this->createRiwayatFlow($t4->uuid, $user->uuid, ['diajukan']);

            // 5. Apps Pembangunan Awal (Diajukan)
            $t5 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idApp,
                'no_tiket' => 'TPA-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'belum diajukan', 'deskripsi' => 'Pembuatan Apps - Pembangunan Sistem Awal'
            ]);
            DetailTiketLayananPembuatanApp::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t5->uuid, 'ajuan_tgl' => now(),
                'ajuan_nama_sistem' => 'Sistem Informasi Kearsipan Daerah', 'ajuan_ket_sistem' => 'Digitalisasi arsip fisik daerah menjadi elektronik',
                'ajuan_ttd_nama' => 'Kepala Dinas Kearsipan', 'ajuan_ttd_nip' => '197001011995031001',
                'ajuan_perintah_pj1_nama' => 'Kabid Arsip', 'ajuan_perintah_pj1_nip' => '198001012005011001',
                'ajuan_perintah_pj1_jabatan' => 'Kepala Bidang Arsip', 'ajuan_nama_skpd' => 'Dinas Kearsipan dan Perpustakaan',
                'ajuan_fitur' => ['Login SSO', 'Upload PDF', 'Pencarian Berbasis OCR', 'Log Audit'],
                'ajuan_ket_fitur' => 'Sistem harus aman dan dapat membaca teks dari dokumen PDF yang diunggah.'
            ]);
            $this->createRiwayatFlow($t5->uuid, $user->uuid, ['diajukan']);

            // 6. Apps Pengembangan Fitur (Diajukan)
            $t6 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idApp,
                'no_tiket' => 'TPA-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'belum diajukan', 'deskripsi' => 'Pembuatan Apps - Pengembangan Fitur'
            ]);
            DetailTiketLayananPembuatanApp::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t6->uuid, 'kembang_tgl' => now(),
                'kembang_nama_sistem' => 'Aplikasi Absensi Pegawai (E-Absen)', 'kembang_ket' => 'Penambahan fitur pengenalan wajah untuk absen',
                'kembang_ttd_nama' => 'Kepala BKPSDM', 'kembang_ttd_nip' => '197501012000031001',
                'kembang_perintah_pj1_nama' => 'Kabid Kedisiplinan', 'kembang_perintah_pj1_nip' => '198201012008011002',
                'kembang_perintah_pj1_jabatan' => 'Kepala Bidang Kedisiplinan', 'kembang_nama_skpd' => 'BKPSDM',
                'kembang_nama_fitur' => ['Face Recognition', 'Geofencing Radius 50m', 'Generate Rekap Bulanan Excel'],
                'kembang_ket_fitur' => 'Wajah pegawai dicocokkan dengan dataset foto di server E-Absen lama.'
            ]);
            $this->createRiwayatFlow($t6->uuid, $user->uuid, ['diajukan']);

            /* =========================================================
               BAGIAN 2: 6 TIKET TAMBAHAN (DITANGANI, DITOLAK, SELESAI)
               ========================================================= */

            // 7. Pengaduan Sistem (DITANGANI)
            $t7 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idPengaduan,
                'no_tiket' => 'TKT-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'ditangani', 'deskripsi' => 'Pengaduan Gagal Login SSO'
            ]);
            DetailTiketLayananPengaduanElektronik::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t7->uuid,
                'detail_pengaduan' => 'Saya tidak bisa login menggunakan akun SSO sejak pagi tadi, selalu loading lama.',
                'lampiran_screenshot' => $pengaduanPath
            ]);
            $this->createRiwayatFlow($t7->uuid, $user->uuid, ['diajukan', 'ditangani']);

            // 8. Subdomain (DITANGANI)
            $t8 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idSubdomain,
                'no_tiket' => 'TSD-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'ditangani', 'deskripsi' => 'Permohonan Subdomain: e-sakip'
            ]);
            DetailTiketLayananSubdomain::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t8->uuid, 'no_surat' => '-', 'tanggal' => now(), 'halaman' => 1,
                'instansi_opd' => 'BAPPEDA', 'instansi_bidang' => 'Perencanaan', 'instansi_nama_kepala' => 'H. Rahmat',
                'instansi_alamat' => 'Jl. Perencanaan No. 1', 'instansi_telp' => '0260778899', 'instansi_email' => 'bappeda@subang.go.id',
                'pj_admin_nama' => 'Joko Anwar', 'pj_admin_nip' => '198801012015021003', 'pj_admin_jabatan' => 'Analis Perencanaan',
                'pj_admin_email' => 'joko@gmail.com', 'pj_admin_telp' => '082233445566', 'pj_teknis_nama' => 'Vendor Sakip',
                'pj_teknis_instansi' => 'PT Sakip Hebat', 'pj_teknis_alamat' => 'Jakarta', 'pj_teknis_email' => 'dev@sakip.id',
                'pj_teknis_telp' => '081223344556', 'subdomain_nama' => 'e-sakip', 'subdomain_alamat' => 'e-sakip.subang.go.id',
                'subdomain_ip' => '103.55.66.77', 'subdomain_deskripsi' => 'Aplikasi Evaluasi Kinerja Sakip', 'subdomain_jenis' => 'permohonan baru'
            ]);
            $this->createRiwayatFlow($t8->uuid, $user->uuid, ['diajukan', 'ditangani']);

            // 9. Email E-Gov ASN (DITOLAK)
            $t9 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idEmail,
                'no_tiket' => 'TEG-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'ditolak', 'deskripsi' => 'Asn - Reset password'
            ]);
            DetailTiketLayananEmailGov::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t9->uuid, 'pd_no_surat' => '-', 'pd_tgl' => now(),
                'asn_no_surat' => '-', 'asn_tgl' => now(), 'asn_nama_lengkap' => 'Indra Hermawan',
                'asn_nip' => '199201012018021004', 'asn_jabatan' => 'Staff IT', 'asn_instansi' => 'BKPSDM',
                'asn_kontak' => '085566778899', 'asn_jenis_layanan' => 'reset password'
            ]);
            $this->createRiwayatFlow($t9->uuid, $user->uuid, ['diajukan', 'ditolak']);

            // 10. Apps Pembangunan Awal (DITOLAK)
            $t10 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idApp,
                'no_tiket' => 'TPA-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'ditolak', 'deskripsi' => 'Pembuatan Apps - Pembangunan Sistem Awal'
            ]);
            DetailTiketLayananPembuatanApp::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t10->uuid, 'ajuan_tgl' => now(),
                'ajuan_nama_sistem' => 'Sistem Informasi Cuti Pegawai', 'ajuan_ket_sistem' => 'Pengajuan cuti online',
                'ajuan_ttd_nama' => 'Kepala BKD', 'ajuan_ttd_nip' => '196501011990031005',
                'ajuan_perintah_pj1_nama' => 'Kabid Cuti', 'ajuan_perintah_pj1_nip' => '197701012003011005',
                'ajuan_perintah_pj1_jabatan' => 'Kabid Kepegawaian', 'ajuan_nama_skpd' => 'Badan Kepegawaian Daerah',
                'ajuan_fitur' => ['Form Pengajuan Cuti', 'Approval Berjenjang'],
                'ajuan_ket_fitur' => 'Sistem ditolak karena fitur ini sudah ada di dalam E-Absen.'
            ]);
            $this->createRiwayatFlow($t10->uuid, $user->uuid, ['diajukan', 'ditolak']);

            // 11. Email E-Gov PD (SELESAI)
            $t11 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idEmail,
                'no_tiket' => 'TEG-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'selesai', 'deskripsi' => 'Perangkat_daerah - Ganti nama akun'
            ]);
            DetailTiketLayananEmailGov::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t11->uuid, 'asn_no_surat' => '-', 'asn_tgl' => now(),
                'pd_no_surat' => '-', 'pd_tgl' => now(), 'pd_instansi_nama' => 'Dinas Pendidikan',
                'pd_nama_kepala_instansi' => 'Bapak Kepala Diknas', 'pd_bidang' => 'Sekretariat', 'pd_alamat' => 'Jl. Pendidikan No 1',
                'pd_telp' => '0260443322', 'pd_email' => 'diknas_old@subang.go.id', 'pd_pj_nama' => 'Maman S',
                'pd_pj_nip' => '198101012010121006', 'pd_pj_jabatan' => 'Sekretaris', 'pd_pj_email' => 'maman@gmail.com',
                'pd_pj_kontak' => '087788990011', 'pd_jenis_layanan' => 'ganti nama akun',
                'pd_alasan_ganti_nama' => 'Perubahan nomenklatur dinas', 'pd_usulan_email' => 'disdik@subang.go.id'
            ]);
            $this->createRiwayatFlow($t11->uuid, $user->uuid, ['diajukan', 'ditangani', 'selesai']);

            // 12. Apps Pengembangan Fitur (SELESAI)
            $t12 = Tiket::create([
                'uuid' => (string) Str::uuid(), 'users_id' => $user->uuid, 'layanan_id' => $idApp,
                'no_tiket' => 'TPA-' . Carbon::now()->format('dmY') . '-' . Str::upper(Str::random(4)),
                'status' => 'selesai', 'deskripsi' => 'Pembuatan Apps - Pengembangan Fitur'
            ]);
            DetailTiketLayananPembuatanApp::create([
                'uuid' => (string) Str::uuid(), 'tiket_id' => $t12->uuid, 'kembang_tgl' => now(),
                'kembang_nama_sistem' => 'Website Profil Desa', 'kembang_ket' => 'Penambahan fitur galeri dan video profil',
                'kembang_ttd_nama' => 'Kadis Pemdes', 'kembang_ttd_nip' => '197101011998031007',
                'kembang_perintah_pj1_nama' => 'Kabid Informasi Desa', 'kembang_perintah_pj1_nip' => '198301012009011007',
                'kembang_perintah_pj1_jabatan' => 'Kepala Bidang Pemdes', 'kembang_nama_skpd' => 'Dinas Pemberdayaan Masyarakat Desa',
                'kembang_nama_fitur' => ['Galeri Foto', 'Embed YouTube Video'],
                'kembang_ket_fitur' => 'Modul galeri bisa multiple upload dan embed link video.'
            ]);
            $this->createRiwayatFlow($t12->uuid, $user->uuid, ['diajukan', 'ditangani', 'selesai']);

            DB::commit();
            $this->command->info("Berhasil menautkan 12 tiket menggunakan master layanan dari ServiceSeeder ke akun 'pengguna_asn3'!");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Gagal menjalankan seeder: ' . $e->getMessage());
        }
    }

    private function createRiwayatFlow($tiketId, $userId, array $statuses)
    {
        $timeOffset = count($statuses); 
        
        foreach ($statuses as $index => $status) {
            RiwayatStatusTiket::create([
                'uuid' => (string) Str::uuid(),
                'tiket_id' => $tiketId,
                'users_id' => $userId,
                'status' => $status,
                'created_at' => now()->subHours($timeOffset - $index) 
            ]);
        }
    }
}