<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class JejakAudit extends Model 
{
    use HasUuids;

    protected $table = 'jejak_audit';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    
    protected $fillable = [
        'users_id', 
        'aksi', 
        'nama_tabel', 
        'record_id', 
        'data_lama', 
        'data_baru', 
        'ip_address'
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class, 'users_id', 'uuid'); 
    }
}