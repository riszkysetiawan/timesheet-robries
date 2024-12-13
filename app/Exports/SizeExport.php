<?php

namespace App\Exports;

use App\Models\size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SizeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Size::all()->map(function ($kategoris) {
            return [
                'id'    => $kategoris->id,
                'size'    => $kategoris->size,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Ukuran',
        ];
    }
}
