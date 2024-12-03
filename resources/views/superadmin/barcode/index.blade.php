@extends('superadmin.partials.user')
@section('title', 'List Barcode')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            {{-- <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Datatables</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Striped</li>
                    </ol>
                    <a href="{{ route('barang.admin.create') }}" class="btn btn-primary">Tambah Data</a>
                </nav>
            </div> --}}
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
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Barcode</th>
                                        <th>Gambar Barcode</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    {{-- <button class="btn btn-outline-info btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('download-barcode.pdf.admin') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-download" viewBox="0 0 16 16">
                            <path
                                d="M.5 9.9V12.5A1.5 1.5 0 0 0 2 14h12a1.5 1.5 0 0 0 1.5-1.5V9.9a.5.5 0 0 1 1 0v2.6A2.5 2.5 0 0 1 14 15H2A2.5 2.5 0 0 1 .5 12.5V9.9a.5.5 0 0 1 1 0ZM7.646 10.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 9.293V1.5a.5.5 0 0 0-1 0v7.793L5.354 7.146a.5.5 0 1 0-.708.708l3 3Z" />
                        </svg>
                        Download PDF
                    </button> --}}
                    <button class="btn btn-outline-secondary btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('upload.barcode.files.admin') }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-upload" viewBox="0 0 16 16">
                            <path
                                d="M.5 9.9V12.5A1.5 1.5 0 0 0 2 14h12a1.5 1.5 0 0 0 1.5-1.5V9.9a.5.5 0 0 1 1 0v2.6A2.5 2.5 0 0 1 14 15H2A2.5 2.5 0 0 1 .5 12.5V9.9a.5.5 0 0 1 1 0ZM7.646 5.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 6.707V14.5a.5.5 0 0 1-1 0V6.707L5.354 8.854a.5.5 0 1 1-.708-.708l3-3Z" />
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
                ajax: "{{ route('barcode.admin.index') }}",
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
                        data: 'kode_barcode',
                        name: 'kode_barcode'
                    },
                    {
                        data: 'barcode_image',
                        name: 'barcode_image',
                        orderable: false,
                        searchable: false
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
                    deleteUser(kode_barang);
                }
            });
        }

        function printBarcode(printUrl) {
            $.ajax({
                url: printUrl, // URL yang mengembalikan konten barcode
                method: 'GET',
                success: function(response) {
                    // Membuka jendela untuk pencetakan
                    var printWindow = window.open('', '', 'width=800,height=600');
                    printWindow.document.write(response); // Isi konten HTML ke jendela baru
                    printWindow.document.close(); // Tutup dokumen untuk menyelesaikan loading

                    // Event listener untuk menutup jendela setelah pencetakan selesai
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };

                    // Proses mencetak
                    printWindow.print();

                    // Cadangan untuk menutup jika onafterprint gagal
                    setTimeout(function() {
                        if (!printWindow.closed) {
                            printWindow.close();
                        }
                    }, 3000); // Menunggu 3 detik
                },
                error: function(xhr, status, error) {
                    console.error('Error loading print page:', error);
                    alert('Terjadi kesalahan saat memuat halaman cetak.');
                }
            });
        }

        function deleteUser(kode_barang) {
            $.ajax({
                url: '/delete/barang/admin/' + kode_barang,
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
