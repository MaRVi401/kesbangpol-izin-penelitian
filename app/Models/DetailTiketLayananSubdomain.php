<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DetailTiketLayananSubdomain extends Model
{
    use HasUuids;

    protected $table = 'detail_tiket_layanan_subdomain';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->no_surat) || $model->no_surat === '-') {
                $model->no_surat = self::generateNomorSurat();
            }
        });
    }

    private static function generateNomorSurat()
    {
        $bulanSekarang = date('n');
        $tahunSekarang = date('Y');
        
        $kodeSurat = '048'; 

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