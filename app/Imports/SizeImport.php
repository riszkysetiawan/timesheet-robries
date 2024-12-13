<?php

namespace App\Imports;

use App\Models\Size;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Log;

class SizeImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Fungsi ini dipanggil untuk setiap baris yang ada di file Excel.
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!isset($row['kode_produk']) || !isset($row['size'])) {
            Log::error('Invalid Row: Missing required columns (kode_produk or size).');
            return null;
        }
        $size = Size::where('kode_produk', $row['kode_produk'])->first();

        if ($size) {
            $size->size = $row['size'];
            $size->save();
        } else {
            Size::create([
                'kode_produk' => $row['kode_produk'],
                'size' => $row['size']
            ]);
        }

        return null;
    }
}
