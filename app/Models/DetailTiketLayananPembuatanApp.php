<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DetailTiketLayananPembuatanApp extends Model
{
    use HasUuids;

    // Pastikan nama tabel sesuai dengan migration kamu
    protected $table = 'detail_tiket_layanan_pembuatan_apps';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    /**
     * Casting tipe data agar Laravel otomatis mengubah JSON text di database 
     * menjadi Array saat dipanggil, dan mengubah timestamp menjadi objek Carbon.
     */
    protected $casts = [
        'ajuan_fitur'        => 'array',
        'kembang_nama_fitur' => 'array',
        'ajuan_tgl'          => 'datetime',
        'kembang_tgl'        => 'datetime',
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }

    /**
     * ====================================================================
     * BOOT METHOD: LOGIKA PENOMORAN OTOMATIS
     * Berjalan otomatis saat data akan disimpan (Creating)
     * ====================================================================
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            
            // 1. Logika untuk Pembangunan Awal
            // Jika ajuan_nama_skpd terisi (berarti form Pembangunan Awal) dan nomor surat masih kosong
            if (!empty($model->ajuan_nama_skpd) && empty($model->ajuan_no_surat)) {
                $model->ajuan_no_surat = self::generateNomorSurat();
            }

            // 2. Logika untuk Pengembangan Fitur
            // Jika kembang_nama_skpd terisi (berarti form Pengembangan Fitur) dan nomor surat masih kosong
            if (!empty($model->kembang_nama_skpd) && empty($model->kembang_no_surat)) {
                $model->kembang_no_surat = self::generateNomorSurat();
            }
        });
    }
 
    /**
     * Fungsi untuk meng-generate nomor surat dengan format: 000/ 000- PD
     */
    private static function generateNomorSurat()
    {
        $tahunSekarang = date('Y');
        
        // Hitung jumlah data tahun ini untuk mendapatkan urutan selanjutnya
        $jumlahData = self::whereYear('created_at', $tahunSekarang)->count();
        $noUrut = $jumlahData + 1;

        // Kode klasifikasi surat (Silakan sesuaikan dengan kode arsip Diskominfo, misal: 048)
        $kodeSurat = 48; // Akan diformat menjadi 048 oleh %03d

        // Format: [NoUrut 3 digit]/ [KodeSurat 3 digit]- PD
        // Contoh Output: 001/ 048- PD
        return sprintf("%03d/ %03d- PD", $noUrut, $kodeSurat);
    }
}