@extends('superadmin.partials.pembelian')
@section('title', 'List Inbond')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb"></nav>
            </div>

            <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">Preview Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Filter Input -->
            <div class="row mt-3 mb-4">
                <div class="col-md-4">
                    <input type="text" id="filterTanggal" class="form-control" placeholder="Filter Tanggal" />
                </div>
            </div>

            <!-- Data Table -->
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode PO</th>
                                        <th>Nama Supplier</th>
                                        <th>Estimasi Kedatangan</th>
                                        <th>Catatan</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Memuat Library dengan Urutan yang Benar -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            let table = $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('inbond.admin.index') }}",
                    data: function(d) {
                        d.startDate = $('#filterTanggal').data('daterangepicker') ? $('#filterTanggal')
                            .data('daterangepicker').startDate.format('YYYY-MM-DD') : '';
                        d.endDate = $('#filterTanggal').data('daterangepicker') ? $('#filterTanggal')
                            .data('daterangepicker').endDate.format('YYYY-MM-DD') : '';
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
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ] // Mengurutkan berdasarkan kolom 'kode_po'
            });

            // Inisialisasi Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Filter'
                },
                autoUpdateInput: false
            });

            // Filter DataTable saat tanggal dipilih
            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.ajax.reload();
            });

            // Hapus filter saat Date Range Picker dibatalkan
            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.ajax.reload();
            });
        });

        // Preview Modal
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
                            <p>Estimasi Kedatangan: ${new Date(data.inbound.eta).toLocaleDateString()}</p>
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
                                                                                                                <td>${detail.qty_po !== undefined ? detail.qty_po : 'Tidak Ada Qty PO'}</td>
                                                                                                                <td>${detail.qty_actual !== undefined ? detail.qty_actual : 'Tidak Ada Qty Datang'}</td>
                                                                                                                <td>${detail.reject !== undefined ? detail.reject : 'Tidak Ada Qty Reject'}</td>
                                                                                                                <td>${detail.final_qty !== undefined ? detail.final_qty : 'Tidak Ada Final Qty'}</td>
                                                                                                                <td>${detail.satuan ? detail.satuan : 'Tidak Ada Satuan'}</td>
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

        // Konfirmasi Hapus
        function confirmDelete(kode_po) {
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
                    deleteUser(kode_po);
                }
            });
        }

        // Hapus Data
        function deleteUser(kode_po) {
            $.ajax({
                url: '/delete/inbound/admin/' + kode_po,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Data Berhasil Dihapus.', 'success').then(() => location
                            .reload());
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Data.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Data.', 'error');
                }
            });
        }
    </script>
@endsection
