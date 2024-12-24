<?php

namespace App\Imports;

use App\Models\Production;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProductionImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Handle the import row.
     *
     * @param array $row
     * @return Production|null
     */
    public function model(array $row)
    {
        \Log::info('Processing row: ' . json_encode($row));

        // Convert Excel date to a readable format
        $tanggal = $this->convertExcelDate($row['tanggal']);

        // Validate required fields
        if (empty($row['so_number']) || empty($tanggal) || empty($row['nama_produk']) || empty($row['ukuran']) || empty($row['warna'])) {
            \Log::error('Missing required fields: ' . json_encode($row));
            return null; // Skip rows with missing required data
        }

        // Cari ID berdasarkan ukuran
        $size = DB::table('size')
            ->whereRaw('LOWER(size) LIKE ?', ['%' . strtolower($row['ukuran']) . '%'])
            ->first();
        if (!$size) {
            \Log::error("Size not found for ukuran: " . $row['ukuran']);
            return null;
        }

        // Cari ID berdasarkan warna
        $color = DB::table('warna')
            ->whereRaw('LOWER(warna) LIKE ?', ['%' . strtolower($row['warna']) . '%'])
            ->first();
        if (!$color) {
            \Log::error("Color not found for warna: " . $row['warna']);
            return null;
        }

        // Lakukan validasi setelah ID ditemukan
        $validator = Validator::make([
            'so_number' => $row['so_number'],
            'tanggal' => $tanggal,
            'nama_produk' => $row['nama_produk'],
            'qty' => $row['qty'],
            'ukuran' => $row['ukuran'],
            'warna' => $row['warna'],
            'barcode' => $row['barcode'],
        ], [
            'so_number' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nama_produk' => 'required|string|max:255',
            'qty' => 'required|string',
            'ukuran' => 'required|string',
            'warna' => 'required|string',
            'barcode' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed: ' . json_encode($validator->errors()->toArray()));
            return null;
        }

        try {
            // Insert new record into the database
            return Production::create([
                'so_number' => $row['so_number'],
                'tgl_production' => $tanggal,
                'nama_produk' => $row['nama_produk'],
                'qty' => $row['qty'],
                'id_size' => $size->id,
                'id_color' => $color->id,
                'barcode' => $row['barcode'],
                'finish_rework' => null,
                'progress' => null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to insert production: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Convert Excel serial date to a readable date format
     *
     * @param mixed $excelDate
     * @return string|null
     */
    private function convertExcelDate($excelDate)
    {
        try {
            if (is_numeric($excelDate)) {
                return \Carbon\Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d'));
            }
            return \Carbon\Carbon::parse($excelDate)->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::error('Error converting Excel date: ' . $e->getMessage());
            return null;
        }
    }
}
