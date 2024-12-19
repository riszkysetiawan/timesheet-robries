@extends('superadmin.partials.createuser')
@section('title', 'Tambah Size Produk')
@section('container')
    <div class="container">
        <div class="row">
            <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Tambah Size Barang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form id="simpan" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="size" class="form-label">Ukuran</label>
                                    <input type="text" name="size" class="form-control" placeholder="Ukuran *" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-check-circle">
                                    <path d="M9 11l3 3L22 4"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                Submit</button>
                            <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                onclick="window.location.href='{{ route('size-produk.admin.index') }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-arrow-left">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                                Kembali</button>
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


                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('size-produk.admin.store') }}",
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
                                        '{{ route('size-produk.admin.index') }}';
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
