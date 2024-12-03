@extends('superadmin.partials.pemasok')
@section('title', 'Laporan Pembelian')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Stock</th>
                                        <th>Jumlah Waste</th>
                                        <th>Jumlah Barang Keluar</th>
                                        <th>Jumlah Barang Masuk</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!-- Button Download Excel -->
                    <button class="btn btn-outline-success btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('download.laporan.excel.barang.admin') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-download" viewBox="0 0 16 16">
                            <path
                                d="M.5 9.9V12.5a1.5 1.5 0 0 0 1.5 1.5h12a1.5 1.5 0 0 0 1.5-1.5V9.9a.5.5 0 0 1 1 0v2.6A2.5 2.5 0 0 1 14 15H2A2.5 2.5 0 0 1 .5 12.5V9.9a.5.5 0 0 1 1 0ZM7.646 10.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.293V1.5a.5.5 0 0 0-1 0v7.793L5.354 7.146a.5.5 0 1 0-.708.708l3 3Z" />
                        </svg>
                        Download Excel
                    </button>

                    <!-- Button Download PDF -->
                    <a href="{{ route('download.laporan.barang.admin.pdf', Crypt::encryptString($barang->kode_barang ?? 0)) }}"
                        class="btn btn-outline-info btn-rounded mb-2 me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-download" viewBox="0 0 16 16">
                            <path
                                d="M.5 9.9V12.5a1.5 1.5 0 0 0 1.5 1.5h12a1.5 1.5 0 0 0 1.5-1.5V9.9a.5.5 0 0 1 1 0v2.6A2.5 2.5 0 0 1 14 15H2A2.5 2.5 0 0 1 .5 12.5V9.9a.5.5 0 0 1 1 0ZM7.646 10.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.293V1.5a.5.5 0 0 0-1 0v7.793L5.354 7.146a.5.5 0 1 0-.708.708l3 3Z" />
                        </svg> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and DataTables JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('laporan.barang.admin') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'jumlah_waste',
                        name: 'jumlah_waste'
                    },
                    {
                        data: 'jumlah_keluar',
                        name: 'jumlah_keluar'
                    },
                    {
                        data: 'jumlah_masuk',
                        name: 'jumlah_masuk'
                    },
                ],
            });
        });
    </script>
@endsection
