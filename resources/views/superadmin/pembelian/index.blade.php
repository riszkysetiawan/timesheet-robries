@extends('superadmin.partials.pembelian')
@section('title', 'List Pembelian')
@section('container')
    <div class="container">
        <!-- BREADCRUMB -->
        <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <a href="{{ route('pembelian.admin.create') }}" class="btn btn-primary">Tambah Data</a>
            </nav>
        </div>

        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area justify-pill">
                    <!-- Tab Links -->
                    <ul class="nav nav-pills mb-3 mt-3 nav-fill" id="justify-pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-pending" data-status="Belum Diterima" data-bs-toggle="pill"
                                href="#pending" role="tab">Belum Diterima</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-received" data-status="Diterima" data-bs-toggle="pill"
                                href="#received" role="tab">Diterima</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-reject" data-status="Reject" data-bs-toggle="pill" href="#reject"
                                role="tab">Reject</a>
                        </li>
                    </ul>

                    <!-- Date Range Filter -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="filterTanggal" class="form-control" placeholder="Filter Tanggal" />
                        </div>
                    </div>

                    <div class="tab-content" id="tabContent">
                        <!-- Tabel Pembelian untuk setiap status -->
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="tab-pending">
                            <div class="table-responsive">
                                <table id="pending-table" class="table table-striped dt-table-hover" style="width:100%">
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
                        <div class="tab-pane fade" id="received" role="tabpanel" aria-labelledby="tab-received">
                            <div class="table-responsive">
                                <table id="received-table" class="table table-striped dt-table-hover" style="width:100%">
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
                        <div class="tab-pane fade" id="reject" role="tabpanel" aria-labelledby="tab-reject">
                            <div class="table-responsive">
                                <table id="reject-table" class="table table-striped dt-table-hover" style="width:100%">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Preview -->
    <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPreviewLabel">Preview Purchase Order</h5>
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

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
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
                autoUpdateInput: false
            });

            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                reloadAllTables();
            });

            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                reloadAllTables();
            });

            // Load DataTables for each tab
            loadDataTable('pending', 'Belum Diterima');
            loadDataTable('received', 'Diterima');
            loadDataTable('reject', 'Reject');
        });

        // Function to load DataTable with date filter
        function loadDataTable(tab, status) {
            $('#' + tab + '-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true, // Allow reinitialization
                ajax: {
                    url: "{{ route('pembelian.admin.index') }}",
                    data: function(d) {
                        d.status = status;
                        d.startDate = $('#filterTanggal').data('daterangepicker') ? $('#filterTanggal').data(
                            'daterangepicker').startDate.format('YYYY-MM-DD') : '';
                        d.endDate = $('#filterTanggal').data('daterangepicker') ? $('#filterTanggal').data(
                            'daterangepicker').endDate.format('YYYY-MM-DD') : '';
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
                        data: 'supplier.nama_supplier',
                        name: 'supplier.nama_supplier'
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
                        searchable: false
                    }
                ]
            });
        }

        // Function to reload all tables
        function reloadAllTables() {
            $('#pending-table').DataTable().ajax.reload();
            $('#received-table').DataTable().ajax.reload();
            $('#reject-table').DataTable().ajax.reload();
        }

        // Fungsi untuk konfirmasi hapus
        function confirmDelete(id) {
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
                    deleteUser(id);
                }
            });
        }

        // Fungsi untuk menghapus data
        function deleteUser(id) {
            $.ajax({
                url: '/delete/pembelian/admin/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Pembelian berhasil dihapus.', 'success')
                            .then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Pembelian.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Pembelian.', 'error');
                }
            });
        }

        // Fungsi untuk menampilkan modal Preview
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
                                                                        <td>Rp. ${formatRupiah(detail.sub_total)}</td>
                                                                    </tr>`).join('')}
                                </tbody>
                            </table>
                        </div>
                        <h6>Total: ${formatRupiah(data.purchaseOrder.total, 'Rp ')}</h6>
                    `);
                    $('#modalPreview').modal('show');
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });

        // Fungsi untuk format mata uang Rupiah
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

            return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
        }
    </script>
@endsection
