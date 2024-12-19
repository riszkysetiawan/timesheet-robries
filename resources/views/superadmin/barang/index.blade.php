@extends('superadmin.partials.user')

@section('title', 'List Barang')

@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one">
                    <a href="{{ route('barang.admin.create') }}" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                        <i class="feather feather-plus"></i> Tambah Data
                    </a>
                </nav>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="zero-config" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Satuan</th>
                                        <th>Stock</th>
                                        <th>Waste</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Download Excel -->
                    <button class="btn btn-outline-success btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('barang.download.excel.admin') }}'">
                        <i class="feather feather-file-text"></i> Download Excel
                    </button>

                    <!-- Tombol Upload File -->
                    <button class="btn btn-outline-info btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('upload.barang.files.admin') }}'">
                        <i class="feather feather-upload-cloud"></i> Upload File
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // DataTable setup
            $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('barang.admin.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_barang',
                        name: 'kode_barang'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'kategori.nama_kategori',
                        name: 'kategori.nama_kategori'
                    },
                    {
                        data: 'satuan.satuan',
                        name: 'satuan.satuan'
                    },
                    {
                        data: 'stocks_sum_stock',
                        name: 'stocks_sum_stock'
                    },
                    {
                        data: 'wasteStocks_sum_waste',
                        name: 'wasteStocks_sum_waste'
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

        // Konfirmasi Delete
        function confirmDelete(kode_barang) {
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
                    deleteBarang(kode_barang);
                }
            });
        }

        // Request Delete Barang
        function deleteBarang(kode_barang) {
            $.ajax({
                url: '/delete/barang/admin/' + kode_barang,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'Barang berhasil dihapus.', 'success').then(() => {
                            $('#zero-config').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus Barang.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan server.', 'error');
                }
            });
        }
    </script>
@endsection
