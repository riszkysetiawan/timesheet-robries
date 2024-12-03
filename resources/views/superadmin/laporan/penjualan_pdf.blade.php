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
            /* Menggunakan padding 1rem untuk jarak atas dan bawah */
            margin-bottom: 20px;
        }

        .invoice-header p {
            margin: 0;
        }

        .invoice-details,
        .customer-details {
            width: 100%;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
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
            <p>{{ $profile->alamat }}</p>
            <p>{{ $profile->email }}</p>
            <p>{{ $profile->no_telp }}</p>
        </div>
        <div style="float: right; width: 50%; text-align: right;">
            <p>Invoice: {{ $penjualans->kode_invoice }}</p>
            <p>Tanggal Pembuatan: {{ $penjualans->tgl_buat }}</p>
        </div>
    </div>

    <div class="invoice-details">
        <h3>Detail Produk</h3>
        <table class="table">
            <thead class="">
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Satuan</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualans->detailPenjualans as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td class="text-right">{{ $detail->qty }}</td>
                        <td class="text-right">{{ $detail->satuan }}</td>
                        <td class="text-right">Rp. {{ number_format($detail->harga) }}</td>
                        <td class="text-right">Rp. {{ number_format($detail->sub_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <div style="width: 100%; text-align: right;">
            <h4>Total: Rp {{ number_format($penjualans->total) }}</h4>
            <h4>Jumlah Bayar: Rp {{ number_format($penjualans->jumlah_bayar) }}</h4>
            <h4>Kembalian: Rp {{ number_format($penjualans->kembali) }}</h4>
        </div>
    </div>
</body>

</html>
