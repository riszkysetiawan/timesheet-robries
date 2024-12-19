@extends('superadmin.partials.createuser')
@section('title', 'Tambah User')
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

            <div class="row">
                <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Tambah Users</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="userForm" enctype="multipart/form-data">
                                @csrf
                                <!-- Nama Lengkap -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            placeholder="Nama Lengkap *" />
                                    </div>
                                </div>

                                <!-- Nomor HP -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="no_hp" class="form-label">NO HP</label>
                                        <input type="text" id="no_hp" name="no_hp" class="form-control"
                                            placeholder="Nomor Hp*" />
                                    </div>
                                </div>

                                <!-- Foto Profile -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="foto" class="form-label">Foto Profile</label>
                                        <input type="file" id="foto" name="foto" class="form-control" />
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control"
                                            placeholder="Email address *" />
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Password *" />
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" placeholder="Confirm Password *" />
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="role" class="form-label">Role</label>
                                        <select name="id_role" id="id_role" class="form-control" required>
                                            <option value="">Pilih Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <!-- Tombol Submit -->
                                <button type="submit" class="btn btn-outline-success  btn-rounded mb-2 me-4"
                                    id="submitButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                    Simpan
                                </button>

                                <!-- Tombol Kembali -->
                                <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                    onclick="window.location.href='{{ route('users.index') }}'">
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
    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ route('user.store') }}",
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
                                    $('#userForm')[0].reset();
                                    window.location.href = '/users';
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
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan, coba lagi nanti.',
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
