<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property string $uuid
 * @property string|null $users_id
 * @property string $aksi
 * @property string $nama_tabel Contoh: layanan, tiket, detail_tiket_layanan_email_gov
 * @property string $record_id UUID dari data yang diubah
 * @property array<array-key, mixed>|null $data_lama Menyimpan state sebelum diubah
 * @property array<array-key, mixed>|null $data_baru Menyimpan state setelah diubah
 * @property string|null $ip_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereAksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereDataBaru($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereDataLama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereNamaTabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JejakAudit whereUuid($value)
 */
	class JejakAudit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kabid whereUuid($value)
 */
	class Kabid extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $users_id
 * @property string $komentar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereKomentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KomentarTiket whereUuid($value)
 */
	class KomentarTiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $nama
 * @property bool $status_arsip
 * @property string $status_prioritas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tiket
 * @property-read int|null $tiket_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereStatusArsip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereStatusPrioritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUuid($value)
 */
	class Layanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string|null $users_id
 * @property string $username_attempt Mencatat username/email yang dicoba saat login
 * @property string $tipe_event
 * @property string|null $ip_address
 * @property string|null $user_agent Mencatat device/browser yang digunakan
 * @property bool $is_suspicious Flag untuk memicu alert jika terdeteksi brute force
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereIsSuspicious($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereTipeEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereUsernameAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LogKeamanan whereUuid($value)
 */
	class LogKeamanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUuid($value)
 */
	class Operator extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $users_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RiwayatStatusTiket whereUuid($value)
 */
	class RiwayatStatusTiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string|null $nip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuperAdmin whereUuid($value)
 */
	class SuperAdmin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $tiket_id
 * @property string $nama
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $pekerjaan_pendidikan
 * @property string|null $semester
 * @property string $institusi_pendidikan
 * @property string|null $alamat_kantor
 * @property string|null $alamat_institusi
 * @property string|null $nomor_ktp
 * @property string|null $nomor_mahasiswa
 * @property string|null $nomor_pegawai
 * @property string $kegiatan
 * @property string $dalam_rangka
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $lokasi_kegiatan
 * @property string $judul_pembicara
 * @property string $penanggung_jawab_1
 * @property string|null $penanggung_jawab_2
 * @property int $banyak_peserta
 * @property string|null $nama_alias
 * @property string|null $nama_panggilan
 * @property string $jenis_kelamin
 * @property string $kebangsaan
 * @property string $agama
 * @property string|null $pekerjaan
 * @property string $status_perkawinan
 * @property string $alamat_lengkap
 * @property int|null $tinggi_badan
 * @property string|null $bentuk_badan
 * @property string|null $warna_kulit
 * @property string|null $bentuk_rambut
 * @property string|null $bentuk_hidung
 * @property string|null $ciri_khusus
 * @property string|null $hobi
 * @property string $no_hp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tiket $tiket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereAlamatInstitusi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereAlamatKantor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereAlamatLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereBanyakPeserta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereBentukBadan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereBentukHidung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereBentukRambut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereCiriKhusus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereDalamRangka($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereHobi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereInstitusiPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereJudulPembicara($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereKebangsaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereLokasiKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNamaAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNamaPanggilan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNomorKtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNomorMahasiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereNomorPegawai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian wherePekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian wherePekerjaanPendidikan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian wherePenanggungJawab1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian wherePenanggungJawab2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereStatusPerkawinan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereTiketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereTinggiBadan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SuratPermohonanIzinPenelitian whereWarnaKulit($value)
 */
	class SuratPermohonanIzinPenelitian extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $users_id
 * @property string $layanan_id
 * @property string|null $petugas_id
 * @property string $no_tiket
 * @property string|null $lampiran
 * @property string|null $deskripsi
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KomentarTiket> $komentar
 * @property-read int|null $komentar_count
 * @property-read \App\Models\Layanan $layanan
 * @property-read \App\Models\User|null $petugas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RiwayatStatusTiket> $riwayatStatus
 * @property-read int|null $riwayat_status_count
 * @property-read \App\Models\SuratPermohonanIzinPenelitian|null $suratIzinPenelitian
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereLayananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereNoTiket($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket wherePetugasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tiket whereUuid($value)
 */
	class Tiket extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $uuid
 * @property string $nama
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string|null $alamat
 * @property string $email
 * @property string|null $no_wa
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kabid|null $kabid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Operator|null $operator
 * @property-read \App\Models\SuperAdmin|null $superAdmin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tiketDibuat
 * @property-read int|null $tiket_dibuat_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tiket> $tiketDitangani
 * @property-read int|null $tiket_ditangani_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNoWa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUuid($value)
 */
	class User extends \Eloquent {}
}

