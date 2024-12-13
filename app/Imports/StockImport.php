<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Log;

class StockImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Fungsi ini dipanggil untuk setiap baris yang ada di file Excel.
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Debugging untuk memeriksa isi $row
        Log::info('Row Data:', $row);

        // Pastikan kolom "Kode Produk" dan "Jumlah Stock" ada
        if (!isset($row['kode_produk']) || !isset($row['jumlah_stock'])) {
            Log::error('Invalid Row: Missing required columns (kode_produk or jumlah_stock).');
            return null;
        }

        // Pastikan "Jumlah Stock" adalah angka
        if (!is_numeric($row['jumlah_stock'])) {
            Log::error('Invalid Row: Jumlah Stock is not a number.', ['row' => $row]);
            return null;
        }

        // Cari data stock berdasarkan kode_produk
        $stock = Stock::where('kode_produk', $row['kode_produk'])->first();

        if ($stock) {
            // Jika data stock sudah ada, tambahkan jumlah stock
            $stock->stock += (int)$row['jumlah_stock'];
            $stock->save();

            Log::info('Stock Updated:', [
                'kode_produk' => $row['kode_produk'],
                'new_stock' => $stock->stock,
            ]);
        } else {
            // Jika data stock belum ada, buat data baru
            Stock::create([
                'kode_produk' => $row['kode_produk'],
                'stock' => (int)$row['jumlah_stock']
            ]);

            Log::info('Stock Created:', [
                'kode_produk' => $row['kode_produk'],
                'stock' => (int)$row['jumlah_stock'],
            ]);
        }

        return null;
    }
}
