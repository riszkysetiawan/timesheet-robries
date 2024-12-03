@extends('superadmin.partials.pembelian')
@section('title', 'List Penjualan')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <a href="{{ route('production.admin.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Data </a>
                </nav>
            </div>
            <!-- /BREADCRUMB -->
            <!-- Modal untuk Preview -->
            <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">Preview Progress</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 mb-4">
                <div class="col-md-4">
                    <input type="text" id="filterTanggal" class="form-control" placeholder="Filter Tanggal" />
                </div>
            </div>
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="penjualan-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>So Number</th>
                                        <th>Tanggal</th>
                                        <th>Barcode</th>
                                        <th class="no-content text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan jQuery terlebih dahulu -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Import Moment.js (ketergantungan daterangepicker) -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- Import daterangepicker CSS dan JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = $('#penjualan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('production.admin.index') }}",
                    data: function(d) {
                        d.startDate = $('#filterTanggal').data('daterangepicker') ? $('#filterTanggal')
                            .data('daterangepicker').startDate.format('YYYY-MM-DD') : '';
                        d.endDate = $('#filterTanggal').data('daterangepicker') ? $('#filterTanggal')
                            .data('daterangepicker').endDate.format('YYYY-MM-DD') : '';
                    }
                },
                columns: [{
                        data: 'so_number',
                        name: 'so_number'
                    },
                    {
                        data: 'tgl_production',
                        name: 'tgl_production'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }]
            });

            // Initialize Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Filter'
                },
                autoUpdateInput: false
            });

            // Apply filter on date range selection
            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.ajax.reload();
            });

            // Clear filter when date range picker is cancelled
            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.ajax.reload();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#penjualan-table')) {
                $('#penjualan-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('production.admin.index') }}",
                    columns: [{
                            data: 'so_number',
                            name: 'so_number'
                        },
                        {
                            data: 'tgl_production',
                            name: 'tgl_production'
                        },
                        {
                            data: 'barcode',
                            name: 'barcode'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ],
                    columnDefs: [{
                        targets: 0,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }]
                });
            }
        });
    </script>

    <script>
        $(document).on('click', '.btn-preview', function() {
            var so_number = $(this).data('id');
            $.ajax({
                url: '/production/admin/' + so_number + '/preview',
                method: 'GET',
                success: function(data) {
                    $('#modalPreview .modal-body').html(`
                        <h5>Kode Invoice: ${data.penjualan.kode_invoice}</h5>
                        <p>Nama Kasir: ${data.penjualan.nama_kasir}</p>
                        <p>Tanggal: ${new Date(data.penjualan.created_at).toLocaleDateString()}</p>
                        <h6>Detail Penjualan:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.details.map(detail => `
                                                                                                                                                                                                                                                                                                                                                                                                                              <tr>
                                                                                                                                                                                                                                                                                                                                                                                         <td>${detail.kode_barang}</td>
                                                                                                                                                                                                                                                                                                                                                                                         <td>${detail.barang.nama_barang}</td>
                                                                                                                                                                                                                                                                                                                                                                                         <td>${detail.qty}</td>
                                                                                                                                                                                                                                                                                                                                                                                         <td>${detail.satuan}</td>
                                                                                                                                                                                                                                                                                                                                                                                         <td>Rp ${formatRupiah(detail.harga)}</td>
                                                                                                                                                                                                                                                                                                                                                                                         <td>Rp ${formatRupiah(detail.sub_total)}</td>
                                                                                                                                                                                                                                                                                                                                                                                         </tr>
                                                                                                                                                                                                                                                                                                                                                                                         `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <h6>Total: Rp ${formatRupiah(data.penjualan.total)}</h6>
                        <h6>Jumlah Bayar: Rp ${formatRupiah(data.penjualan.jumlah_bayar)}</h6>
                        <h6>Jumlah Kembalian: Rp ${formatRupiah(data.penjualan.kembali)}</h6>
                    `);
                    $('#modalPreview').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });
    </script>


    <script>
        function confirmDelete(kode_so) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteProduction(kode_so);
                }
            })
        }

        function deleteProduction(kode_so) {
            $.ajax({
                url: '/production/admin/delete/' + kode_so,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Dihapus!',
                            'Data production berhasil dihapus.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                $('#penjualan-table').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data penjualan.',
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data penjualan.',
                        'error'
                    );
                }
            });
        }
    </script>

@endsection
