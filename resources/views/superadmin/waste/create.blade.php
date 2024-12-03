@extends('superadmin.partials.createuser')
@section('title', 'Tambah Waste Superadmin')
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
                                <h4>Tambah Waste Barang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <!-- Form Submission -->
                        <form id="simpan" enctype="multipart/form-data">
                            @csrf
                            <div id="item-list">
                                <div class="item-entry">
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="barcode" class="form-label">Barcode Barang</label>
                                            <input type="text" class="form-control barcode-input" name="barcode[]"
                                                id="barcode">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="role" class="form-label">Nama Barang</label>
                                            <select name="kode_barang[]" class="form-control kode_barang">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->kode_barang }}"> 
                                                        {{ $barang->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="role" class="form-label">Pilih Alasan</label>
                                            <select name="id_alasan[]" class="form-control">
                                                <option value="">Pilih Alasan</option>
                                                @foreach ($alasans as $alasan)
                                                    <option value="{{ $alasan->id }}"> {{ $alasan->alasan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="stock" class="form-label">Jumlah Reject</label>
                                            <input type="text" name="waste[]" class="form-control" placeholder="Waste *"
                                                min="1">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="foto" class="form-label">Bukti Foto</label>
                                            <input type="file" name="foto[]" class="form-control"
                                                placeholder="Bukti Foto *">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger remove-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-check-circle">
                                            <path d="M9 11l3 3L22 4"></path>
                                            <circle cx="12" cy="12" r="10"></circle>
                                        </svg>
                                        Hapus</button>
                                </div>
                            </div>

                            <!-- Button to add another item -->
                            <button type="button" id="add-item" class="btn btn-outline-success btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tambah Barang</button>
                            <button type="submit" id="add-item" class="btn btn-outline-secondary btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-check-circle">
                                    <path d="M9 11l3 3L22 4"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                Simpan</button>
                            <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                onclick="window.location.href='{{ route('waste-barang.admin.index') }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
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

    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada elemen dengan class .kode_barang
            function initSelect2() {
                $('.kode_barang').select2({
                    placeholder: "Pilih Barang",
                    allowClear: true
                });
            }

            initSelect2(); // Panggil untuk elemen yang sudah ada saat halaman dimuat

            // Add new item entry on "Tambah Barang" button click
            $('#add-item').on('click', function() {
                var newItem = $('.item-entry:first').clone(); // Clone the first item entry
                newItem.find('input').val(''); // Clear input values
                newItem.find('select').val('').trigger('change'); // Reset select2 value
                newItem.find('select').removeClass('select2-hidden-accessible'); // Remove old select2 class
                newItem.find('.select2').remove(); // Remove select2 UI element
                $('#item-list').append(newItem); // Append the cloned entry to the form
                initSelect2(); // Re-initialize select2 on new element
            });

            // Remove item entry on "Hapus" button click
            $(document).on('click', '.remove-item', function() {
                if ($('.item-entry').length > 1) {
                    $(this).closest('.item-entry').remove(); // Remove the specific entry
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Anda harus memiliki setidaknya satu entri barang.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Handle form submission via AJAX
            $('#simpan').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('waste-barang.admin.store') }}",
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
                                        '{{ route('waste-barang.admin.index') }}';
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = xhr.responseJSON.message ||
                                'Terjadi kesalahan validasi';
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (xhr.status === 400) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Request tidak valid.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });

            // Fungsi untuk menangani input barcode dinamis
            $(document).on('input', '.barcode-input', function() {
                var barcode = $(this).val();
                var parent = $(this).closest('.item-entry');

                if (barcode.length > 0) {
                    $.ajax({
                        url: "/get-barang-by-barcode/waste/admin/" +
                            barcode, // Route untuk mengambil barang
                        method: "GET",
                        success: function(response) {
                            if (response) {
                                // Update select field dengan data barang yang sesuai
                                parent.find('.kode_barang').val(response.kode_barang).trigger(
                                    'change');
                            } else {
                                parent.find('.kode_barang').val('').trigger('change');
                            }
                        },
                        error: function() {
                            console.error("Error fetching barang by barcode");
                        }
                    });
                }
            });
        });
    </script>
@endsection
