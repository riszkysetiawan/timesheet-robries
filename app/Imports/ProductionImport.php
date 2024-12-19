<?php

namespace App\Imports;

use App\Models\Production;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProductionImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Import data to the Production model
     *
     * @param array $row
     * @return Production|null
     */
    public function model(array $row)
    {
        // Log raw row data for debugging
        \Log::info('Processing row: ' . json_encode($row));

        // Convert Excel date to a readable format
        $tanggal = $this->convertExcelDate($row['tanggal']);

        // Validate required fields
        if (empty($row['so_number']) || empty($tanggal) || empty($row['kode_barang']) || empty($row['ukuran']) || empty($row['warna'])) {
            \Log::error('Missing required fields: ' . json_encode($row));
            return null; // Skip rows with missing required data
        }

        // Validate input formats
        $validator = Validator::make([
            'so_number' => $row['so_number'],
            'tanggal' => $tanggal,
            'kode_barang' => $row['kode_barang'],
            'qty' => $row['qty'],
            'ukuran' => $row['ukuran'],
            'warna' => $row['warna'],
            'barcode' => $row['barcode'],
        ], [
            'so_number' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kode_barang' => 'required|string|max:255|exists:produk,kode_produk',
            'qty' => 'required|string',
            'ukuran' => 'required|integer',
            'warna' => 'required|integer',
            'barcode' => 'required|string|max:255',
        ]);

        // Skip row if validation fails
        if ($validator->fails()) {
            \Log::error('Validation failed: ' . json_encode($validator->errors()->toArray()));
            return null;
        }

        try {
            // Insert new record into the database
            return Production::create([
                'so_number' => $row['so_number'],
                'tgl_production' => $tanggal,
                'kode_produk' => $row['kode_barang'],
                'qty' => $row['qty'],
                'id_size' => $row['ukuran'],
                'id_color' => $row['warna'],
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
