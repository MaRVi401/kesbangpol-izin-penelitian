<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kabid extends Model {
    use HasUuids;
    protected $table = 'kabid';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $fillable = ['users_id', 'nip'];
    public function user() { return $this->belongsTo(User::class, 'users_id', 'uuid'); }
}