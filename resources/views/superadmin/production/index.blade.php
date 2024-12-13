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
                        Tambah Data
                    </a>
                </nav>
            </div>

            <!-- Modal Preview -->
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

            <!-- Date Filter -->
            <div class="row mt-3 mb-4">
                <div class="col-md-4">
                    <input type="text" id="filterTanggal" class="form-control" placeholder="Filter Tanggal" />
                </div>
            </div>

            <!-- DataTable -->
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="penjualan-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>SO Number</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Kode Barcode</th>
                                        <th>Oven Start</th>
                                        <th>Nama Operator</th>
                                        <th>Oven Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Press Start</th>
                                        <th>Nama Operator</th>
                                        <th>Press Finish</th>
                                        <th>Nama Operator</th>
                                        <th>WBS Start</th>
                                        <th>Nama Operator</th>
                                        <th>WBS Finish</th>
                                        <th>Nama Operator</th>
                                        <th>WELD Start</th>
                                        <th>Nama Operator</th>
                                        <th>WELD Finish</th>
                                        <th>Nama Operator</th>
                                        <th>VBS Start</th>
                                        <th>Nama Operator</th>
                                        <th>VBS Finish</th>
                                        <th>Nama Operator</th>
                                        <th>HBS Start</th>
                                        <th>Nama Operator</th>
                                        <th>HBS Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Poles Start</th>
                                        <th>Nama Operator</th>
                                        <th>Poles Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Assembly Start</th>
                                        <th>Nama Operator</th>
                                        <th>Assembly Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Finishing Start</th>
                                        <th>Nama Operator</th>
                                        <th>Finishing Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Finish Rework</th>
                                        <th>Nama Operator</th>
                                        <th>Progress</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#penjualan-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('production.admin.index') }}",
                    data: function(d) {
                        var dates = $('#filterTanggal').val().split(' - ');
                        if (dates.length === 2) {
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
                        data: 'so_number',
                        name: 'so_number'
                    },
                    {
                        data: 'size',
                        name: 'size',
                        defaultContent: '-'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        defaultContent: '-'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode',
                        defaultContent: '-'
                    },
                    {
                        data: 'oven_start',
                        name: 'oven_start'
                    },
                    {
                        data: 'oven_start_operator',
                        name: 'oven_start_operator'
                    },
                    {
                        data: 'oven_finish',
                        name: 'oven_finish'
                    },
                    {
                        data: 'oven_finish_operator',
                        name: 'oven_finish_operator'
                    },
                    {
                        data: 'press_start',
                        name: 'press_start'
                    },
                    {
                        data: 'press_start_operator',
                        name: 'press_start_operator'
                    },
                    {
                        data: 'press_finish',
                        name: 'press_finish'
                    },
                    {
                        data: 'press_finish_operator',
                        name: 'press_finish_operator',
                    },
                    {
                        data: 'wbs_start',
                        name: 'wbs_start'
                    },
                    {
                        data: 'wbs_start_operator',
                        name: 'wbs_start_operator',
                    },
                    {
                        data: 'wbs_finish',
                        name: 'wbs_finish'
                    },
                    {
                        data: 'wbs_finish_operator',
                        name: 'wbs_finish_operator',
                    },
                    {
                        data: 'weld_start',
                        name: 'weld_start'
                    },
                    {
                        data: 'weld_start_operator',
                        name: 'weld_start_operator',
                    },
                    {
                        data: 'weld_finish',
                        name: 'weld_finish'
                    },
                    {
                        data: 'weld_finish_operator',
                        name: 'weld_finish_operator',
                    },
                    {
                        data: 'vbs_start',
                        name: 'vbs_start'
                    },
                    {
                        data: 'vbs_start_operator',
                        name: 'vbs_start_operator'
                    },
                    {
                        data: 'vbs_finish',
                        name: 'vbs_finish'
                    },
                    {
                        data: 'vbs_finish_operator',
                        name: 'vbs_finish_operator'
                    },
                    {
                        data: 'hbs_start',
                        name: 'hbs_start'
                    },
                    {
                        data: 'hbs_start_operator',
                        name: 'hbs_start_operator',
                    },
                    {
                        data: 'hbs_finish',
                        name: 'hbs_finish'
                    },
                    {
                        data: 'hbs_finish_operator',
                        name: 'hbs_finish_operator',
                    },
                    {
                        data: 'poles_start',
                        name: 'poles_start',
                    },
                    {
                        data: 'poles_start_operator',
                        name: 'poles_start_operator',
                    },
                    {
                        data: 'poles_finish',
                        name: 'poles_finish'
                    },
                    {
                        data: 'poles_finish_operator',
                        name: 'poles_finish_operator',
                    },
                    {
                        data: 'assembly_start',
                        name: 'assembly_start',
                    },
                    {
                        data: 'assembly_start_operator',
                        name: 'assembly_start_operator',
                    },
                    {
                        data: 'assembly_finish',
                        name: 'assembly_finish',
                    },
                    {
                        data: 'assembly_finish_operator',
                        name: 'assembly_finish_operator',
                    },
                    {
                        data: 'finishing_start',
                        name: 'finishing_start',
                    },
                    {
                        data: 'finishing_start_operator',
                        name: 'finishing_start_operator',
                    },
                    {
                        data: 'finishing_finish',
                        name: 'finishing_finish',
                    },
                    {
                        data: 'finishing_finish_operator',
                        name: 'finishing_finish_operator',
                    },
                    {
                        data: 'finish_rework',
                        name: 'finish_rework'
                    },
                    {
                        data: 'finish_rework_operator',
                        name: 'finish_rework_operator'
                    },
                    {
                        data: 'progress',
                        name: 'progress'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Date Range Picker logic
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                },
                autoUpdateInput: false
            });

            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.ajax.reload();
            });

            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.ajax.reload();
            });
        });
    </script>



    <script>
        // Preview Modal Handler
        // $(document).on('click', '.btn-preview', function() {
        //     var so_number = $(this).data('id');
        //     $.ajax({
        //         url: '/production/admin/' + so_number + '/preview',
        //         method: 'GET',
        //         success: function(data) {
        //             $('#modalPreview .modal-body').html(`
    //                 <h5>Kode Invoice: ${data.penjualan.kode_invoice}</h5>
    //                 <p>Nama Kasir: ${data.penjualan.nama_kasir}</p>
    //                 <p>Tanggal: ${new Date(data.penjualan.created_at).toLocaleDateString()}</p>
    //                 <h6>Detail Penjualan:</h6>
    //                 <div class="table-responsive">
    //                     <table class="table table-bordered">
    //                         <thead>
    //                             <tr>
    //                                 <th>Kode Barang</th>
    //                                 <th>Nama Barang</th>
    //                                 <th>Qty</th>
    //                                 <th>Satuan</th>
    //                                 <th>Harga</th>
    //                                 <th>Sub Total</th>
    //                             </tr>
    //                         </thead>
    //                         <tbody>
    //                             ${data.details.map(detail => `
        //                                     <tr>
        //                                         <td>${detail.kode_barang}</td>
        //                                         <td>${detail.barang.nama_barang}</td>
        //                                         <td>${detail.qty}</td>
        //                                         <td>${detail.satuan}</td>
        //                                         <td>Rp ${formatRupiah(detail.harga)}</td>
        //                                         <td>Rp ${formatRupiah(detail.sub_total)}</td>
        //                                     </tr>
        //                                 `).join('')}
    //                         </tbody>
    //                     </table>
    //                 </div>
    //                 <h6>Total: Rp ${formatRupiah(data.penjualan.total)}</h6>
    //                 <h6>Jumlah Bayar: Rp ${formatRupiah(data.penjualan.jumlah_bayar)}</h6>
    //                 <h6>Jumlah Kembalian: Rp ${formatRupiah(data.penjualan.kembali)}</h6>
    //             `);
        //             $('#modalPreview').modal('show');
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Error:', error);
        //             alert('Terjadi kesalahan saat mengambil data.');
        //         }
        //     });
        // });

        // Format Rupiah Helper Function
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Delete Confirmation Handler
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
            });
        }

        // Delete Production Handler
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
                error: function(xhr, status, error) {
                    console.error('Error:', error);
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
