@extends('superadmin.partials.createuser')
@section('container')
    <div class="container">
        <!-- FLASH MESSAGE -->
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="row">
            <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Tambah Stock Barang</h4>
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
                                            <input type="text" class="form-control" name="barcode[]" id="barcode">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="kode_produk" class="form-label">Nama Barang</label>
                                            <select name="kode_produk[]" class="form-control kode_produk">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($produks as $produk)
                                                    <option value="{{ $produk->kode_produk }}"> {{ $produk->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="stock" class="form-label">Jumlah Stock</label>
                                            <input type="text" name="stock[]" class="form-control"
                                                placeholder="Jumlah Stock *" />
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                </div>
                            </div>

                            <!-- Button to add another item -->
                            <button type="button" id="add-item" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tambah Barang</button>
                            <button type="submit" class="btn btn-outline-secondary btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-check-circle">
                                    <path d="M9 11l3 3L22 4"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                Simpan</button>
                            <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                onclick="window.location.href='{{ route('stock-produk.admin.index') }}'">
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

    <!-- Include jQuery before Select2 -->
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

            // Handle form submission via AJAX
            $('#simpan').on('submit', function(e) {
                e.preventDefault();

                // Ambil data form
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('stock-produk.admin.store') }}",
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
                                        '{{ route('stock-produk.admin.index') }}';
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

            // Fungsi untuk menambahkan item baru
            $('#add-item').on('click', function() {
                var newItem = $('.item-entry:first').clone(); // Clone item pertama
                newItem.find('input').val(''); // Kosongkan nilai input
                newItem.find('select').val('').trigger('change'); // Reset value select
                newItem.find('select').removeClass('select2-hidden-accessible'); // Hapus select2 class
                newItem.find('.select2').remove(); // Hapus elemen select2 lama
                $('#item-list').append(newItem); // Tambahkan item ke form
                initSelect2(); // Inisialisasi ulang Select2
            });

            // Hapus item
            $(document).on('click', '.remove-item', function() {
                if ($('.item-entry').length > 1) {
                    $(this).closest('.item-entry').remove();
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Anda harus memiliki setidaknya satu entri barang.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            // Fungsi untuk menangani input barcode dinamis
            $(document).on('input', 'input[name="barcode[]"]', function() {
                var barcode = $(this).val();
                var parent = $(this).closest('.item-entry');

                if (barcode.length > 0) {
                    $.ajax({
                        url: "/get-produk-by-barcode/stock/" +
                            barcode, // Route untuk mengambil barang
                        method: "GET",
                        success: function(response) {
                            if (response) {
                                parent.find('select[name="kode_produk[]"]').val(response
                                    .kode_produk).trigger('change'); // Update value select
                            } else {
                                parent.find('select[name="kode_produk[]"]').val('').trigger(
                                    'change');
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
