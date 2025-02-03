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
        // Ambil semua proses dari database
        $allProcesses = \App\Models\Proses::all(); // Ambil semua proses, bukan hanya yang terkait dengan timers

        $query = Production::with(['timers.proses', 'timers.user', 'timers.oven', 'warna', 'size'])
            ->orderBy('tgl_production', 'desc');

        // Terapkan filter tanggal hanya jika $startDate dan $endDate diberikan
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_production', [$this->startDate, $this->endDate]);
        }

        $productions = $query->get();

        return $productions->map(function ($production) use ($allProcesses) {
            $result = [
                'SO Number' => $production->so_number,
                'Nama Produk' => $production->nama_produk,
                'Tanggal' => Carbon::parse($production->tgl_production)->format('Y-m-d'),
                'Warna' => optional($production->warna)->warna ?? '-',
                'Size' => optional($production->size)->size ?? '-',
                'Barcode' => $production->barcode,
            ];

            // Pastikan semua proses termasuk, meskipun tidak ada datanya
            foreach ($allProcesses as $process) {
                $timer = $production->timers->firstWhere('proses.id', $process->id);

                // Validasi untuk memastikan timer dan proses tidak null
                if ($timer && $timer->proses) {
                    $processName = $timer->proses->nama;  // Ambil nama proses jika timer dan proses ada
                } else {
                    $processName = $process->nama;  // Jika tidak ada timer, gunakan nama proses
                }

                // Set waktu dan operator
                $result["{$processName} Time"] = $timer ? $timer->waktu : 'tidak di scan';
                $result["{$processName} Operator"] = $timer && $timer->user ? $timer->user->nama : 'tidak di scan';

                // Tambahkan nama oven setelah Proses ID 1 dan 2
                if (in_array($process->id, [1, 2])) {
                    $result["{$processName} Nomor Oven"] = $timer && $timer->oven ? $timer->oven->nama : '-';
                }
            }

            return $result;
        });
    }

    public function headings(): array
    {
        // Default headings
        $headings = [
            'SO Number',
            'Nama Produk',
            'Tanggal',
            'Warna',
            'Size',
            'Barcode',
        ];

        // Ambil semua proses dari database untuk heading dinamis
        $processes = \App\Models\Proses::all(); // Ambil semua proses dari tabel proses

        foreach ($processes as $process) {
            if ($process) {
                $headings[] = "{$process->nama} Time";
                $headings[] = "{$process->nama} Operator";

                // Tambahkan heading untuk "Nomor Oven" setelah Proses ID 1 dan 2
                if (in_array($process->id, [1, 2])) {  // Mengecek ID proses 1 dan 2
                    $headings[] = "Nomor Oven";
                }
            }
        }

        return $headings;
    }
}
