<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            Log::error("Missing required fields: " . json_encode($row));
            return null; // Abaikan baris jika data tidak lengkap
        }

        // Cari ID berdasarkan kategori
        $kategori = DB::table('kategori_barang')
            ->whereRaw('LOWER(nama_kategori) LIKE ?', ['%' . strtolower($row['kategori']) . '%'])
            ->first();

        if (!$kategori) {
            Log::error("Category not found for kategori: " . $row['kategori']);
            return null; // Abaikan jika kategori tidak ditemukan
        }

        // Cari ID berdasarkan satuan
        $satuan = DB::table('satuan_barang')
            ->whereRaw('LOWER(satuan) LIKE ?', ['%' . strtolower($row['satuan']) . '%'])
            ->first();

        if (!$satuan) {
            Log::error("Unit not found for satuan: " . $row['satuan']);
            return null; // Abaikan jika satuan tidak ditemukan
        }

        // Validasi format input (opsional)
        $validator = Validator::make($row, [
            'kode_barang' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'type' => 'nullable|string|in:Standard,Special Color',
        ]);

        // Skip jika validasi gagal
        if ($validator->fails()) {
            Log::error('Validation failed: ' . json_encode($validator->errors()->toArray()));
            return null;
        }

        // Update jika barang sudah ada, jika tidak maka create
        return Barang::updateOrCreate(
            ['kode_barang' => $row['kode_barang']], // Kondisi untuk menemukan data
            [
                'nama_barang' => $row['nama_barang'],
                'id_satuan' => $satuan->id, // Gunakan ID satuan yang ditemukan
                'id_kategori' => $kategori->id, // Gunakan ID kategori yang ditemukan
                'type' => $row['type'] ?? null,
            ]
        );
    }
}
