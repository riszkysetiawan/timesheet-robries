@extends('superadmin.partials.createuser')
@section('title', 'Update Company Profile')
@section('container')
    <div class="container">
        <div class="container">
            <div class="row">
                <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Update Data Toko</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="editData" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control" name="nama"
                                            value="{{ $profiles->nama }}" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Foto</label>
                                        <!-- Tampilkan foto lama -->
                                        @if ($profiles->foto)
                                            <div class="mb-3">
                                                <img src="{{ asset('storage/' . $profiles->foto) }}" alt="Foto Lama"
                                                    class="img-thumbnail" style="max-width: 150px;">
                                            </div>
                                        @endif
                                        <!-- Input untuk foto baru -->
                                        <input type="file" class="form-control" name="foto" />
                                        <!-- Simpan nilai foto lama di hidden input -->
                                        <input type="hidden" name="foto_lama" value="{{ $profiles->foto }}">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" name="alamat"
                                            value="{{ $profiles->alamat }}" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $profiles->email }}" />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">No Telp</label>
                                        <input type="number" class="form-control" name="no_telp"
                                            value="{{ $profiles->no_telp }}" />
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                        </path>
                                        <polyline points="17 21 17 13 7 13 7 21">
                                        </polyline>
                                        <polyline points="7 3 7 8 15 8">
                                        </polyline>
                                    </svg>
                                    Simpan
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                    onclick="window.location.href='{{ route('profil.company.admin.index') }}'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                                        <line x1="19" y1="12" x2="5" y2="12">
                                        </line>
                                        <polyline points="12 19 5 12 12 5">
                                        </polyline>
                                    </svg>
                                    Kembali</button>
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
        $('#editData').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this); // Gunakan FormData untuk mengirim file
            $.ajax({
                url: "{{ route('profil.company.admin.update', Crypt::encryptString($profiles->id)) }}",
                method: 'POST',
                data: formData,
                contentType: false, // Harus false untuk FormData
                processData: false, // Harus false untuk FormData
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', response.message, 'success')
                            .then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('profil.company.admin.index') }}';
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
    </script>
@endsection
