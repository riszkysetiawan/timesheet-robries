@extends('superadmin.partials.createuser')
@section('title', 'Tambah Waste Superadmin')
@section('container')
    <div class="container">
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
                                            <label for="role" class="form-label">Nama Barang</label>
                                            <select name="kode_barang[]" class="form-control kode_barang"
                                                style="width: 100%">
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
                                onclick="window.location.href='{{ route('waste.admin.index') }}'">
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
            // Fungsi untuk inisialisasi Select2 pada elemen dropdown
            function initSelect2() {
                $('.kode_barang').not('.select2-hidden-accessible').select2({
                    placeholder: "Pilih Barang",
                    allowClear: true,
                    width: '100%' // Lebar mengikuti container
                });
            }

            // Inisialisasi Select2 pada elemen yang sudah ada saat halaman dimuat
            initSelect2();

            // Tambahkan event untuk tombol "Tambah Barang"
            $('#add-item').on('click', function() {
                // Clone elemen pertama
                var newItem = $('.item-entry:first').clone();

                // Reset nilai input dan select di elemen yang di-clone
                newItem.find('input').val('');
                newItem.find('select').val('').trigger('change'); // Reset nilai select

                // Hapus Select2 instance lama
                newItem.find('.select2').remove();
                newItem.find('select').removeClass('select2-hidden-accessible');

                // Tambahkan elemen yang di-clone ke dalam form
                $('#item-list').append(newItem);

                // Re-inisialisasi Select2 untuk elemen baru
                initSelect2();
            });

            // Event untuk menghapus elemen
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
        });


        $(document).ready(function() {

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
                    url: "{{ route('waste.admin.store') }}",
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
                                        '{{ route('waste.admin.index') }}';
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
        });
    </script>
@endsection
