<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RiwayatStatusTiket extends Model {
    use HasUuids;
    protected $table = 'riwayat_status_tiket';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $fillable = ['tiket_id', 'users_id', 'status'];
}