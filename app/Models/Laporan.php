<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'id_laporan',
        'jenis_laporan',
        'periode_label',
        'file_path',
        'user_id',
        'status',         // Baru
        'validator_id',   // Baru
        'validated_at'    // Baru
    ];

    // Relasi ke user pembuat laporan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke user yang memvalidasi (Manajer)
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}