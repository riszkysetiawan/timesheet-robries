<?php

namespace App\Exports;

use App\Models\Waste;
use App\Models\WasteStock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WasteExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Waste::with('barang', 'alasanWaste')->get()->map(function ($waste) {
            return [
                'kode_barang'   => $waste->kode_barang,
                'nama_barang'   => $waste->barang->nama_barang,
                'jumlah_reject' => $waste->jumlah,
                'alasan'        => $waste->alasanWaste->alasan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Jumlah Reject',
            'Alasan',
        ];
    }
}
