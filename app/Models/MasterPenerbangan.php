<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPenerbangan extends Model
{
    use HasFactory;

    protected $table = 'master_penerbangan';

    protected $fillable = [
        'no_penerbangan',
        'maskapai',
        'jenis_pesawat',
        'tipe_pesawat',
        'id_kota_asal',
        'id_kota_tujuan',
        'status_penerbangan',
    ];

    // Relasi ke tabel MasterKota (Kota Asal)
    public function kotaAsal()
    {
        return $this->belongsTo(MasterKota::class, 'id_kota_asal');
    }

    // Relasi ke tabel MasterKota (Kota Tujuan)
    public function kotaTujuan()
    {
        return $this->belongsTo(MasterKota::class, 'id_kota_tujuan');
    }
}