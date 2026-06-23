<?php 
namespace App\Models; 

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Concerns\HasUuids; 

class SuratPermohonanIzinPenelitian extends Model 
{
    use HasUuids; 

    protected $table = 'surat_permohonan_izin_penelitian'; 
    protected $primaryKey = 'uuid'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 

    protected $guarded = []; // Kolom file_surat_signed_path otomatis diizinkan untuk Mass Assignment

    public function tiket() 
    { 
        return $this->belongsTo(Tiket::class, 'tiket_id', 'uuid'); 
    } 

    public function penandatangan() 
    { 
        return $this->morphTo(); 
    } 
}