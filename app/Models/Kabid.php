<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kabid extends Model {
    use HasUuids;
    protected $table = 'kabid';
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['uuid', 'users_id', 'nip', 'nik'];
    public function user() { return $this->belongsTo(User::class, 'users_id', 'uuid'); }
}