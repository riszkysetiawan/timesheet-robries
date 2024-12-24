<?php

namespace App\Imports;

use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProdukImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    public function model(array $row)
    {
        // Validasi input wajib ada
        if (empty($row['kode_produk']) || empty($row['nama_barang'])) {
            Log::error("Missing required fields: " . json_encode($row));
            return null; // Abaikan jika data tidak lengkap
        }

        // Cari ID berdasarkan warna
        $warna = DB::table('warna')
            ->whereRaw('LOWER(warna) LIKE ?', ['%' . strtolower($row['warna']) . '%'])
            ->first();

        if (!$warna) {
            Log::error("Color not found for warna: " . $row['warna']);
            return null; // Abaikan jika warna tidak ditemukan
        }

        // Cari ID berdasarkan size
        $size = DB::table('size')
            ->whereRaw('LOWER(size) LIKE ?', ['%' . strtolower($row['size']) . '%'])
            ->first();

        if (!$size) {
            Log::error("Size not found for size: " . $row['size']);
            return null; // Abaikan jika ukuran tidak ditemukan
        }

        // Update jika produk sudah ada, jika tidak maka create
        return Produk::updateOrCreate(
            ['kode_produk' => $row['kode_produk']], // Kondisi untuk menemukan data
            [
                'nama_barang' => $row['nama_barang'],
                'id_warna' => $warna->id, // Gunakan ID warna yang ditemukan
                'id_size' => $size->id,   // Gunakan ID size yang ditemukan
            ]
        );
    }
}
