<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatusTiket extends Model {
    use HasUuids;
    
    protected $table = 'riwayat_status_tiket';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string'; 
    public $incrementing = false;
    
    protected $fillable = ['tiket_id', 'users_id', 'status'];

    /**
     * Relasi ke model Tiket
     */
    public function tiket(): BelongsTo
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }

    /**
     * Relasi ke model User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'uuid');
    }
}