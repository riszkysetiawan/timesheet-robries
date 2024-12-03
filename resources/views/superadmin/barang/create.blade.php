@extends('superadmin.partials.createuser')
@section('title', 'Tambah Barang')
@section('container')
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <div class="container">
        <div class="container">
            <!-- FLASH MESSAGE -->
            <div id="flash-message"></div>

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
                                        <input type="text" id="kode_barang" name="kode_barang" class="form-control"
                                            value="{{ $newKodeBarang }}" readonly />
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
                                        <label for="foto" class="form-label">Gambar</label>
                                        <input type="file" id="gambar" name="gambar" class="form-control" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="no_hp" class="form-label">Kode Barcode</label>
                                        <input type="number" id="kode_barcode" name="kode_barcode" class="form-control"
                                            placeholder="Kode Barcode*" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="harga" class="form-label">Harga Jual</label>
                                        <input type="text" id="harga" name="harga" class="form-control"
                                            placeholder="Harga*" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="harga" class="form-label">Harga Beli</label>
                                        <input type="text" id="harga_beli" name="harga_beli" class="form-control"
                                            placeholder="Harga*" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="no_hp" class="form-label">Keterangan</label>
                                        <input type="text" id="keterangan" name="keterangan" class="form-control"
                                            placeholder="Keterangan*" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="no_hp" class="form-label">Tanggal Exp</label>
                                        <input type="date" id="exp" name="exp" class="form-control"
                                            placeholder="Exp*" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="no_hp" class="form-label">Take Out (Hari)</label>
                                        <input type="number" id="take_out" name="take_out" class="form-control"
                                            placeholder="Take Out *" />
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
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-check-circle">
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
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-left">
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
            $('#harga').on('input', function() {
                var value = $(this).val();
                $(this).val(formatRupiah(value, 'Rp '));
            });
            $('#harga_beli').on('input', function() {
                var value = $(this).val();
                $(this).val(formatRupiah(value, 'Rp '));
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            }

            // Handle form submission via AJAX
            $('#BarangForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var harga = $('#harga').val().replace(/[^0-9]/g,
                    ''); // Hapus format rupiah sebelum disubmit
                $('#harga').val(harga);

                var hargabeli = $('#harga_beli').val().replace(/[^0-9]/g,
                    ''); // Hapus format rupiah sebelum disubmit
                $('#harga_beli').val(hargabeli);
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
                                    window.location.href = '/barang/admin';
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
