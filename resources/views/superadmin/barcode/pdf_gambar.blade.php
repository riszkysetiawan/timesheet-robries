<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode PDF</title>
    <style>
        @page {
            size: 48mm auto;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            width: 48mm;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
        }

        .barcode-container {
            margin: 0 auto;
            padding: 0;
            width: 100%;
            text-align: center;
        }

        .header {
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 10px;
            margin: 0;
        }

        .header p {
            font-size: 8px;
            margin: 2px 0;
        }

        .barcode {
            margin: 10px 0;
        }

        .barcode img {
            width: 100%;
            height: auto;
        }

        .kode-barang {
            font-size: 8px;
            margin-top: 2px;
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

            .barcode img {
                width: 100%;
                height: auto;
            }

            .kode-barang {
                font-size: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="barcode-container">
        <!-- Header Section -->
        <div class="header">
            <h2>{{ $barang->nama_barang }}</h2>
        </div>
        <hr>

        <!-- Barcode Section -->
        <div class="barcode">
            <img src="{{ $barcodeImage }}" alt="Barcode">
        </div>
        <div class="kode-barang">{{ $barang->kode_barcode }}</div>
        <hr>
    </div>
</body>

</html>
