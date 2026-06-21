<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJenisBarang extends Model
{
    use HasFactory;

    protected $table = 'master_jenis_barang';

    protected $fillable = ['nama_jenis'];

    public function kargo()
    {
        return $this->hasMany(Kargo::class, 'id_jenis');
    }
}