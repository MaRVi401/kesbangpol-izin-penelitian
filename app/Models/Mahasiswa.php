<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Mahasiswa extends Model
{
    use HasUuids;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'users_id', 
        'nim',
        'ktm_path',
        'surat_rekomendasi_path',
        'status_akun'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'uuid');
    }
}