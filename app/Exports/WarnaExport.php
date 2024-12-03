<?php

namespace App\Exports;

use App\Models\Warna;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WarnaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Warna::all()->map(function ($warna) {
            return [
                'id'    => $warna->id,
                'warna'    => $warna->warna,
                'keterangan'        => $warna->kode_barcode ?? 'Tidak ada keterangan',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Warna',
            'Warna',
            'Keterangan',
        ];
    }
}
