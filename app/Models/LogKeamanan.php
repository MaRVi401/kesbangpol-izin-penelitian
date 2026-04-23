<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LogKeamanan extends Model 
{
    use HasUuids;

    protected $table = 'log_keamanan';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    
    protected $fillable = [
        'users_id', 
        'username_attempt', 
        'tipe_event', 
        'ip_address', 
        'user_agent', 
        'is_suspicious'
    ];

    protected $casts = [
        'is_suspicious' => 'boolean',
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class, 'users_id', 'uuid'); 
    }
}