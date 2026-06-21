<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'customers';

    // Kolom yang diizinkan untuk diisi massal (Mass Assignment)
    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'tipe_cust',
    ];

    // Relasi: Satu customer bisa menjadi pengirim di banyak kargo
    public function kargoDikirim()
    {
        return $this->hasMany(Kargo::class, 'id_pengirim');
    }

    // Relasi: Satu customer bisa menjadi penerima di banyak kargo
    public function kargoDiterima()
    {
        return $this->hasMany(Kargo::class, 'id_penerima');
    }
}