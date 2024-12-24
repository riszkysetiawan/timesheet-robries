<?php

namespace App\Imports;

use App\Models\WasteStock;
use App\Models\Stock;
use App\Models\Waste;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;

class WasteImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Handle each row of the import.
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row['kode_barang']) || !isset($row['jumlah_waste'])) {
            return null;
        }

        return DB::transaction(function () use ($row) {
            // Ambil item stock berdasarkan kode_barang
            $stockItem = Stock::where('kode_barang', $row['kode_barang'])->first();

            if (!$stockItem) {
                throw new \Exception("Stock tidak ditemukan untuk kode barang: " . $row['kode_barang']);
            }

            // Validasi jika stok tidak cukup
            if ($stockItem->stock < $row['jumlah_waste']) {
                throw new \Exception("Stok tidak cukup untuk kode barang: " . $row['kode_barang']);
            }

            // Kurangi stok
            $stockItem->decrement('stock', $row['jumlah_waste']);

            // Catat waste
            return Waste::create([
                'kode_barang' => $row['kode_barang'],
                'jumlah' => $row['jumlah_waste'],
            ]);
        });
    }
}
