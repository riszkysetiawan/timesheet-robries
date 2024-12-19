<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class BarangImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Import data ke model Barang
     *
     * @param array $row
     * @return Barang|null
     */
    public function model(array $row)
    {
        // Validasi input wajib ada
        if (empty($row['kode_barang']) || empty($row['nama_barang'])) {
            return null; // Abaikan baris jika data tidak lengkap
        }

        // Validasi format input (opsional)
        $validator = Validator::make($row, [
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'nullable|numeric|exists:satuan_barang,id',
            'kategori' => 'nullable|numeric|exists:kategori_barang,id',
            'type' => 'nullable|string|in:Standard,Special Color',
        ]);

        // Skip jika validasi gagal
        if ($validator->fails()) {
            return null;
        }

        // Update jika barang sudah ada, jika tidak maka create
        return Barang::updateOrCreate(
            ['kode_barang' => $row['kode_barang']], // Kondisi untuk menemukan data
            [
                'nama_barang' => $row['nama_barang'],
                'id_satuan' => $row['satuan'] ?? null,
                'id_kategori' => $row['kategori'] ?? null,
                'type' => $row['type'] ?? null,
            ]
        );
    }
}
