@extends('superadmin.partials.user')
@section('title', 'Company Profile')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="profile-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Toko</th>
                                        <th>Alamat</th>
                                        <th>Foto</th>
                                        <th>Email</th>
                                        <th>No Telp</th>
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

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Foto Profil Perusahaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Foto" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX DataTables Script -->
    <script>
        $(document).ready(function() {
            $('#profile-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('profil.company.admin.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'foto',
                        name: 'foto',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (data) {
                                return `<a href="javascript:void(0)" onclick="showPhoto('${data}')">
                                            <img src="${data}" alt="Foto" class="img-thumbnail" style="width: 50px; height: 50px;">
                                        </a>`;
                            } else {
                                return 'Tidak ada foto';
                            }
                        }
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function showPhoto(imageUrl) {
            $('#modalImage').attr('src', imageUrl); // Set URL foto di modal
            $('#photoModal').modal('show'); // Tampilkan modal
        }

        // Konfirmasi dan Hapus Data
        function confirmDelete(profileId) {
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
                    deleteUser(profileId);
                }
            });
        }

        function deleteUser(profileId) {
            $.ajax({
                url: '/delete/profil-company/admin/' + profileId,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Profil perusahaan berhasil dihapus.', 'success')
                            .then(() => $('#profile-table').DataTable().ajax.reload());
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Profil perusahaan.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Profil perusahaan.', 'error');
                }
            });
        }
    </script>
@endsection
