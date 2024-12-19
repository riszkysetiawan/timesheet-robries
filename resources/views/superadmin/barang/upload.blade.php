@extends('superadmin.partials.upload')
@section('title', 'Upload Barang')
@section('container')
    <div class="container">

        <div class="row layout-top-spacing">
            <div id="fuMultipleFile" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Upload File</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">

                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form id="upload-excel-form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="file-upload-container">
                                        <input type="file" name="file" class="" />
                                        <div id="upload-status" class="upload-status d-none">
                                            <div class="loader"></div>
                                            <span>Uploading...</span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-info btn-rounded mb-2 me-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                            <polyline points="17 8 12 3 7 8" />
                                            <line x1="12" y1="3" x2="12" y2="15" />
                                        </svg>
                                        Upload
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Tombol Download Template -->
                        <button type="button" class="btn btn-outline-primary btn-rounded mb-2 me-4"
                            onclick="window.location.href='{{ route('download.template.upload.barang.admin') }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download Template
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AJAX untuk upload file -->
    <script>
        $(document).ready(function() {
            const inputElement = document.querySelector('input[name="file"]');
            const pond = FilePond.create(inputElement);
            $('#upload-excel-form').on('submit', function(e) {
                e.preventDefault();
                $('#upload-status').removeClass('d-none');

                // Get the file from FilePond
                const file = pond.getFile();
                if (!file) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Silakan pilih file terlebih dahulu.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                var formData = new FormData();
                formData.append('file', file.file);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('upload.barang.admin') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#upload-status').addClass('d-none');
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        pond.removeFile();
                    },
                    error: function(xhr) {
                        $('#upload-status').addClass('d-none');
                        var errorMessage = '';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;

                            if (xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorMessage += '<br>' + value;
                                });
                            }
                        } else {
                            errorMessage = 'Terjadi kesalahan yang tidak diketahui!';
                        }

                        Swal.fire({
                            title: 'Gagal!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
