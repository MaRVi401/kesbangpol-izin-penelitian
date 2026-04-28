<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model 
{
    use HasUuids;
    
    protected $table = 'layanan';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string'; 
    
    protected $fillable = ['nama', 'status_arsip', 'status_prioritas'];

    public function tiket(): HasMany 
    { 
        return $this->hasMany(Tiket::class, 'layanan_id', 'uuid'); 
    }
}