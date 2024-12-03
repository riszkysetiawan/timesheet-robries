<!DOCTYPE html>
<html>

<head>
    <title>Data Stock Barang</title>
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
            table-layout: fixed;
        }

        th,
        td {
            padding: 10px 12px;
            text-align: left;
            vertical-align: middle;
            font-size: 13px;
            word-wrap: break-word;
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
    <h1>Data Stock Barang</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th style="padding-left: 6rem">Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->kode_barang }}</td>
                        <td>{{ $stock->barang->nama_barang }}</td>
                        <td>{{ $stock->stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer>
        Data Stock Barang | Dicetak pada {{ date('Y-m-d') }}
    </footer>
</body>

</html>
