<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KategoriExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Kategori::all()->map(function ($kategoris) {
            return [
                'id'    => $kategoris->id,
                'nama_kategori'    => $kategoris->nama_kategori,
                'keterangan'        => $kategoris->kode_barcode ?? 'Tidak ada keterangan',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID ',
            'Kategori',
            'Keterangan',
        ];
    }
}
