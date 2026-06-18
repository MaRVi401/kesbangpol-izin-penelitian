<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'mahasiswa', 'kabid', 'operator']);
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('no_wa')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        Schema::create('super_admin', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nip')->nullable();
            $table->timestamps();
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nim');
            $table->enum('status_akun', ['pending', 'aktif', 'ditolak'])->default('pending');
            $table->string('ktm_path')->nullable();
            $table->string('surat_rekomendasi_path')->nullable();
            $table->timestamps();
        });

        Schema::create('kabid', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nip');
            $table->string('nik');
            $table->timestamps();
        });

        Schema::create('operator', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nip');
            $table->timestamps();
        });

        Schema::create('layanan', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->boolean('status_arsip')->default(false);
            $table->enum('status_prioritas', ['rendah', 'sedang', 'tinggi']);
            $table->timestamps();
        });

        Schema::create('tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('layanan_id')->constrained('layanan', 'uuid');
            $table->foreignUuid('petugas_id')->nullable()->constrained('users', 'uuid')->nullOnDelete();
            $table->string('no_tiket')->unique();
            $table->string('lampiran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('payload_draft')->nullable();
            $table->enum('status', ['draft', 'diajukan', 'verifikasi kelengkapan', 'verifikasi lengkap', 'verifikasi gagal', 'diterima', 'ditolak']);
            $table->timestamps();
        });

        Schema::create('riwayat_status_tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->enum('status', ['draft', 'diajukan', 'verifikasi kelengkapan', 'verifikasi lengkap', 'verifikasi gagal', 'diterima', 'ditolak']);
            $table->timestamps();
        });

        Schema::create('komentar_tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('komentar');
            $table->timestamps();
        });

        Schema::create('surat_permohonan_izin_penelitian', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->cascadeOnDelete();
            
            $table->string('nomor_surat')->nullable(); 


            $table->string('nomor_surat_institusi');
            $table->date('tanggal_surat_institusi');
            $table->date('tanggal_diterima_surat');
            
            
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('pekerjaan_pendidikan');
            $table->integer('semester')->nullable();
            $table->string('institusi_pendidikan');
            $table->text('alamat_kantor')->nullable();
            $table->text('alamat_institusi')->nullable();
            $table->string('nomor_mahasiswa')->nullable();
            $table->string('nomor_pegawai')->nullable();
            $table->string('yth_kepada');
            $table->string('yth_cq')->nullable();
            $table->string('yth_di')->default('Tempat');
            $table->string('kegiatan');
            $table->string('dalam_rangka');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi_kegiatan');
            $table->string('judul_pembicara');
            $table->string('penanggung_jawab_1');
            $table->string('nip_penanggung_jawab_1')->nullable();
            $table->string('penanggung_jawab_2')->nullable();
            $table->string('nip_penanggung_jawab_2')->nullable();
            $table->integer('banyak_peserta');
            $table->string('nama_alias')->nullable();
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('kebangsaan')->default('Indonesia');
            $table->string('agama');
            $table->string('pekerjaan')->nullable();
            $table->enum('status_perkawinan', ['Kawin', 'Belum Kawin']);
            $table->text('alamat_lengkap');
            $table->integer('tinggi_badan')->nullable();
            $table->string('bentuk_badan')->nullable();
            $table->string('warna_kulit')->nullable();
            $table->string('bentuk_rambut')->nullable();
            $table->string('bentuk_hidung')->nullable();
            $table->string('ciri_khusus')->nullable();
            $table->string('hobi')->nullable();
            $table->string('no_hp');
            $table->string('path_pas_foto')->nullable();
            $table->timestamps();
        });

        Schema::create('log_keamanan', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->nullable()->constrained('users', 'uuid')->nullOnDelete();
            $table->string('username_attempt');
            $table->enum('tipe_event', ['login_sukses', 'login_gagal', 'logout', 'lockout']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('is_suspicious')->default(false);
            $table->timestamps();
        });

        Schema::create('jejak_audit', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->nullable()->constrained('users', 'uuid')->nullOnDelete();
            $table->enum('aksi', ['create', 'update', 'delete']);
            $table->string('nama_tabel');
            $table->uuid('record_id');
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });

        Schema::create('penandatangan_surat', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('nip');
            $table->string('jabatan_atasan')->default('an. Kepala Badan Kesatuan Bangsa dan Politik Kabupaten Subang');
            $table->string('jabatan_penandatangan');
            $table->string('pangkat_golongan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penandatangan_surat');
        Schema::dropIfExists('surat_permohonan_izin_penelitian');
        Schema::dropIfExists('komentar_tiket');
        Schema::dropIfExists('riwayat_status_tiket');
        Schema::dropIfExists('tiket');
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('operator');
        Schema::dropIfExists('kabid');
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('super_admin');
        Schema::dropIfExists('users');
        Schema::dropIfExists('jejak_audit');
        Schema::dropIfExists('log_keamanan');
    }
};