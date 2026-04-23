<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KomentarTiket extends Model {
    use HasUuids;
    protected $table = 'komentar_tiket';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $fillable = ['tiket_id', 'users_id', 'komentar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'uuid');
    }
}