<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DetailTiketLayananPengaduanElektronik extends Model
{
    use HasUuids;

    protected $table = 'detail_tiket_layanan_pengaduan_sistem_elektronik';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }
}