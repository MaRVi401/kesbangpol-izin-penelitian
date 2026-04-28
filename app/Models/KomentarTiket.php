<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KomentarTiket extends Model 
{
    use HasUuids;
    
    protected $table = 'komentar_tiket';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string'; // Tambahan untuk keamanan UUID
    
    protected $fillable = ['tiket_id', 'users_id', 'komentar'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'uuid');
    }

 
    public function tiket(): BelongsTo
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }
}