@extends('superadmin.partials.tambahpemasok')
@section('title', 'Update Pemasok')
@section('container')
    <div class="container">
        <div class="container">
            <div class="row">
                <div id="browser_default" class="col-lg-12 layout-spacing col-md-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Edit Supplier</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="editUserForm" class="row g-3">
                                @csrf
                                <div class="col-md-4">
                                    <label for="validationDefault01" class="form-label">Nama Supplier</label>
                                    <input type="text" class="form-control" name="nama_supplier"
                                        value="{{ $supplier->nama_supplier }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="validationDefault02" class="form-label">Alamat Supplier</label>
                                    <input type="text" class="form-control" name="alamat"
                                        value="{{ $supplier->alamat }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="validationDefaultUsername" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                        <input type="email" class="form-control" name="email"
                                            aria-describedby="inputGroupPrepend2" value="{{ $supplier->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationDefault03" class="form-label">No Telp</label>
                                    <input type="number" class="form-control" name="no_telp"
                                        value="{{ $supplier->no_telp }}">
                                </div>
                                <div class="col-12">
                                    <!-- Tombol Simpan -->
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                            </path>
                                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                            <polyline points="7 3 7 8 15 8"></polyline>
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                                <div class="col-12">
                                    <!-- Tombol Kembali -->
                                    <button type="button" class="btn btn-secondary"
                                        onclick="window.location.href='{{ route('supplier.admin.index') }}'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-left">
                                            <line x1="19" y1="12" x2="5" y2="12"></line>
                                            <polyline points="12 19 5 12 12 5"></polyline>
                                        </svg>
                                        Kembali
                                    </button>
                                </div>
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
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('supplier.admin.update', Crypt::encryptString($supplier->id)) }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/supplier/admin';
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
                    } else {
                        Swal.fire('Error!', 'Terjadi kesalahan, silakan coba lagi nanti.', 'error');
                    }
                }
            });
        });
    </script>
@endsection
