<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
        'alamat',
        'email',
        'no_wa',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Penting untuk Route Resource agar mencari berdasarkan uuid di URL
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function superAdmin()
    {
        return $this->hasOne(SuperAdmin::class, 'users_id', 'uuid');
    }
    public function penggunaAsn()
    {
        return $this->hasOne(PenggunaAsn::class, 'users_id', 'uuid');
    }
    public function kabid()
    {
        return $this->hasOne(Kabid::class, 'users_id', 'uuid');
    }
    public function operator()
    {
        return $this->hasOne(Operator::class, 'users_id', 'uuid');
    }

    public function tiketDibuat()
    {
        return $this->hasMany(Tiket::class, 'users_id', 'uuid');
    }
    public function tiketDitangani()
    {
        return $this->hasMany(Tiket::class, 'petugas_id', 'uuid');
    }
}
