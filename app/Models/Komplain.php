<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komplain extends Model
{
    use HasFactory;

    protected $table = 'komplain';
    protected $primaryKey = 'id_komplain';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_komplain', 'no_resi', 'nama_pelapor', 'hp_pelapor', 
        'email_pelapor', 'kategori', 'tingkat_keparahan', 'deskripsi', 
        'estimasi_klaim', 'id_user', 'channel', 'status', 'tindakan_solusi'
    ];

    // Relasi ke Kargo
    public function kargo()
    {
        return $this->belongsTo(Kargo::class, 'no_resi', 'no_resi');
    }

    // Relasi ke Admin yang mencatat
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}