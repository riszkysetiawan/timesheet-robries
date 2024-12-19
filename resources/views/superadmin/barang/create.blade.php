@extends('superadmin.partials.createuser')
@section('title', 'Tambah Barang')
@section('container')

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
                                        <label for="kode_barang" class="form-label">Kode Barang</label>
                                        <input type="text" id="kode_barang" name="kode_barang" class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="nama" class="form-label">Nama Barang</label>
                                        <input type="text" id="nama" name="nama_barang" class="form-control"
                                            placeholder="Nama Barang *" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="role" class="form-label">Kategori</label>
                                        <select id="id_kategori" name="id_kategori" class="form-control">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"> {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4" id="typeRow" style="display: none;">
                                    <!-- Tambahkan style="display: none;" -->
                                    <div class="col-sm-12">
                                        <label for="type" class="form-label">Type</label>
                                        <select name="type" id="typeInput" class="form-control">
                                            <option value="">Pilih Type</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Special Color">Special Color</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="satuan" class="form-label">Satuan</label>
                                        <select id="id_satuan" name="id_satuan" class="form-control">
                                            <option value="">Pilih Satuan</option>
                                            @foreach ($satuans as $satuan)
                                                <option value="{{ $satuan->id }}"> {{ $satuan->satuan }}</option>
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
                                    onclick="window.location.href='{{ route('barang.admin.index') }}'">
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
                e.preventDefault(); // Prevent default form submission
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('barang.admin.store') }}",
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
                                        '{{ route('barang.admin.index') }}';
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
    <script>
        $(document).ready(function() {
            // Event listener ketika dropdown kategori diubah
            $('#id_kategori').on('change', function() {
                var selectedCategory = $("#id_kategori option:selected").text().trim();

                // Cek apakah kategori adalah "Raw Material"
                if (selectedCategory === "Raw Material") {
                    $('#typeRow').show(); // Tampilkan input Type
                } else {
                    $('#typeRow').hide(); // Sembunyikan input Type
                    $('#typeInput').val(''); // Hapus nilai input Type
                }
            });

            // Jika kategori sudah terpilih sebelumnya
            if ($("#id_kategori option:selected").text().trim() === "Raw Material") {
                $('#typeRow').show();
            }
        });
    </script>


@endsection
