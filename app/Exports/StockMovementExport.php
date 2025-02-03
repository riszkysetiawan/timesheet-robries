<?php

namespace App\Exports;

use App\Models\StockMovement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockMovementExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Ambil data dari tabel stock_movement dengan filter tanggal.
     * @return Collection
     */
    public function collection()
    {
        $query = StockMovement::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get(['kode_barang', 'movement_type', 'quantity', 'created_at']);
    }

    /**
     * Header untuk file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Jenis Pergerakan',
            'Kuantitas',
            'Tanggal'
        ];
    }
}
