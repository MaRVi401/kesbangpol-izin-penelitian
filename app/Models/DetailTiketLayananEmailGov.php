<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DetailTiketLayananEmailGov extends Model
{
    use HasUuids;

    protected $table = 'detail_tiket_layanan_email_gov';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

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
            
            // 1. Logika untuk ASN
            // Generate Nomor HANYA JIKA jenis layanan ASN terisi (artinya ini request ASN)
            // DAN nomor surat masih kosong/strip
            if (!empty($model->asn_jenis_layanan) && ($model->asn_no_surat === '-' || empty($model->asn_no_surat))) {
                $model->asn_no_surat = self::generateNomorSurat('asn');
            }

            // 2. Logika untuk Perangkat Daerah
            // Generate Nomor HANYA JIKA jenis layanan PD terisi (artinya ini request PD)
            if (!empty($model->pd_jenis_layanan) && ($model->pd_no_surat === '-' || empty($model->pd_no_surat))) {
                $model->pd_no_surat = self::generateNomorSurat('pd');
            }
        });
    }

    private static function generateNomorSurat($tipe)
    {
        $bulanSekarang = date('n');
        $tahunSekarang = date('Y');
        
        // Kode Surat: 800 (ASN), 048 (PD) - Sesuaikan
        $kodeSurat = ($tipe === 'asn') ? '800' : '048'; 

        // Hitung jumlah data tahun ini untuk mendapatkan urutan
        $jumlahData = self::whereYear('created_at', $tahunSekarang)->count();
        $noUrut = $jumlahData + 1;

        $bulanRomawi = self::getRomawi($bulanSekarang);

        return sprintf("%03d/%s/%s/%s", $noUrut, $kodeSurat, $bulanRomawi, $tahunSekarang);
    }

    private static function getRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$bulan] ?? 'I'; 
    }
}