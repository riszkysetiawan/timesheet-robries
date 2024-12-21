<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            margin: 0;
            padding: 0;
        }

        .label {
            width: 95mm;
            height: 145mm;
            padding: 5mm;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .content h4 {
            margin: 5px 0;
            /* Berikan jarak 5px antara elemen */
            padding: 0;
            font-size: 12px;
            /* Sesuaikan ukuran font */
            line-height: 1.2;
            /* Jarak vertikal antar baris */
        }

        .header {
            text-align: center;
        }

        .header h1 {
            font-size: 12px;
            margin: 0;
        }

        .header p {
            font-size: 10px;
            margin: 0;
        }

        .qr-code {
            text-align: center;
        }

        .qr-code img {
            width: 50mm;
            height: auto;
        }

        .footer p {
            margin: 0;
            padding: 0;
            font-size: 10px;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>

</head>

<body onload="window.print()">
    @foreach ($data as $item)
        <div class="label">
            <div class="header">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="text-center" width="60px">
                <h1>{{ $item['company_name'] }}</h1>
                <p>{{ $item['tagline'] }}</p>
            </div>

            <h4 style="text-align: center; margin: 0;">{{ $item['so_number'] }}</h4>

            <div class="content">
                <h4 style="padding: 2px 0px"> {{ $item['nama_produk'] }}</h4>
                <h4>{{ $item['size'] }}</h4>
                <h4>{{ $item['color'] }}</h4>
                <h4>{{ $item['qty'] }}</h4>
            </div>

            <div class="qr-code">
                <img src="{{ $item['qr_code_url'] }}" alt="QR Code">
                <p><strong>{{ $item['barcode'] }}</strong></p>
            </div>

            <div class="footer">
                <div class="qc-approval">
                    <p><strong>QC Approval:</strong> __________________</p>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html>
