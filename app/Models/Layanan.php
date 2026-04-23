<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Layanan extends Model {
    use HasUuids;
    protected $table = 'layanan';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $fillable = ['nama', 'status_arsip', 'status_prioritas'];

    public function tikets() { return $this->hasMany(Tiket::class, 'layanan_id', 'uuid'); }
}