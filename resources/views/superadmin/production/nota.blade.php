<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nota Penjualan</title>
    <style>
        @page {
            size: 48mm auto;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            /* Increased font size */
            width: 48mm;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
        }

        .nota-container {
            margin: 0 auto;
            padding: 0;
            width: 100%;
            text-align: center;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 10px;
            /* Increased font size for store name */
            margin: 0;
        }

        .header p,
        .footer p,
        .content p {
            font-size: 8px;
            /* Increased font size for readability */
            margin: 2px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table td,
        .table th {
            padding: 2px;
            text-align: center;
            word-wrap: break-word;
            font-size: 8px;
            /* Increased font size for table content */
        }

        /* Adjusted column widths for better fit on 48mm paper */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 40%;
            /* Barang column */
            text-align: left;
            /* Left-align for readability */
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 10%;
            /* Qty column */
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 20%;
            /* Harga column */
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 20%;
            /* Total column */
        }

        .footer {
            margin-top: 5px;
        }

        hr {
            border: 0;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        /* CSS for print */
        @media print {
            body {
                width: 48mm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .nota-container {
                width: 100%;
                margin: 0 auto;
            }

            .table td,
            .table th {
                font-size: 8px;
                /* Ensure table font size remains consistent */
            }
        }
    </style>
</head>

<body>
    <!-- Nota Content -->
    <div class="nota-container">
        <!-- Header Section -->
        <div class="header">
            <h2>{{ $profile->nama_toko ?? 'Nama Toko' }}</h2>
            <p>{{ $profile->alamat ?? 'Alamat Toko' }}</p>
            <p>Telp: {{ $profile->no_telp ?? 'No. Telepon' }}</p>
            <p>Email: {{ $profile->email ?? 'Email Toko' }}</p>
        </div>
        <hr>

        <!-- Sales Information -->
        <div class="content">
            <p>Kode Invoice: {{ $penjualan->kode_invoice }}</p>
            <p>Nama Kasir: {{ $penjualan->nama_kasir }}</p>
            <p>Tanggal: {{ $penjualan->created_at->format('d/m/Y H:i') }}</p>
            <hr>

            <!-- Items Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan->detailPenjualans as $detail)
                        <tr>
                            <td>{{ $detail->barang->nama_barang }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->qty * $detail->harga, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <!-- Payment Summary -->
            <p>Total: Rp {{ number_format($penjualan->total, 0, ',', '.') }}</p>
            <p>Jumlah Bayar: Rp {{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</p>
            <p>Kembalian: Rp {{ number_format($penjualan->kembali, 0, ',', '.') }}</p>

        </div>
        <hr>

        <!-- Footer Section -->
        <div class="footer">
            <p>Terima Kasih!</p>
            <p>Selamat Belanja Kembali</p>
        </div>
    </div>
</body>

</html>
