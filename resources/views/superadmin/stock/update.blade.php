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
                                <h4>Edit Stock Barang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <!-- Form Submission -->
                        <form id="updateData" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="kode_barang" class="form-label">Nama Barang</label>
                                    <select id="kode_barang" class="form-control" disabled>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->kode_barang }}"
                                                {{ old('kode_barang', $stock->kode_barang) == $barang->kode_barang ? 'selected' : '' }}>
                                                {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="stock" class="form-label">Jumlah Stock</label>

                                    <!-- Stock Section -->
                                    <div id="stock-container">
                                        <div class="input-group mb-2">
                                            <input type="number" name="stock[]" class="form-control"
                                                value="{{ old('stock.0', isset($stock->stock) ? $stock->stock : 0) }}"
                                                placeholder="Stock" min="1" required />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-save">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                Update</button>
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

    <!-- Include jQuery if you haven't already -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#updateData').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('stock-produk.admin.update', Crypt::encryptString($stock->id)) }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', response.message, 'success')
                            .then(() => {
                                $('#updateData')[0].reset();
                                window.location.href =
                                    '{{ route('stock-produk.admin.index') }}';
                            });
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire('Error!', xhr.responseJSON.message, 'error');
                    } else {
                        Swal.fire('Error!', 'Something went wrong, please try again!', 'error');
                    }
                }
            });
        });
    </script>
@endsection
