<?php

namespace App\Exports;

use App\Models\DailyStockHistory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryStockExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        $query = DailyStockHistory::query(); // Sesuaikan dengan model Anda

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('rekap_date', [$this->startDate, $this->endDate]);
        }

        return $query->get(['kode_barang', 'rekap_date', 'total_in', 'total_out', 'ending_stock']);
    }

    /**
     * Tambahkan header untuk Excel
     * @return array
     */
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Tanggal',
            'Total Masuk',
            'Total Keluar',
            'Stok Akhir'
        ];
    }
}
