@extends('superadmin.partials.user')
@section('title', 'List Reject')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <a href="{{ route('waste.admin.create') }}" class="btn btn-primary">Tambah Data</a>
                </nav>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="waste-table" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Reject</th>
                                        <th>Total Reject Keseluruhan</th>
                                        <th>Alasan</th>
                                        <th>Foto</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-outline-success btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('waste.download.excel.admin') }}'">
                        Download Excel</button>
                    <button class="btn btn-outline-secondary btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('upload.waste.files.admin') }}'">
                        Upload File</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal HTML -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Gambar Barang" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#waste-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('waste.admin.index') }}",
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
                        data: 'nama_barang',
                        name: 'barang.nama_barang'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'total_waste',
                        name: 'total_waste',
                        searchable: false
                    },
                    {
                        data: 'alasan',
                        name: 'alasan_waste.alasan'
                    },
                    {
                        data: 'foto',
                        name: 'foto',
                        orderable: false,
                        searchable: false
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
            })
        }

        function deleteUser(id) {
            $.ajax({
                url: '/delete/waste/admin/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Reject Barang berhasil dihapus.', 'success').then((result) => {
                            $('#waste-table').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Reject Barang.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Reject Barang.', 'error');
                }
            });
        }

        function showImageModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>
@endsection
