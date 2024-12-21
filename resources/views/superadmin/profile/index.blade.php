@extends('superadmin.partials.profile')
@section('title', 'Profile')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Account Settings
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h2>Settings</h2>
                        </div>
                    </div>


                    <div class="tab-content" id="animateLineContent-4">
                        <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel"
                            aria-labelledby="animated-underline-home-tab">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <form class="section general-info" id="formUpdate" enctype="multipart/form-data">
                                        @csrf
                                        <div class="info">
                                            <h6 class="">General Information</h6>
                                            <div class="row">
                                                <div class="col-lg-11 mx-auto">
                                                    <div class="row">
                                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="text-center mb-4">
                                                                        <img src="{{ asset('storage/' . $user->foto) }}"
                                                                            alt="Foto Profil" id="profileImage"
                                                                            class="img-thumbnail rounded-circle"
                                                                            style="width: 150px; height: 150px; cursor: pointer;">
                                                                        <div class="mt-2">
                                                                            <label for="profilePhoto"
                                                                                class="btn btn-outline-primary btn-sm">Ganti
                                                                                Foto Profil</label>
                                                                            <input type="file" id="profilePhoto"
                                                                                name="foto" accept="image/*"
                                                                                class="d-none">
                                                                        </div>
                                                                    </div>


                                                                    <!-- Full Name -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fullName">Nama </label>
                                                                            <input type="text" class="form-control mb-3"
                                                                                id="fullName" name="nama"
                                                                                value="{{ $user->nama }}" />
                                                                        </div>
                                                                    </div>

                                                                    <!-- Phone -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="phone">No Telp</label>
                                                                            <input type="text" class="form-control mb-3"
                                                                                id="phone" name="no_hp"
                                                                                value="{{ $user->no_hp }}" />
                                                                        </div>
                                                                    </div>
                                                                    <!-- Email -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" class="form-control mb-3"
                                                                                id="email" name="email"
                                                                                value="{{ $user->email }}" />
                                                                        </div>
                                                                    </div>

                                                                    <!-- Old Password -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="old_password">Password Lama</label>
                                                                            <input type="password" class="form-control mb-3"
                                                                                id="old_password" name="old_password"
                                                                                placeholder="Enter current password" />
                                                                        </div>
                                                                    </div>

                                                                    <!-- New Password -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="new_password">Password Baru</label>
                                                                            <input type="password" class="form-control mb-3"
                                                                                id="new_password" name="new_password"
                                                                                placeholder="Enter new password" />
                                                                        </div>
                                                                    </div>

                                                                    <!-- Submit Button -->
                                                                    <div class="col-md-12 mt-1">
                                                                        <div class="form-group text-end">
                                                                            <button type="submit"
                                                                                class="btn btn-outline-primary btn-rounded mb-2 me-4">
                                                                                Simpan
                                                                            </button>
                                                                        </div>
                                                                        <div class="form-group text-end pt-2">
                                                                            <a href="{{ route('dashboard.superadmin') }}"
                                                                                class="btn btn-outline-dark btn-rounded mb-2 me-4">
                                                                                Kembali
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Preview Image
        $('#profilePhoto').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profileImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        // Submit Form with Ajax
        $('#formUpdate').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('profile-superadmin.update', $user->id) }}",
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
                                location
                                    .reload(); // Memuat ulang halaman agar perubahan foto terlihat
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
