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
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row['kode_barang']) || !isset($row['jumlah_waste'])) {
            return null;
        }
        DB::transaction(function () use ($row) {
            $stockItem = Stock::where('kode_barang', $row['kode_barang'])->first();
            if ($stockItem) {
                if ($stockItem->stock >= $row['jumlah_waste']) {
                    $stockItem->stock -= $row['jumlah_waste'];
                    $stockItem->save();
                } else {
                    throw new \Exception("Stok tidak cukup untuk kode barang " . $row['kode_barang']);
                }
            }
            Waste::create([
                'kode_barang' => $row['kode_barang'],
                'jumlah' => $row['jumlah_waste'],
            ]);
        });
    }
}
