@extends('superadmin.partials.pemasok')
@section('title', 'Laporan Pembelian')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <!-- Date Range Filter -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" id="filterTanggal" class="form-control" placeholder="Filter Tanggal" />
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode PO</th>
                                        <th>Supplier</th>
                                        <th>Tanggal PO</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Modal untuk Preview -->
                    <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog"
                        aria-labelledby="modalPreviewLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalPreviewLabel">Preview Purchase Order</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                    <button id="downloadExcel" class="btn btn-success">Download Excel</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Moment.js (Required by Daterangepicker) -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- Daterangepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Filter'
                },
                autoUpdateInput: false,
                showDropdowns: true
            });

            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.draw(); // Filter table dynamically
            });

            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw(); // Clear filter
            });

            // Download Excel
            $('#downloadExcel').on('click', function() {
                let dateRange = $('#filterTanggal').val();
                let url = "{{ route('download.excel.pembelian.admin') }}";

                if (dateRange) {
                    let dates = dateRange.split(" - ");
                    url += `?startDate=${dates[0]}&endDate=${dates[1]}`;
                }

                window.location.href = url; // Redirect to download route
            });
        });

        $(document).ready(function() {
            // Initialize Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Filter'
                },
                autoUpdateInput: false,
                showDropdowns: true
            });

            // Event for applying filter
            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.draw(); // Redraw table with new date range
            });

            // Event for clearing filter
            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw(); // Redraw table without filter
            });

            // Initialize DataTable
            let table = $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.pembelian.admin') }}",
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
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                        data: 'tgl_buat',
                        name: 'tgl_buat'
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
    </script>
    <script>
        $(document).on('click', '.btn-preview', function() {
            var poId = $(this).data('id');
            $.ajax({
                url: '/purchase-order/admin/' + poId + '/preview',
                method: 'GET',
                success: function(data) {
                    $('#modalPreview .modal-body').html(`
                        <h5>Kode PO: ${data.purchaseOrder.kode_po}</h5>
                        <p>Supplier: ${data.supplier.nama_supplier}</p>
                        <p>Status: ${data.purchaseOrder.status}</p>
                        <p>ETA: ${data.purchaseOrder.eta}</p>
                        <h6>Detail Purchase Order:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
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
                                                                                                                                                                <td>Rp. ${formatRupiah(detail.sub_total, 'Rp ')}</td>
                                                                                                                                                            </tr>
                                                                                                                                                        `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <h6>Total: ${formatRupiah(data.purchaseOrder.total, 'Rp ')}</h6>
                    `);
                    $('#modalPreview').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>
@endsection
