@extends('superadmin.partials.user')
@section('title', 'Stock Movement')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">

                        <!-- Date Range Picker -->
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" id="date-range-picker" class="form-control" placeholder="Pilih Tanggal">
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive mt-3">
                            <table id="stock-movement-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Jenis Pergerakan</th>
                                        <th>Kuantitas</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <button id="downloadExcel" class="btn btn-success">Download Excel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include required libraries -->
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/moment.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script>
        $(document).ready(function() {
            // Initialize Date Range Picker
            $('#date-range-picker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                },
                autoUpdateInput: false
            });

            // Event: Tanggal dipilih
            $('#date-range-picker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.draw(); // Memuat ulang data tabel dengan parameter baru
            });

            // Event: Clear tanggal
            $('#date-range-picker').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw(); // Memuat ulang tabel tanpa filter tanggal
            });

            // Set up DataTables
            var table = $('#stock-movement-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('movement.admin.index') }}", // Endpoint untuk DataTables
                    data: function(d) {
                        // Menambahkan parameter tanggal ke dalam request
                        var dateRange = $('#date-range').val();
                        if (dateRange) {
                            var dates = dateRange.split(' - ');
                            d.start_date = dates[0];
                            d.end_date = dates[1];
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
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'movement_type',
                        name: 'movement_type'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            // Update DataTable when date range is selected
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                // Trigger redraw of the table with the selected date range
                table.draw();
            });

            // Delete confirmation function
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Pergerakan stok ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteMovement(id);
                    }
                });
            }

            function deleteMovement(id) {
                $.ajax({
                    url: '/delete/stock/movement/' + id, // Endpoint delete
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Dihapus!', 'Pergerakan stok berhasil dihapus.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus pergerakan stok.',
                                'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus pergerakan stok.',
                            'error');
                    }
                });
            }
        });
    </script>
@endsection
