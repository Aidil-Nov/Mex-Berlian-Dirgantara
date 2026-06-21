<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStatus extends Model
{
    use HasFactory;

    protected $table = 'history_status';

    // Kita matikan update updated_at otomatis karena tabel log biasanya hanya di-insert
    const UPDATED_AT = null;

    protected $fillable = [
        'no_resi',
        'id_user',
        'status',
        'keterangan',
        'waktu_update',
    ];

    public function kargo()
    {
        return $this->belongsTo(Kargo::class, 'no_resi', 'no_resi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}