<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tiket extends Model
{
    use HasUuids;
    protected $table = 'tiket';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $fillable = ['users_id', 'layanan_id', 'petugas_id', 'no_tiket', 'deskripsi', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'uuid');
    }
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'uuid');
    }
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id', 'uuid');
    }

    public function detailPengaduan()
    {
        return $this->hasOne(DetailTiketLayananPengaduanElektronik::class, 'tiket_id', 'uuid');
    }
    public function detailEmailGov()
    {
        return $this->hasOne(DetailTiketLayananEmailGov::class, 'tiket_id', 'uuid');
    }
    public function detailSubdomain()
    {
        return $this->hasOne(DetailTiketLayananSubdomain::class, 'tiket_id', 'uuid');
    }
    public function detailApps()
    {
        return $this->hasOne(DetailTiketLayananPembuatanApp::class, 'tiket_id', 'uuid');
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatusTiket::class, 'tiket_id', 'uuid');
    }

    public function komentar(): HasMany
    {
        return $this->hasMany(KomentarTiket::class, 'tiket_id', 'uuid');
    }
}
