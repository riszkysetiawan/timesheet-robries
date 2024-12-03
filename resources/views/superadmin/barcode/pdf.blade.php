<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Barcode</title>
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
            width: 100%;
            padding: 0;
            text-align: center;
        }

        .barcode-wrapper {
            margin: 10px 0;
        }

        .barcode-wrapper img {
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

            .barcode-wrapper img {
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
        @foreach ($barangs as $barang)
            @if (!empty($barang->kode_barcode))
                @php
                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    $barcodeImage =
                        'data:image/png;base64,' .
                        base64_encode($generator->getBarcode($barang->kode_barcode, $generator::TYPE_CODE_128));
                @endphp
                <div class="barcode-wrapper">
                    <img src="{{ $barcodeImage }}" alt="Barcode">
                    <div class="kode-barang">{{ $barang->kode_barcode }}</div>
                </div>
                <hr>
            @else
                <p>Barcode tidak tersedia</p>
            @endif
        @endforeach
    </div>
</body>

</html>
