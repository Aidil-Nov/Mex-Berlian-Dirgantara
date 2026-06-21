<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKota extends Model
{
    use HasFactory;

    protected $table = 'master_kota';
    
    protected $fillable = ['nama_kota'];

    public function kargoAsal()
    {
        return $this->hasMany(Kargo::class, 'id_kota_asal');
    }

    public function kargoTujuan()
    {
        return $this->hasMany(Kargo::class, 'id_kota_tujuan');
    }
}