@extends('staff-produksi.partials.user')
@section('title', 'List Barang')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <a href="{{ route('produk.production-staff.create') }}"
                        class="btn btn-outline-primary btn-rounded mb-2 me-4">
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
            <!-- /BREADCRUMB -->

            <!-- FLASH MESSAGE -->
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Gambar</th>
                                        <th>Warna</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Tombol Download Excel -->
                    <button class="btn btn-outline-success btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('produk.download.excel.production-staff') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-text">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Download Excel
                    </button>


                    <!-- Tombol Upload File -->
                    <button class="btn btn-outline-info btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('upload.produk.files.production-staff') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-upload-cloud">
                            <polyline points="16 16 12 12 8 16"></polyline>
                            <line x1="12" y1="12" x2="12" y2="21"></line>
                            <path d="M20.39 16.39A5.5 5.5 0 0 0 18 9h-1.26A8 8 0 1 0 4 16.3"></path>
                            <polyline points="16 16 12 12 8 16"></polyline>
                        </svg>
                        Upload File
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('produk.production-staff.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_produk',
                        name: 'kode_produk'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'warna.warna',
                        name: 'warna.warna'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

        });

        function confirmDelete(kode_produk) {
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
                    deleteUser(kode_produk);
                }
            });
        }

        function deleteUser(kode_produk) {
            $.ajax({
                url: '/delete/produk/production-staff/' + kode_produk,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Barang berhasil dihapus.', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Barang.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Barang.', 'error');
                }
            });
        }
    </script>
@endsection
