<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kargo extends Model
{
    use HasFactory;

    protected $table = 'kargo';

    // Konfigurasi Primary Key Custom
    protected $primaryKey = 'no_resi';
    public $incrementing = false; // Mematikan auto-increment karena tipe datanya string
    protected $keyType = 'string'; // Tipe data Primary Key

    protected $fillable = [
        'no_resi',
        'id_pengirim',
        'id_penerima',
        'id_kota_asal',
        'id_kota_tujuan',
        'id_jenis',
        'id_user',
        'berat',
        'isi_barang',
        'status_terakhir',
        'tgl_terima',
        'no_penerbangan',
        'maskapai',
    ];

    // --- Relasi BelongsTo (Menarik data dari tabel Master/Induk) ---

    public function pengirim()
    {
        return $this->belongsTo(Customer::class, 'id_pengirim');
    }

    public function penerima()
    {
        return $this->belongsTo(Customer::class, 'id_penerima');
    }

    public function kotaAsal()
    {
        return $this->belongsTo(MasterKota::class, 'id_kota_asal');
    }

    public function kotaTujuan()
    {
        return $this->belongsTo(MasterKota::class, 'id_kota_tujuan');
    }

    public function jenisBarang()
    {
        return $this->belongsTo(MasterJenisBarang::class, 'id_jenis');
    }

    public function userAdmin()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // --- Relasi HasMany (Menuju tabel Anak) ---
    public function history()
    {
        return $this->hasMany(HistoryStatus::class, 'no_resi', 'no_resi');
    }
}