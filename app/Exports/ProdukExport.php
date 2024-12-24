<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Produk::with('kategori', 'warna', 'size')->get()->map(function ($produk) {
            return [
                'kode_produk'    => $produk->kode_produk,
                'nama_produk'    => $produk->nama_barang,
                'size'       => $produk->size->size ?? '',
                'warna'         => $produk->warna->warna ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Ukuran',
            'Warna',
        ];
    }
}
