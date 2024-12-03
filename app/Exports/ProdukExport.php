<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Produk::with('kategori', 'warna')->get()->map(function ($produk) {
            return [
                'kode_produk'    => $produk->kode_produk,
                'nama_produk'    => $produk->nama_barang,
                'barcode'        => $produk->kode_barcode ?? 'Tidak ada barcode',
                'harga_jual'          => $produk->harga ?? '',
                'keterangan'     => $produk->keterangan ?? '',
                'kategori'       => $produk->kategori->nama_kategori ?? '',
                'warna'         => $produk->warna->warna ?? '',
                'stock'          => $produk->stocks->sum('stock') ?? '',
                'waste'          => $produk->waste->sum('waste') ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Barcode',
            'Harga',
            'Keterangan',
            'Kategori',
            'Warna',
            'Stock',
            'Waste',
        ];
    }
}
