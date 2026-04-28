<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master Users
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['super_admin', 'mahasiswa', 'kabid', 'operator',]);
            $table->string('alamat')->nullable();
            $table->string('email')->unique();
            $table->string('no_wa')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        // 2. Role Specializations
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
            $table->timestamps();
        });

        Schema::create('kabid', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nip');
            $table->timestamps();
        });

        Schema::create('operator', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nip');
            $table->timestamps();
        });

        // 3. Master Layanan
        Schema::create('layanan', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('nama');
            $table->boolean('status_arsip')->default(false);
            $table->enum('status_prioritas', ['rendah', 'sedang', 'tinggi']);
            $table->timestamps();
        });

        // 4. Tiket
        Schema::create('tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('layanan_id')->constrained('layanan', 'uuid');
            $table->foreignUuid('petugas_id')->nullable()->constrained('users', 'uuid');
            $table->string('no_tiket')->unique();
            $table->string('lampiran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['draft', 'diajukan', 'Verifikasi kelengkapan', 'verifikasi lengkap', 'verifikasi gagal', 'diterima', 'ditolak']);
            $table->timestamps();
        });

        // 5. Log & Komentar
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
            
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('pekerjaan_pendidikan');
            $table->string('semester')->nullable();
            $table->string('institusi_pendidikan');
            $table->text('alamat_kantor')->nullable();
            $table->text('alamat_institusi')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('nomor_mahasiswa')->nullable();
            $table->string('nomor_pegawai')->nullable();
            
            $table->string('kegiatan');
            $table->string('dalam_rangka');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('lokasi_kegiatan');
            $table->string('judul_pembicara');
            $table->string('penanggung_jawab_1');
            $table->string('penanggung_jawab_2')->nullable();
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
            
            $table->timestamps();
        });

        Schema::create('log_keamanan', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->nullable()->constrained('users', 'uuid')->nullOnDelete();
            $table->string('username_attempt')->comment('Mencatat username/email yang dicoba saat login');
            $table->enum('tipe_event', ['login_sukses', 'login_gagal', 'logout', 'lockout']);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable()->comment('Mencatat device/browser yang digunakan');
            $table->boolean('is_suspicious')->default(false)->comment('Flag untuk memicu alert jika terdeteksi brute force');
            $table->timestamps();
        });

        Schema::create('jejak_audit', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->nullable()->constrained('users', 'uuid')->nullOnDelete();
            $table->enum('aksi', ['create', 'update', 'delete']);
            $table->string('nama_tabel')->comment('Contoh: layanan, tiket, detail_tiket_layanan_email_gov');
            $table->uuid('record_id')->comment('UUID dari data yang diubah');
            $table->json('data_lama')->nullable()->comment('Menyimpan state sebelum diubah');
            $table->json('data_baru')->nullable()->comment('Menyimpan state setelah diubah');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
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