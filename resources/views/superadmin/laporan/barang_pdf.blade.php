<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Barang</h1>

        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Stock</th>
                    <th>Jumlah Waste</th>
                    <th>Jumlah Barang Masuk</th>
                    <th>Jumlah Barang Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? 'Tidak Ada' }}</td>
                        <td>{{ $barang->satuan->satuan ?? 'Tidak Ada' }}</td>
                        <td>{{ $barang->stocks->sum('stock') ?? 0 }}</td> <!-- Total stock -->
                        <td>{{ $barang->wasteStocks->sum('waste') ?? 0 }}</td> <!-- Total waste -->
                        <td>{{ $barang->detailPurchaseOrders->sum('qty') ?? 0 }}</td> <!-- Total received -->
                        <td>{{ $barang->detailPenjualans->sum('qty') ?? 0 }}</td> <!-- Total sold -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Generated on {{ date('d-m-Y H:i:s') }}</p>
        </div>
    </div>
</body>

</html>
