@extends('superadmin.partials.pemasok')
@section('title', 'Perhitungan ROP')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <a href="{{ route('tambah-rop.admin') }}" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Data
                    </a>
                </nav>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="rop-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga Barang</th>
                                        <th>Maximum Usage</th>
                                        <th>Average Usage</th>
                                        <th>Lead Time</th>
                                        <th>SS</th>
                                        <th>ROP</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-outline-info btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('export.reorder.point.admin') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Download Reorder Point
                    </button>
                    <button class="btn btn-outline-secondary btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('export.reorder.point.pdf.admin') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- AJAX DataTables Script -->
    <script>
        $(document).ready(function() {
            $('#rop-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('rop.admin') }}",
                columns: [{
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'maximum_usage',
                        name: 'maximum_usage'
                    },
                    {
                        data: 'average_usage',
                        name: 'average_usage'
                    },
                    {
                        data: 'lead_time',
                        name: 'lead_time'
                    },
                    {
                        data: 'safety_stock',
                        name: 'safety_stock'
                    },
                    {
                        data: 'reorder_point',
                        name: 'reorder_point'
                    }
                ]
            });
        });
    </script>
@endsection
