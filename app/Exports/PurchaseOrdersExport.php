<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrdersExport implements FromCollection, WithHeadings
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
        $query = PurchaseOrder::with('details.barang', 'supplier')
            ->when($this->startDate && $this->endDate, function ($query) {
                return $query->whereBetween('tgl_buat', [$this->startDate, $this->endDate]);
            })
            ->orderBy('tgl_buat', 'asc') // Order by tgl_buat
            ->get();

        return $query->flatMap(function ($purchaseOrder) {
            return $purchaseOrder->details->map(function ($detail) use ($purchaseOrder) {
                return [
                    'kode_po'        => $purchaseOrder->kode_po,
                    'kode_barang'    => $detail->barang->kode_barang ?? 'Tidak Ada',
                    'nama_barang'    => $detail->barang->nama_barang ?? 'Tidak Ada',
                    'sub_total'      => $detail->sub_total,
                    'keterangan'     => $detail->keterangan ?? 'Tidak ada Keterangan',
                    'total_po'       => $purchaseOrder->total,
                    'status'         => $purchaseOrder->status,
                    'supplier'       => $purchaseOrder->supplier->nama_supplier,
                    'tgl_buat'       => $purchaseOrder->tgl_buat,
                    'eta'            => $purchaseOrder->eta,
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'Kode PO',
            'Kode Barang',
            'Nama Barang',
            'Sub Total',
            'Keterangan',
            'Total',
            'Status',
            'Supplier',
            'Tanggal Buat',
            'ETA',
        ];
    }
}
