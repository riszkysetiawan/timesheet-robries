@extends('superadmin.partials.user')
@section('title', 'User Activity Log')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <!-- Filter Tanggal -->
                        <div class="col-md-3 mb-4">
                            <label for="date-range-picker">Pilih Rentang Tanggal</label>
                            <input type="text" id="date-range-picker" class="form-control" />
                        </div>

                        <div class="table-responsive">
                            <table id="user-activity-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Model</th>
                                        <th>Details</th>
                                        <th>IP Address</th>
                                        <th>Timestamp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <button id="downloadExcel" class="btn btn-success mt-3 ">Download Excel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery dan Date Range Picker -->
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/moment.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <!-- Tambahkan event untuk tombol Download Excel -->
    <script>
        $(document).ready(function() {
            $('#downloadExcel').click(function() {
                var dateRange = $('#date-range-picker').val();
                var url = "{{ route('history.admin.download') }}"; // Pastikan route ini sudah terdaftar

                if (dateRange) {
                    var dates = dateRange.split(' - ');
                    var startDate = dates[0];
                    var endDate = dates[1];
                    url += `?startDate=${startDate}&endDate=${endDate}`;
                }

                window.location.href = url; // Redirect untuk memulai unduhan
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Inisialisasi Date Range Picker dengan default value (Select All)
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
            // Inisialisasi DataTable
            var table = $('#user-activity-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('history.admin.index') }}",
                    data: function(d) {
                        // Menambahkan filter tanggal ke parameter DataTables
                        var dateRange = $('#date-range-picker').val();
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
                        data: 'user',
                        name: 'user'
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'details',
                        name: 'details'
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address'
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

            // Menyaring data berdasarkan rentang tanggal
            $('#date-range-picker').on('apply.daterangepicker', function(ev, picker) {
                table.draw(); // Redraw tabel saat rentang tanggal dipilih
            });

            // Memastikan data ditampilkan meskipun tanpa memilih tanggal
            table.draw();
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Log ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteLog(id);
                }
            })
        }

        function deleteLog(id) {
            $.ajax({
                url: '/delete/history/admin/' + id, // Endpoint untuk delete
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Log berhasil dihapus.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus log.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus log.', 'error');
                }
            });
        }
    </script>
@endsection
