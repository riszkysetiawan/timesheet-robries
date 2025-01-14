@extends('superadmin.partials.createuser')
@section('title', 'Mulai Timer')
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
                                        {{-- <select id="kode_produk" name="kode_produk" class="form-control" disabled>
                                            <option value="">Pilih Produk</option>
                                            @foreach ($produks as $produk)
                                                <option value="{{ $produk->kode_produk }}"
                                                    {{ $production->kode_produk == $produk->kode_produk ? 'selected' : '' }}>
                                                    {{ $produk->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="id_color" class="form-label">Warna</label>
                                        <select id="warna" name="warna" class="form-control" disabled>
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
                                        <select id="size" name="size" class="form-control" disabled>
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
                                            <!-- Ganti bagian ini di dalam foreach prosess -->
                                            @foreach ($prosess as $process)
                                                @if (!in_array($process->id, [19, 20]) || $production->finish_rework === 'Rework')
                                                    <li class="list-group-item mb-3">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-4">
                                                                <strong>{{ $process->nama }}</strong>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select name="id_user_{{ $process->id }}"
                                                                    id="id_user_{{ $process->id }}"
                                                                    class="form-select operator-select"
                                                                    {{ isset($processTimers[$process->id]) ? 'disabled' : '' }}>
                                                                    <option value="">Pilih Operator</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ isset($processTimers[$process->id]) && $processTimers[$process->id]->id_users == $user->id ? 'selected' : '' }}>
                                                                            {{ $user->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if (isset($processTimers[$process->id]))
                                                                    <small class="text-muted">
                                                                        Operator:
                                                                        {{ $processTimers[$process->id]->user->nama }}
                                                                        <br>
                                                                        Waktu :
                                                                        {{ $processTimers[$process->id]->created_at->format('d/m/Y H:i') }}
                                                                    </small>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-3">
                                                                <button class="btn btn-primary btn-sm float-end start-timer"
                                                                    data-process-id="{{ $process->id }}"
                                                                    data-select-id="id_user_{{ $process->id }}"
                                                                    {{ $process->is_done ? 'disabled' : '' }}>
                                                                    {{ $process->is_done ? 'Sudah Dimulai' : 'Mulai Timer' }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="size" class="form-label">Rework/ Finish</label>
                                        <select name="finish_rework" id="finish_rework" class="form-control">
                                            <option value="">Pilih</option>
                                            <option value="Finish">Finish</option>
                                            <option value="Rework">Rework</option>
                                            <option value="Reject">Reject</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="size" class="form-label">Catatan</label>
                                        <input type="text" id="catatan" name="catatan" class="form-control"
                                            placeholder="Catatan" />
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-rounded mb-2 me-4"
                                    id="updateFinishReworkButton">
                                    Update
                                </button>
                                <!-- Tombol Kembali -->
                                <button type="button" class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                    onclick="window.location.href='{{ route('production.admin.index') }}'">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.operator-select').select2()

            })
        </script>
    @endpush
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            $('.start-timer').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                var processId = button.data('process-id');
                var selectId = button.data('select-id');
                var userId = $('#' + selectId).val();
                var productionId = "{{ $production->id }}";

                // Validasi pemilihan operator
                if (!userId) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Silakan pilih operator terlebih dahulu!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                // Konfirmasi sebelum memulai timer
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin memulai timer untuk proses ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Mulai',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Data yang akan dikirim
                        var requestData = {
                            _token: "{{ csrf_token() }}",
                            process_id: processId,
                            production_id: productionId,
                            id_user: userId
                        };

                        // Kirim request AJAX
                        $.ajax({
                            url: "{{ route('production.startTimer') }}",
                            method: 'POST',
                            data: requestData,
                            beforeSend: function() {
                                // Disable button dan tampilkan loading
                                button.prop('disabled', true);
                                button.html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                                );
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        // Refresh halaman atau redirect
                                        window.location.href =
                                            "{{ route('production.admin.index') }}";
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                    button.prop('disabled', false);
                                    button.html('Mulai Timer');
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = 'Terjadi kesalahan!';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });

                                button.prop('disabled', false);
                                button.html('Mulai Timer');
                            }
                        });
                    }
                });
            });

            // Script untuk update Finish/Rework tetap sama seperti sebelumnya
            $('#updateFinishReworkButton').on('click', function() {
                // Get the value of the finish_rework field
                var finishRework = $('#finish_rework').val();

                // Check if a valid option is selected
                if (!finishRework) {
                    Swal.fire('Error!', 'Please select Rework or Finish.', 'error');
                    return;
                }

                // Submit the form to update the finish_rework
                var formData = {
                    _token: "{{ csrf_token() }}", // CSRF Token
                    finish_rework: finishRework, // Value of finish_rework dropdown
                };

                // Send AJAX request to update the finish_rework
                $.ajax({
                    url: "{{ route('production.updateFinishRework.admin', Crypt::encryptString($production->id)) }}", // Adjust this route
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Updated!', 'Finish/Rework status has been updated.',
                                'success');
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        // Handle any errors
                        var errorMessage = xhr.responseJSON?.message || 'Something went wrong.';
                        Swal.fire('Error!', errorMessage, 'error');
                    }
                });
            });
        });
    </script>
@endsection
