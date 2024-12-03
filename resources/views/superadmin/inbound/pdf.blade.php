<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            font-size: 12px;
        }

        .invoice-header {
            width: 100%;
            padding: 1rem 0;
            margin-bottom: 20px;
        }

        .invoice-header p {
            margin: 0;
        }

        .invoice-details,
        .customer-details {
            width: 100%;
            margin-bottom: 30px;
            /* Increased bottom margin for more space */
            margin-top: 5rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            /* Added margin-top for space above the table */
            margin-bottom: 2rem;
            /* Added margin-bottom for space below the table */
        }

        .table th,
        .table td {
            padding: 12px;
            /* Increased padding for better spacing in cells */
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-section {
            margin-top: 20px;
        }

        .total-section h4 {
            margin: 0;
            padding: 5px 0;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <div style="float: left; width: 50%;">
            <p>{{ $profile->nama_toko }}</p>
            <p>{{ $profile->alamat }}</p>
            <p>{{ $profile->email }}</p>
            <p>{{ $profile->no_telp }}</p>
            <p>Invoice: {{ $purchaseOrder->kode_po }}</p>
            <p>Tanggal Pembuatan: {{ $purchaseOrder->tgl_buat }}</p>
            <p>Estimasi Kedatangan: {{ $purchaseOrder->eta }}</p>
            <p>Status: {{ $pembelian->status }}</p>
        </div>
        <div style="float: right; width: 50%; text-align: right;">
            <p>Ditujukan Kepada: {{ $purchaseOrder->supplier->nama_supplier }}</p>
            <p>Alamat: {{ $purchaseOrder->supplier->alamat }}</p>
            <p>Email: {{ $purchaseOrder->supplier->email }}</p>
        </div>
    </div>

    <div class="invoice-details">
        <h3>Detail Produk</h3>
        <table class="table">
            <thead class="">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Jumlah PO</th>
                    <th class="text-right">Jumlah Actual</th>
                    <th class="text-right">Jumlah Reject</th>
                    <th class="text-right">Jumlah Final</th>
                    <th class="text-right">Satuan</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->details as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td class="text-right">{{ $detail->qty_po }}</td>
                        <td class="text-right">{{ $detail->qty_actual }}</td>
                        <td class="text-right">{{ $detail->reject ?? '0' }}</td>
                        <td class="text-right">{{ $detail->final_qty }}</td>
                        <td class="text-right">{{ $detail->satuan }}</td>
                        <td class="text-right">Rp.
                            {{ number_format($detail->inbound->purchaseOrder->details->first()->harga) }}</td>
                        <td class="text-right">Rp.
                            {{ number_format($detail->inbound->purchaseOrder->details->first()->sub_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <div style="width: 100%; text-align: right;">
            <h4>Total: Rp {{ number_format($pembelian->total) }}</h4>
        </div>
    </div>
</body>

</html>
