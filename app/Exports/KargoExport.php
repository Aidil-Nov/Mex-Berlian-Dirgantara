<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KargoExport implements FromCollection, WithHeadings
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(fn($k) => [
            $k->no_resi,
            $k->pengirim->nama,
            $k->penerima->nama,
            $k->kotaAsal->nama_kota,
            $k->kotaTujuan->nama_kota,
            $k->berat,
            $k->isi_barang,
            $k->status_terakhir,
            $k->tgl_terima,
            $k->maskapai
        ]);
    }

    public function headings(): array
    {
        return ['No Resi', 'Pengirim', 'Penerima', 'Asal', 'Tujuan', 'Berat (kg)', 'Isi', 'Status', 'Tgl Terima', 'Maskapai'];
    }
}