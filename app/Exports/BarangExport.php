<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
     * Menyediakan data untuk export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil data dari model Barang
        return Barang::with(['kategori', 'satuan'])->get()->map(function ($barang) {
            return [
                'Kode Barang' => $barang->kode_barang,
                'Nama Barang' => $barang->nama_barang,
                'Type' => $barang->type ?? '-',
                'Kategori' => $barang->kategori->nama_kategori ?? '-',
                'Satuan' => $barang->satuan->satuan ?? '-',
            ];
        });
    }

    /**
     * Menentukan header untuk file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Type',
            'Kategori',
            'Satuan',
        ];
    }
}
