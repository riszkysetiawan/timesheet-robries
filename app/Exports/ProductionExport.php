<?php

namespace App\Exports;

use App\Models\Production;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductionExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Ambil semua nama proses dari database
        $allProcesses = Production::with('timers.proses')->get()->flatMap(function ($production) {
            return $production->timers->map(function ($timer) {
                return optional($timer->proses)->nama;
            });
        })->unique()->filter();

        $query = Production::with(['timers.proses', 'timers.user', 'warna', 'size'])
            ->orderBy('created_at', 'desc');

        // Terapkan filter tanggal hanya jika $startDate dan $endDate diberikan
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $productions = $query->get();

        return $productions->map(function ($production) use ($allProcesses) {
            $result = [
                'SO Number' => $production->so_number,
                'Tanggal' => $production->created_at->format('Y-m-d'),
                'Warna' => optional($production->warna)->warna ?? '-',
                'Size' => optional($production->size)->size ?? '-',
                'Barcode' => $production->barcode,
            ];

            // Pastikan semua proses termasuk, meskipun tidak ada datanya
            foreach ($allProcesses as $process) {
                $timer = $production->timers->firstWhere('proses.nama', $process);
                $result["{$process} Time"] = $timer ? $timer->waktu : 'tidak di scan';
                $result["{$process} Operator"] = $timer && $timer->user ? $timer->user->nama : 'tidak di scan';
            }

            return $result;
        });
    }


    public function headings(): array
    {
        // Default headings
        $headings = [
            'SO Number',
            'Tanggal',
            'Warna',
            'Size',
            'Barcode',
        ];

        // Ambil semua nama proses dari database untuk heading dinamis
        $processes = Production::with('timers.proses')->get()->flatMap(function ($production) {
            return $production->timers->map(function ($timer) {
                return optional($timer->proses)->nama;
            });
        })->unique()->filter();

        foreach ($processes as $process) {
            if ($process) {
                $headings[] = "{$process} Time";
                $headings[] = "{$process} Operator";
            }
        }

        return $headings;
    }
}
