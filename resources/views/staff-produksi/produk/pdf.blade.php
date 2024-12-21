<!DOCTYPE html>
<html>

<head>
    <title>Data Barang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        .table-container {
            margin: auto;
            width: 95%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            vertical-align: middle;
            font-size: 13px;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border-bottom: 3px solid #ddd;
        }

        td {
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #eaf4e6;
        }

        td:nth-child(4),
        td:nth-child(8),
        td:nth-child(9),
        td:nth-child(10),
        td:nth-child(11) {
            text-align: center;
        }

        td:nth-child(3) {
            text-align: center;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }

        @page {
            margin: 20px;
        }
    </style>
</head>

<body>
    <h1>Data Barang</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Barcode</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stock</th>
                    <th>Waste</th>
                    <th>Exp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)
                    <tr>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kode_barcode ?? 'Tidak ada barcode' }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        <td>{{ $barang->stocks->sum('stock') }}</td>
                        <td>{{ $barang->wasteStocks->sum('waste') }}</td>
                        <td>{{ $barang->exp }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer>
        Data Barang | Printed on {{ date('Y-m-d') }}
    </footer>
</body>

</html>
