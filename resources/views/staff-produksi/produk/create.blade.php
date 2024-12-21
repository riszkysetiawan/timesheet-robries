@extends('staff-produksi.partials.createuser')
@section('title', 'Tambah Produk')
<div class="container">
    <div class="container">
        <!-- FLASH MESSAGE -->
        <div id="flash-message"></div>

        <div class="row">
            <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Tambah Barang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form id="BarangForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="kode_produk" class="form-label">Kode Produk</label>
                                    <input type="text" id="kode_produk" name="kode_produk" class="form-control" />
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="nama_barang" class="form-label">Nama Produk</label>
                                    <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                                        placeholder="Nama Barang *" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input type="file" id="gambar" name="gambar" class="form-control" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="id_kategori" class="form-label">Ukuran</label>
                                    <select id="id_size" name="id_size" class="form-control">
                                        <option value="">Pilih Ukuran</option>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}"> {{ $size->size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="id_warna" class="form-label">Warna</label>
                                    <select id="id_warna" name="id_warna" class="form-control">
                                        <option value="">Pilih Satuan</option>
                                        @foreach ($warnas as $warna)
                                            <option value="{{ $warna->id }}"> {{ $warna->warna }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Tombol Submit -->
                            <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4"
                                id="submitButton">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                                    <path d="M9 11l3 3L22 4"></path>
                                    <circle cx="12" cy="12" r="10"></circle>
                                </svg>
                                Simpan
                            </button>
                            <!-- Tombol Kembali -->
                            <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                onclick="window.location.href='{{ route('produk.production-staff.index') }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                                Kembali
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery if you haven't already -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Format Rupiah untuk input harga -->
<script>
    $(document).ready(function() {
        // Handle form submission via AJAX
        $('#BarangForm').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('produk.production-staff.store') }}",
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
                                $('#BarangForm')[0].reset();
                                window.location.href =
                                    '{{ route('produk.production-staff.index') }}';
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Validasi error
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        // Kumpulkan semua pesan error
                        $.each(errors, function(key, value) {
                            errorMessage += value +
                                '<br>'; // Gabungkan semua pesan error
                        });

                        // Tampilkan pesan error menggunakan SweetAlert
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage, // Menggunakan HTML agar pesan error tampil dengan baik
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                        // Reset error sebelumnya
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();

                        // Tampilkan error di form
                        $.each(errors, function(key, value) {
                            // Menambahkan kelas 'is-invalid' pada input yang salah
                            $('#' + key).addClass('is-invalid');

                            // Menambahkan pesan error di bawah input
                            $('#' + key).after('<div class="invalid-feedback">' +
                                value + '</div>');
                        });
                    } else {
                        // Error lainnya
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan, silakan coba lagi.',
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
