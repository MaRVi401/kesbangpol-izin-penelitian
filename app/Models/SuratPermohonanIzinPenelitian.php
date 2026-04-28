<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SuratPermohonanIzinPenelitian extends Model
{
    use HasUuids;

    protected $table = 'surat_permohonan_izin_penelitian';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    // Menggunakan guarded karena jumlah kolom sangat banyak di migrasi.
    // Pastikan melakukan validasi Request dengan ketat di Controller.
    protected $guarded = [];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }
}