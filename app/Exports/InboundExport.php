<?php

namespace App\Exports;

use App\Models\Inbound;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InboundExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Inbound::with('details.barang', 'supplier')
            ->when($this->startDate && $this->endDate, function ($query) {
                return $query->whereBetween('eta', [$this->startDate, $this->endDate]);
            })
            ->get();

        return $query->flatMap(function ($inbound) {
            return $inbound->details->map(function ($detail) use ($inbound) {
                return [
                    'kode_po'        => $inbound->kode_po,
                    'kode_pi'        => $inbound->kode_pi ?? '',
                    'kode_barang'    => $detail->barang->kode_barang ?? 'Tidak Ada',
                    'nama_barang'    => $detail->barang->nama_barang ?? 'Tidak Ada',
                    'qty_po'         => $detail->qty_po ?? '0',
                    'qty_actual'     => $detail->qty_actual ?? '0',
                    'final_qty'      => $detail->final_qty ?? '0',
                    'reject'         => $detail->reject ?? '0',
                    'satuan'         => $detail->satuan,
                    'eta'            => $inbound->eta,
                    'supplier'       => $inbound->supplier->nama_supplier ?? 'Tidak Ada',
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'Kode PO',
            'PI Number',
            'Kode Barang',
            'Nama Barang',
            'Quantity PO',
            'Quantity Aktual',
            'Final Quantity',
            'Reject',
            'Satuan',
            'ETA',
            'Supplier',
        ];
    }
}
