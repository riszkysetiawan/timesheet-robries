<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StocksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Stock::with('produk')->get()->map(function ($stock) {
            return [
                'kode_produk'    => $stock->kode_produk,
                'nama_barang'    => $stock->produk->nama_barang,
                'stock'          => $stock->stock,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Stock',
        ];
    }
}
