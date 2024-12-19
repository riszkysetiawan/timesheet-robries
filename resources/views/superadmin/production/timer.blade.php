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
                                        <select id="kode_produk" name="kode_produk" class="form-control" disabled>
                                            <option value="">Pilih Produk</option>
                                            @foreach ($produks as $produk)
                                                <option value="{{ $produk->kode_produk }}"
                                                    {{ $production->kode_produk == $produk->kode_produk ? 'selected' : '' }}>
                                                    {{ $produk->nama_barang }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                                    {{ $produk->id_size == $size->id ? 'selected' : '' }}>
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
                                <!-- Kategori -->
                                {{-- <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="unfinished_processes" class="form-label">Proses yang Belum
                                            Dikerjakan</label>
                                        <ul class="list-group">
                                            @foreach ($prosess as $process)
                                                <!-- Tampilkan proses Rework Start dan Rework Finish hanya jika finish_rework adalah Rework -->
                                                @if (!in_array($process->id, [19, 20]) || $production->finish_rework === 'Rework')
                                                    <li class="list-group-item">
                                                        {{ $process->nama }}
                                                        <button class="btn btn-primary btn-sm float-end start-timer"
                                                            data-process-id="{{ $process->id }}">
                                                            Mulai Timer
                                                        </button>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> --}}
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="unfinished_processes" class="form-label">Proses yang Belum
                                            Dikerjakan</label>
                                        <ul class="list-group">
                                            @foreach ($prosess as $process)
                                                <!-- Tampilkan proses Rework Start dan Rework Finish hanya jika finish_rework adalah Rework -->
                                                @if (!in_array($process->id, [19, 20]) || $production->finish_rework === 'Rework')
                                                    <li class="list-group-item">
                                                        {{ $process->nama }}
                                                        <button class="btn btn-primary btn-sm float-end start-timer"
                                                            data-process-id="{{ $process->id }}"
                                                            {{ $process->is_done ? 'disabled' : '' }}>
                                                            {{ $process->is_done ? 'Sudah Dimulai' : 'Mulai Timer' }}
                                                        </button>
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
                                        </select>
                                    </div>
                                </div>

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
        $(document).on('click', '.start-timer', function() {
            var processId = $(this).data('process-id');
            var productionId = "{{ $production->id }}";
            var requestData = {
                _token: "{{ csrf_token() }}",
                process_id: processId,
                production_id: productionId,
            };

            // Log data yang dikirim ke backend
            console.log('Data yang dikirim ke backend:', requestData);

            // Kirim AJAX request
            $.ajax({
                url: "{{ route('production.startTimer') }}", // Ganti dengan URL backend Anda
                method: 'POST',
                data: requestData,
                success: function(response) {
                    if (response.status === 'success') {
                        // Log respons untuk debugging
                        console.log('Response:', response);

                        // Tampilkan pesan sukses
                        Swal.fire('Berhasil!', response.message, 'success');

                        // Perbarui UI secara dinamis tanpa reload
                        $('[data-process-id="' + processId + '"]').prop('disabled',
                            true); // Disable tombol yang diklik
                    }
                },
                error: function(xhr) {
                    // Log error untuk debugging
                    console.error('Error Response:', xhr);
                    var errorMessage = xhr.responseJSON?.message ||
                        'Terjadi kesalahan saat memulai timer.';
                    Swal.fire('Error!', errorMessage, 'error');
                }
            });
        });
    </script>


    {{-- <script>
        $('#BarangForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('production.admin.update', Crypt::encryptString($production->id)) }}",
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
                                window.location.href = '{{ route('production.admin.index') }}';
                            }
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '<br>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Validasi',
                            html: errorMessage,
                        });
                    } else {
                        Swal.fire('Error!', 'Terjadi kesalahan saat memproses permintaan.', 'error');
                    }
                }
            });
        });
    </script> --}}

@endsection
