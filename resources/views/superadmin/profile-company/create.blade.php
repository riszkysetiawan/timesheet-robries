@extends('superadmin.partials.createuser')
@section('title', 'Tambah Company Profile')
@section('container')
    <div class="container">
        <!-- FLASH MESSAGE -->
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- BREADCRUMB -->
        {{-- <div class="page-meta">
            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Form</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Layouts</li>
                </ol>
            </nav>
        </div> --}}
        <!-- /BREADCRUMB -->

        <div class="row">
            <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Tambah Kategori Barang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <!-- Form Submission -->
                        <form id="simpan" enctype="multipart/form-data">
                            @csrf
                            <!-- Nama Kategori -->
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" class="form-control"
                                        placeholder="Nama Kategori *" required />
                                </div>
                            </div>

                            <!-- Deskripsi Kategori -->
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="keterangan" class="form-label">Deskripsi</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        placeholder="Deskripsi Kategori Barang *" />
                                </div>
                            </div>

                            <!-- Submit dan Kembali Buttons -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary">Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include jQuery if you haven't already -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Handle form submission via AJAX
            $('#simpan').on('submit', function(e) {
                e.preventDefault();

                // Prepare form data including file upload
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('kategori-barang.admin.store') }}", // Route to store
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#simpan')[0].reset();
                                    window.location.href =
                                        '/kategori-barang/admin';
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value + "\n";
                            });
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
