@extends('superadmin.partials.user')
@section('title', 'User Activity Log')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="user-activity-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Model</th>
                                        <th>Details</th>
                                        <th>IP Address</th>
                                        <th>Timestamp</th>
                                        <th>Options</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-activity-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('history.admin.index') }}", // Endpoint untuk DataTables
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
                        data: 'action',
                        name: 'action'
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
                        data: 'actionn',
                        name: 'actionn',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
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
                url: '/delete/history/admin/' + id, // Endpoint delete
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
