@extends('operator-produksi.partials.createuser')
@section('title', 'Update Timer Production')
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
                                    <h4>Edit Data Production</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="BarangForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="so_number" class="form-label">SO Number</label>
                                        <input type="text" id="so_number" name="so_number" class="form-control"
                                            value="{{ old('so_number', $production->so_number) }}" readonly />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="kode_produk" class="form-label">Nama Produk</label>
                                        <input type="text" id="nama_produk" name="nama_produk" class="form-control"
                                            value="{{ old('nama_produk', $production->nama_produk) }}" readonly />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_color" class="form-label">Warna</label>
                                        <select id="warna" name="warna" class="form-control">
                                            <option value="">Pilih Warna</option>
                                            @foreach ($warnas as $warna)
                                                <option value="{{ $warna->id }}"
                                                    {{ $production->id_color == $warna->id ? 'selected' : '' }}>
                                                    {{ $warna->warna }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_kategori" class="form-label">Ukuran</label>
                                        <select id="size" name="size" class="form-control">
                                            <option value="">Pilih Ukuran</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}"
                                                    {{ $production->id_size == $size->id ? 'selected' : '' }}>
                                                    {{ $size->size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="size" class="form-label">qty</label>
                                        <input type="text" id="qty" name="qty" class="form-control"
                                            value="{{ old('qty', $production->qty) }}" placeholder="Jumlah *" readonly />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="size" class="form-label">barcode</label>
                                        <input type="text" id="barcode" name="barcode" class="form-control"
                                            value="{{ old('barcode', $production->barcode) }}" placeholder="Barcode *"
                                            readonly />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="unfinished_processes" class="form-label">Proses yang Belum
                                            Dikerjakan</label>
                                        <ul class="list-group">
                                            @php
                                                $enableNext = true; // Variabel untuk mengaktifkan tombol pertama
                                            @endphp
                                            @foreach ($prosess as $process)
                                                @php
                                                    // Ambil timer yang sesuai dengan proses
                                                    $timer = $production->timers->firstWhere('id_proses', $process->id);
                                                @endphp
                                                <li class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Nama Proses -->
                                                        <div class="d-flex align-items-center">
                                                            <strong class="me-3">{{ $process->nama }}</strong>
                                                            <!-- Nama proses -->
                                                            <input type="text"
                                                                class="form-control form-control-sm d-inline-block timer-input"
                                                                style="width: 100px;"
                                                                value="{{ $timer ? $timer->waktu : '' }}"
                                                                data-timer-id="{{ $timer->id ?? '' }}" placeholder="Waktu"
                                                                readonly />
                                                        </div>

                                                        <button class="btn btn-success btn-sm update-timer"
                                                            data-process-id="{{ $process->id }}"
                                                            data-timer-id="{{ $timer->id ?? '' }}">
                                                            Update Timer
                                                        </button>

                                                    </div>
                                                </li>
                                                @php
                                                    if (!$process->is_done) {
                                                        $enableNext = false; // Nonaktifkan tombol berikutnya setelah tombol pertama ditemukan
                                                    }
                                                @endphp
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Tombol Update -->
                                {{-- <button type="submit" class="btn btn-outline-success btn-rounded mb-2 me-4"
                                    id="submitButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Update
                                </button> --}}

                                <!-- Tombol Kembali -->
                                <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                    onclick="window.location.href='{{ route('production.admin.index') }}'">
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
        $(document).ready(function() {
            // Event listener untuk tombol Hapus Timer
            $(document).on('click', '.start-timer', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol

                var timerId = $(this).data('timer-id'); // Ambil ID timer
                var processId = $(this).data('process-id'); // Ambil ID proses (opsional, jika diperlukan)

                // Validasi apakah timer ID tersedia
                if (!timerId) {
                    Swal.fire('Error!', 'Timer ID tidak valid.', 'error');
                    return;
                }

                // Tampilkan konfirmasi SweetAlert
                Swal.fire({
                    title: 'Hapus Timer',
                    text: 'Apakah Anda yakin ingin menghapus timer ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan AJAX untuk menghapus timer di server
                        $.ajax({
                            url: "{{ route('admin.production.deleteTimer') }}", // Route untuk hapus timer
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token
                                timer_id: timerId // ID timer yang akan dihapus
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Tampilkan pesan sukses
                                    Swal.fire('Berhasil!', response.message, 'success')
                                        .then(() => {
                                            location
                                                .reload(); // Reload halaman untuk memperbarui data
                                        });
                                } else {
                                    // Tampilkan pesan error jika ada masalah
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                // Tangani error dari server
                                var errorMessage = xhr.responseJSON?.message ||
                                    'Terjadi kesalahan.';
                                Swal.fire('Error!', errorMessage, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Event listener untuk tombol Update Timer
            $(document).on('click', '.update-timer', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol

                var timerId = $(this).data('timer-id'); // Ambil ID timer
                var processId = $(this).data('process-id'); // Ambil ID proses (opsional, jika diperlukan)

                // Validasi apakah timer ID tersedia
                if (!timerId) {
                    Swal.fire('Error!', 'Timer ID tidak valid.', 'error');
                    return;
                }

                // Minta waktu baru dari pengguna melalui SweetAlert
                Swal.fire({
                    title: 'Update Timer',
                    input: 'text',
                    inputPlaceholder: 'Contoh: 01:30:00',
                    inputLabel: 'Masukkan waktu baru (format HH:MM:SS)',
                    inputValue: new Date().toLocaleTimeString('en-GB', {
                        hour12: false
                    }),

                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Batal',
                    preConfirm: (newTime) => {
                        // Validasi format waktu (HH:MM:SS)
                        const timeRegex = /^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
                        if (!timeRegex.test(newTime)) {
                            Swal.showValidationMessage(
                                'Format waktu tidak valid. Gunakan format HH:MM:SS'
                            );
                        }
                        return newTime; // Kembalikan waktu baru jika valid
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var newTime = result.value; // Ambil waktu baru dari input pengguna

                        // Kirim permintaan AJAX untuk memperbarui waktu di server
                        $.ajax({
                            url: "{{ route('admin.production.updateTimer') }}", // Route untuk update timer
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}", // CSRF Token
                                timer_id: timerId, // ID timer yang akan diperbarui
                                waktu: newTime // Waktu baru
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    // Tampilkan pesan sukses
                                    Swal.fire('Berhasil!', response.message, 'success')
                                        .then(() => {
                                            location
                                                .reload(); // Reload halaman untuk memperbarui data
                                        });
                                } else {
                                    // Tampilkan pesan error jika ada masalah
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                // Tangani error dari server
                                var errorMessage = xhr.responseJSON?.message ||
                                    'Terjadi kesalahan.';
                                Swal.fire('Error!', errorMessage, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>


@endsection
