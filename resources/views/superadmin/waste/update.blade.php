@extends('superadmin.partials.createuser')
@section('title', 'Update Reject')
@section('container')
    <div class="container">
        <div class="row">
            <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Edit Waste Barang</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">

                        <form id="updateData" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="kode_barang" class="form-label">Nama Barang</label>
                                    <select id="kode_barang" class="form-control" disabled>
                                        <option value="">Pilih Barang</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->kode_barang }}"
                                                {{ old('kode_barang', $waste->kode_barang) == $barang->kode_barang ? 'selected' : '' }}>
                                                {{ $barang->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Display Current Stock -->
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="current_stock" class="form-label">Jumlah Stock Saat Ini</label>
                                    <input type="number" id="current_stock" class="form-control"
                                        value="{{ $stock->stock }}" readonly />
                                </div>
                            </div>

                            <!-- Editable Waste Old Section -->
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="waste_old" class="form-label">Jumlah Waste</label>
                                    <input type="number" id="waste_old" name="waste_old" class="form-control"
                                        value="{{ $waste->jumlah }}" min="0" />
                                </div>
                            </div>

                            <!-- Select Alasan -->
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="id_alasan" class="form-label">Pilih Alasan</label>
                                    <select id="id_alasan" name="id_alasan" class="form-control">
                                        <option value="">Pilih Alasan</option>
                                        @foreach ($alasans as $alasan)
                                            <option value="{{ $alasan->id }}"
                                                {{ old('id_alasan', $waste->id_alasan) == $alasan->id ? 'selected' : '' }}>
                                                {{ $alasan->alasan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Foto Input -->
                            <div class="row mb-4">
                                <div class="col-sm-12">
                                    <label for="foto" class="form-label">Bukti Foto</label>
                                    <input type="file" name="foto" class="form-control" />
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                                    @if ($waste->foto)
                                        <img src="{{ asset('storage/' . $waste->foto) }}" alt="Bukti Foto"
                                            style="max-width: 100px;">
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-save">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>
                                Update</button>
                            <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                onclick="window.location.href='{{ route('waste.admin.index') }}'">
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

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('waste.admin.update', Crypt::encryptString($waste->id)) }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', response.message, 'success')
                            .then(() => {
                                $('#current_stock').val(response.remaining_stock);
                                $('#waste_old').val(response.total_waste);
                                window.location.href = '{{ route('waste.admin.index') }}';
                            });
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON.message || 'Terjadi kesalahan!', 'error');
                }
            });
        });
    </script>
@endsection
