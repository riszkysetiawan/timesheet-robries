@extends('superadmin.partials.user')
@section('title', 'Laporan Inbond')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- FLASH MESSAGE -->
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Modal untuk Preview -->
            <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">Preview Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            <!-- Konten dari AJAX akan dimasukkan di sini -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <!-- Filter Tanggal -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="filterTanggal" class="form-control"
                                    placeholder="Filter Tanggal" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode PO</th>
                                        <th>Nama Supplier</th>
                                        <th>Diterima Tanggal</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <button id="downloadExcel" class="btn btn-primary mt-3">
                        Download Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Libraries -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            $('#downloadExcel').on('click', function() {
                let dateRange = $('#filterTanggal').val();
                let url = "{{ route('download.excel.inbond.admin') }}";

                if (dateRange) {
                    let dates = dateRange.split(" - ");
                    url += `?startDate=${dates[0]}&endDate=${dates[1]}`;
                }

                window.location.href = url;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Filter'
                },
                autoUpdateInput: false
            });

            // Apply date range filter
            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.draw(); // Reload the DataTable with the selected date range
            });

            // Clear date range filter
            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw(); // Reload the DataTable without any date range filter
            });

            // Initialize DataTable
            let table = $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.inbond.admin') }}",
                    data: function(d) {
                        let dateRange = $('#filterTanggal').val();
                        if (dateRange) {
                            let dates = dateRange.split(" - ");
                            d.startDate = dates[0];
                            d.endDate = dates[1];
                        }
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_po',
                        name: 'kode_po'
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name'
                    },
                    {
                        data: 'eta',
                        name: 'eta'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
            });
        });

        $(document).on('click', '.btn-preview', function() {
            var kodePo = $(this).data('id');
            $.ajax({
                url: '/inbond/admin/' + kodePo + '/preview',
                method: 'GET',
                success: function(data) {
                    if (data && data.inbound) {
                        $('#modalPreview .modal-body').html(`
                            <h5>Kode PO: ${data.inbound.kode_po}</h5>
                            <p>Nama Supplier: ${data.inbound.supplier ? data.inbound.supplier.nama_supplier : 'Tidak Ada Supplier'}</p>
                            <p>Diterima Tanggal: ${new Date(data.inbound.eta).toLocaleDateString()}</p>
                            <p>Catatan: ${data.inbound.catatan ? data.inbound.catatan : 'Tidak Ada Catatan'}</p>
                            <h6>Detail Inbound:</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Qty PO</th>
                                            <th>Qty Datang</th>
                                            <th>Qty Reject</th>
                                            <th>Final Qty</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.details.map(detail => `
                                                                                        <tr>
                                                                                            <td>${detail.kode_barang}</td>
                                                                                            <td>${detail.barang ? detail.barang.nama_barang : 'Tidak Ada Nama Barang'}</td>
                                                                                            <td>${detail.qty_po ?? 'Tidak Ada Qty PO'}</td>
                                                                                            <td>${detail.qty_actual ?? 'Tidak Ada Qty Datang'}</td>
                                                                                            <td>${detail.reject ?? 'Tidak Ada Qty Reject'}</td>
                                                                                            <td>${detail.final_qty ?? 'Tidak Ada Final Qty'}</td>
                                                                                            <td>${detail.satuan ?? 'Tidak Ada Satuan'}</td>
                                                                                        </tr>
                                                                                    `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        `);
                        $('#modalPreview').modal('show');
                    } else {
                        alert('Data tidak valid');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });
    </script>
@endsection
