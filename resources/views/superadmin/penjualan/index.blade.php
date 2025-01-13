@extends('superadmin.partials.indexpenjualan')
@section('title', 'List Barang')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <a href="{{ route('penjualan.admin.create') }}" class="btn btn-outline-primary btn-rounded mb-2 me-4">
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
            <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Informasi Penjualan</h6>
                            <p><strong>SO Number:</strong> <span id="modal-so-number"></span></p>
                            <p><strong>Nama Customer:</strong> <span id="modal-nama-customer"></span></p>
                            <p><strong>Shipping:</strong> <span id="modal-shipping"></span></p>
                            <h6>Detail Pesanan</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pesanan</th>
                                        <th>Qty</th>
                                        <th>Deskripsi</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-detail-body">
                                    <!-- Detail rows will be appended here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /BREADCRUMB -->
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SO Number</th>
                                        <th>Nama Customer</th>
                                        <th>Shipping</th>
                                        <th>Catatan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- Tombol Download Excel -->

                    <!-- Tombol Upload File -->
                    {{-- <button class="btn btn-outline-info btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('upload.produk.files.admin') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-upload-cloud">
                            <polyline points="16 16 12 12 8 16"></polyline>
                            <line x1="12" y1="12" x2="12" y2="21"></line>
                            <path d="M20.39 16.39A5.5 5.5 0 0 0 18 9h-1.26A8 8 0 1 0 4 16.3"></path>
                            <polyline points="16 16 12 12 8 16"></polyline>
                        </svg>
                        Upload File
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap CSS -->

    <script>
        $(document).ready(function() {
            $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('penjualan.admin.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'so_number',
                        name: 'so_number'
                    },
                    {
                        data: 'nama_customer',
                        name: 'nama_customer',
                    },
                    {
                        data: 'shipping',
                        name: 'shipping',
                    },
                    {
                        data: 'catatan',
                        name: 'catatan',
                        defaulContent: '-'
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

        function deleteUser(id) {
            $.ajax({
                url: '/delete/penjualan/admin/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', 'penjualan berhasil dihapus.', 'success').then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus penjualan.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus penjualan.', 'error');
                }
            });
        }
    </script>
    <script>
        // Handle Detail button click
        $(document).on('click', '.btn-detail', function() {
            let id = $(this).data('id');

            // Fetch detail data
            $.ajax({
                url: '/penjualan/detail/' + id,
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        let data = response.data;
                        let details = response.details;

                        // Populate modal fields
                        $('#modal-so-number').text(data.so_number);
                        $('#modal-nama-customer').text(data.nama_customer);
                        $('#modal-shipping').text(data.shipping);

                        // Populate detail table
                        let detailBody = '';
                        details.forEach(detail => {
                            detailBody += `
                            <tr>
                                <td>${detail.pesanan}</td>
                                <td>${detail.qty}</td>
                                <td>${detail.deskripsi}</td>
                                <td>${detail.note ?? ''}</td>
                            </tr>`;
                        });
                        $('#modal-detail-body').html(detailBody);

                        // Show modal
                        $('#detailModal').modal('show');
                    } else {
                        Swal.fire('Error', 'Gagal mengambil data detail.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan saat mengambil data.', 'error');
                }
            });
        });
    </script>
@endsection
