<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProdukImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row)
    {
        if (!isset($row['kode_produk']) || !isset($row['nama_barang'])) {
            return null;
        }
        $produk = Produk::find($row['kode_produk']);
        if ($produk) {
            $produk->update([
                'nama_barang' => $row['nama_barang'],
                // 'kode_barcode' => $row['kode_barcode'],
                // 'harga' => $row['harga'],
                'id_warna' => $row['warna'],
                // 'id_kategori' => $row['kategori'],
                'id_size' => $row['size'],
                // 'keterangan' => $row['keterangan'],
            ]);
        } else {
            Produk::create([
                'kode_produk' => $row['kode_produk'],
                'nama_barang' => $row['nama_barang'],
                // 'kode_barcode' => $row['kode_barcode'],
                // 'harga' => $row['harga'],
                'id_warna' => $row['warna'],
                'id_size' => $row['size'],
                // 'id_kategori' => $row['kategori'],
                // 'keterangan' => $row['keterangan'],
            ]);
        }
    }
}
