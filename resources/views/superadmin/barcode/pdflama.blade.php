<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode PDF</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
        }

        .barcode {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <h2>{{ $barang->nama_barang }}</h2>
    <div class="barcode">
        <img src="{{ $barcodeImage }}" alt="Barcode">
    </div>
    <p>{{ $barang->kode_barcode }}</p>
</body>

</html>
