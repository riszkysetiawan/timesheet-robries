<!DOCTYPE html>
<html>

<head>
    <title>Reorder Point Data</title>
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

        td:nth-child(3),
        td:nth-child(4),
        td:nth-child(5),
        td:nth-child(6),
        td:nth-child(7) {
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
    <h1>Data Reorder Point</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th> <!-- Header for nama barang -->
                    <th>Maximum Usage</th>
                    <th>Average Usage</th>
                    <th>Lead Time</th>
                    <th>Safety Stock</th>
                    <th>Reorder Point</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reorderPoints as $reorderPoint)
                    <tr>
                        <td>{{ $reorderPoint->kode_barang }}</td>
                        <td>{{ $reorderPoint->barang ? $reorderPoint->barang->nama_barang : 'Tidak Diketahui' }}</td>
                        <!-- Get nama_barang from related model -->
                        <td>{{ $reorderPoint->max_usage }}</td>
                        <td>{{ $reorderPoint->avg_usage }}</td>
                        <td>{{ $reorderPoint->lead_time }}</td>
                        <td>{{ $reorderPoint->ss }}</td>
                        <td>{{ $reorderPoint->rop }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer>
        Data Reorder Point | Printed on {{ date('Y-m-d') }}
    </footer>
</body>

</html>
