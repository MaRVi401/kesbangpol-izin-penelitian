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
            $table->string('nim')->nullable();
            $table->timestamps();
        });

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('nip');
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
            $table->enum('status', ['belum diajukan', 'diajukan', 'ditangani', 'selesai', 'ditolak']);
            $table->timestamps();
        });

        // 5. Log & Komentar
        Schema::create('riwayat_status_tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->enum('status', ['belum diajukan', 'diajukan', 'ditangani', 'selesai', 'ditolak']);
            $table->timestamps();
        });

        Schema::create('komentar_tiket', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->cascadeOnDelete();
            $table->foreignUuid('users_id')->constrained('users', 'uuid')->cascadeOnDelete();
            $table->string('komentar');
            $table->timestamps();
        });

        Schema::create('detail_tiket_layanan_email_gov', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->foreignUuid('tiket_id')->constrained('tiket', 'uuid')->cascadeOnDelete();

            // PD = Perangkat Daerah
            $table->string('pd_no_surat');
            $table->timestamp('pd_tgl');
            $table->integer('pd_hal')->nullable();
            $table->string('pd_instansi_nama')->nullable();
            $table->string('pd_nama_kepala_instansi')->nullable();
            $table->string('pd_bidang')->nullable();
            $table->string('pd_alamat')->nullable();
            $table->string('pd_telp')->nullable();
            $table->string('pd_email')->nullable();
            $table->string('pd_pj_nama')->nullable();
            $table->string('pd_pj_nip')->nullable();
            $table->string('pd_pj_jabatan')->nullable();
            $table->string('pd_pj_email')->nullable();
            $table->string('pd_pj_kontak')->nullable();
            $table->enum('pd_jenis_layanan', ['permohonan baru', 'reset password', 'hapus akun', 'ganti nama akun'])->nullable();
            $table->string('pd_alasan_hapus_akun')->nullable();
            $table->string('pd_alasan_ganti_nama')->nullable();
            $table->string('pd_usulan_email')->nullable();

            // ASN Section
            $table->string('asn_no_surat');
            $table->timestamp('asn_tgl');
            $table->integer('asn_hal')->nullable();
            $table->string('asn_nama_lengkap')->nullable();
            $table->string('asn_nip')->nullable();
            $table->string('asn_jabatan')->nullable();
            $table->string('asn_instansi')->nullable();
            $table->string('asn_kontak')->nullable();
            $table->enum('asn_jenis_layanan', ['permohonan baru', 'reset password', 'hapus akun', 'ganti nama akun'])->nullable();
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
        Schema::dropIfExists('detail_tiket_layanan_pembuatan_apps');
        Schema::dropIfExists('detail_tiket_layanan_subdomain');
        Schema::dropIfExists('detail_tiket_layanan_email_gov');
        Schema::dropIfExists('detail_tiket_layanan_pengaduan_sistem_elektronik');
        Schema::dropIfExists('prioritas_tiket_kadis');
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