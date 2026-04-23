<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PrioritasTiketKadis extends Model
{
    use HasUuids;

    protected $table = 'prioritas_tiket_kadis';
    protected $primaryKey = 'uuid';
    
    protected $fillable = [
        'tiket_id',
        'pengusul_id',
        'penerima_id',
        'catatan_kabid',
        'catatan_kadis',
        'status_persetujuan',
        'level_prioritas'
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid');
    }

    public function pengusul()
    {
        return $this->belongsTo(User::class, 'pengusul_id', 'uuid');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id', 'uuid');
    }
}