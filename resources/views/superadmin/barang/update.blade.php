@extends('superadmin.partials.createuser')
@section('title', 'Update Barang')
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
                                    <h4>Update Barang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="BarangForm" enctype="multipart/form-data">
                                @csrf
                                <!-- Kode Barang -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="kode_barang" class="form-label">Kode Barang</label>
                                        <input type="text" id="kode_barang" name="kode_barang" class="form-control"
                                            value="{{ old('kode_barang', $barang->kode_barang) }}" readonly />
                                    </div>
                                </div>

                                <!-- Nama Barang -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="nama_barang" class="form-label">Nama Barang</label>
                                        <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                                            value="{{ old('nama_barang', $barang->nama_barang) }}"
                                            placeholder="Nama Barang *" />
                                    </div>
                                </div>

                                <!-- Kategori -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_kategori" class="form-label">Kategori</label>
                                        <select id="id_kategori" name="id_kategori" class="form-control">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}"
                                                    {{ old('id_kategori', $barang->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Type: Conditional Row -->
                                <div class="row mb-4" id="typeRow" style="display: none;">
                                    <div class="col-sm-12">
                                        <label for="type" class="form-label">Type</label>
                                        <select name="type" id="typeInput" class="form-control">
                                            <option value="">Pilih Type</option>
                                            <option value="Standard"
                                                {{ old('type', $barang->type) == 'Standard' ? 'selected' : '' }}>Standard
                                            </option>
                                            <option value="Special Color"
                                                {{ old('type', $barang->type) == 'Special Color' ? 'selected' : '' }}>
                                                Special Color</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Satuan -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_satuan" class="form-label">Satuan</label>
                                        <select id="id_satuan" name="id_satuan" class="form-control">
                                            <option value="">Pilih Satuan</option>
                                            @foreach ($satuans as $satuan)
                                                <option value="{{ $satuan->id }}"
                                                    {{ old('id_satuan', $barang->id_satuan) == $satuan->id ? 'selected' : '' }}>
                                                    {{ $satuan->satuan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Tombol Update -->
                                <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4"
                                    id="submitButton">
                                    <i class="feather feather-save"></i> Update
                                </button>

                                <!-- Tombol Kembali -->
                                <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                    onclick="window.location.href='{{ route('barang.admin.index') }}'">
                                    <i class="feather feather-arrow-left"></i> Kembali
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Event listener untuk dropdown kategori
            $('#id_kategori').on('change', function() {
                var selectedCategory = $("#id_kategori option:selected").text().trim();

                if (selectedCategory === "Raw Material") {
                    $('#typeRow').show(); // Tampilkan input Type
                } else {
                    $('#typeRow').hide();
                    $('#typeInput').val('');
                }
            });

            // Tampilkan Type jika kategori yang sudah terpilih adalah Raw Material
            var currentCategory = $("#id_kategori option:selected").text().trim();
            if (currentCategory === "Raw Material") {
                $('#typeRow').show();
            }

            // Handle form submit
            $('#BarangForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('barang.admin.update', Crypt::encryptString($barang->kode_barang)) }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                window.location.href =
                                    "{{ route('barang.admin.index') }}";
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value + '\n';
                            });
                            Swal.fire('Error!', errorMessage, 'error');
                        }
                    }
                });
            });
        });
    </script>
@endsection
