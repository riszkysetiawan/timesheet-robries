@extends('staff-produksi.partials.createuser')
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
                                    <h4>Edit Barang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="BarangForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="kode_produk" class="form-label">Kode Barang</label>
                                        <input type="text" id="kode_produk" name="kode_produk" class="form-control"
                                            value="{{ old('kode_produk', $produk->kode_produk) }}" readonly />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="nama_barang" class="form-label">Nama Produk</label>
                                        <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                                            value="{{ old('nama_barang', $produk->nama_barang) }}"
                                            placeholder="Nama Barang *" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" id="gambar" name="gambar" class="form-control" />
                                        <small>Gambar saat ini: <img src="{{ asset('storage/' . $produk->gambar) }} "
                                                alt="Gambar" style="width: 100px;" /></small>
                                    </div>
                                </div>



                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_kategori" class="form-label">Ukuran</label>
                                        <select id="id_size" name="id_size" class="form-control">
                                            <option value="">Pilih Ukuran</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ $produk->id_size == $size->id ? 'selected' : '' }}>
                                                    {{ $size->size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Satuan -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_satuan" class="form-label">Warna</label>
                                        <select id="id_warna" name="id_warna" class="form-control">
                                            <option value="">Pilih Warna</option>
                                            @foreach ($warnas as $warna)
                                                <option value="{{ $warna->id }}"
                                                    {{ $produk->id_warna == $warna->id ? 'selected' : '' }}>
                                                    {{ $warna->warna }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Tombol Update -->
                                <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4"
                                    id="submitButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Update
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Format Rupiah untuk input harga
        $(document).ready(function() {
            $('#BarangForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submissio

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('produk.production-staff.update', Crypt::encryptString($produk->kode_produk)) }}",
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('produk.production-staff.index') }}';
                                }
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
