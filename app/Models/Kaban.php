<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kaban extends Model
{
    use HasUuids;

    protected $table = 'kaban';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'users_id', 
        'nip', 
        'nik', 
        'jabatan_atasan', 
        'jabatan_penandatangan', 
        'pangkat_golongan'
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class, 'users_id', 'uuid'); 
    }

    public function suratIzinPenelitian()
    {
        return $this->morphMany(SuratPermohonanIzinPenelitian::class, 'penandatangan');
    }
}