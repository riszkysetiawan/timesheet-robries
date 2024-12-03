@foreach ($penjualans as $index => $penjualan)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $penjualan->kode_invoice }}</td>
        <td>{{ $penjualan->nama_kasir }}</td>
        <td>{{ $penjualan->tgl_buat }}</td>
        <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
        <td class="text-center">

            <button type="button" class="btn btn-outline-info btn-rounded mb-2 me-4 btn-preview"
                data-id="{{ $penjualan->kode_invoice }}">
                Preview
            </button>

            <a href="{{ route('penjualan.download.pdf.admin', Crypt::encryptString($penjualan->kode_invoice)) }}"
                class="btn btn-outline-success btn-rounded mb-2 me-4">Download
                Pdf</a>
            <a href="{{ route('detail.penjualan.admin', Crypt::encryptString($penjualan->kode_invoice)) }}"
                class="btn btn-outline-info btn-rounded mb-2 me-4">Detail</a>
        </td>
    </tr>
@endforeach
