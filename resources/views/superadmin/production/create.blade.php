@extends('superadmin.partials.penjualan')
@section('title', 'Tambah Penjualan')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <form id="submitForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="invoice-content">
                                        <div class="invoice-detail-body">
                                            {{--
                                            <div class="invoice-detail-header">
                                                <div class="row justify-content-between">
                                                    <div class="col-xl-5 invoice-address-company">
                                                        <h4>From:-</h4>
                                                        <div class="invoice-address-company-fields">
                                                            <div class="form-group row">
                                                                <label for="company-name"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Nama
                                                                    Kasir</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" id="nama_kasir"
                                                                        placeholder="Nama Kasir" name="nama_kasir"
                                                                        value="{{ Auth::user()->nama }}" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="invoice-detail-terms">
                                                <div class="row justify-content-between">
                                                    {{-- <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="number">SO Number</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="so_number" name="so_number" />
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="tgl_buat">Tanggal</label>
                                                            <input type="date" name="tgl_production"
                                                                class="form-control form-control-sm" id="tgl_production"
                                                                readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invoice-detail-items">
                                                <div class="table-responsive">
                                                    <table class="table item-table">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>KODE SO</th>
                                                                <th>Nama Produk</th>
                                                                <th>Barcode</th>
                                                                <th>Size</th>
                                                                <th>Color</th>
                                                                <th>Qty</th>
                                                                @foreach ($prosess as $proses)
                                                                    <th>Progres {{ $proses->nama }}
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="delete-item-row">
                                                                    <ul class="table-controls">
                                                                        <li><a href="javascript:void(0);"
                                                                                class="delete-item" title="Delete">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24" fill="none"
                                                                                    stroke="currentColor" stroke-width="2"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    class="feather feather-x-circle">
                                                                                    <circle cx="12" cy="12"
                                                                                        r="10"></circle>
                                                                                    <line x1="15" y1="9"
                                                                                        x2="9" y2="15">
                                                                                    </line>
                                                                                    <line x1="9" y1="9"
                                                                                        x2="15" y2="15">
                                                                                    </line>
                                                                                </svg>
                                                                            </a></li>
                                                                    </ul>
                                                                </td>
                                                                <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="So Number" name="so_number[]" />
                                                                </td>
                                                                <td class="description">
                                                                    <select name="kode_produk[]"
                                                                        class="form-control form-control-sm"
                                                                        id="kode_produk_select">
                                                                        <option value="">Pilih Barang</option>
                                                                        @foreach ($produks as $produk)
                                                                            <option value="{{ $produk->kode_produk }}">
                                                                                {{ $produk->nama_barang }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Barcode" name="barcode[]" />
                                                                </td>
                                                                <td class="description">
                                                                    <select name="size[]"
                                                                        class="form-control form-control-sm size_select">
                                                                        <option value="">Pilih Ukuran</option>
                                                                        @foreach ($sizes as $size)
                                                                            <option value="{{ $size->size }}">
                                                                                {{ $size->size }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-right">
                                                                    <select name="warna[]"
                                                                        class="form-control form-control-sm warna_select">
                                                                        <option value="">Warna</option>
                                                                        @foreach ($warnas as $warna)
                                                                            <option value="{{ $warna->warna }}">
                                                                                {{ $warna->warna }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Quantity" name="qty[]" />
                                                                </td>
                                                                @foreach ($prosess as $proses)
                                                                    <td class="text-right qty">
                                                                        <div class="d-flex flex-column">
                                                                            <input type="hidden" name="id_proses[]"
                                                                                value="{{ $proses->id }}">
                                                                            <input type="time"
                                                                                class="form-control form-control-sm"
                                                                                name="waktu_proses[]" />
                                                                        </div>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn btn-dark additem">Add Item</button>
                                            </div>

                                            <div class="invoice-detail-total">
                                                <div class="row">
                                                    <div class="col-xl-12 col-md-4">
                                                        <button type="submit"
                                                            class="btn btn-outline-success btn-rounded mb-2 me-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-check-circle">
                                                                <path d="M9 11l3 3L22 4"></path>
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                            </svg>
                                                            Simpan</button>
                                                    </div>
                                                    <div class="col-xl-12 col-md-4 pt-2">
                                                        <button type="button"
                                                            class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                                            onclick="window.location.href='{{ route('production.admin.index') }}'">

                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-arrow-left">
                                                                <line x1="19" y1="12" x2="5"
                                                                    y2="12"></line>
                                                                <polyline points="12 19 5 12 12 5"></polyline>
                                                            </svg>
                                                            Kembali</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#kode_produk_select').select2({
                placeholder: "Pilih Barang",
                allowClear: true
            });
            $('.size_select').select2({
                placeholder: "Pilih Ukuran",
                allowClear: true
            });
            $('.warna_select').select2({
                placeholder: "Pilih warna",
                allowClear: true
            });

            $('#kode_produk_select').on('change', function() {
                var kode_produk = $(this).val();
                var row = $(this).closest('tr');

                if (kode_produk) {
                    $.ajax({
                        url: '/get-produk/admin/' + kode_produk,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                row.find('select[name="warna[]"]').val(data.warna)
                                    .change();
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('select[name="warna[]"]').val(''); // Kosongkan jika error
                        }
                    });
                } else {
                    row.find('select[name="warna[]"]').val(
                        '');
                }
            });
            $('#size_select').on('change', function() {
                var kode_produk = $(this).val();
                var row = $(this).closest('tr');

                if (kode_produk) {
                    $.ajax({
                        url: '/get-ukuran/admin/' + kode_produk,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                row.find('select[name="size[]"]').val(data.size)
                                    .change();
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('select[name="size[]"]').val(''); // Kosongkan jika error
                        }
                    });
                } else {
                    row.find('select[name="size[]"]').val(
                        '');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#submitForm').on('submit', function(e) {
                e.preventDefault();

                // Mengambil data form yang sudah diserialisasi
                var formData = $(this).serializeArray();

                // Menampilkan data dalam format yang lebih mudah dibaca
                var formattedData = {};
                formData.forEach(function(item) {
                    if (!formattedData[item.name]) {
                        formattedData[item.name] = [];
                    }
                    formattedData[item.name].push(item.value);
                });

                console.log("Data yang dikirim ke backend (terformat):", formattedData);

                $.ajax({
                    url: "{{ route('production.admin.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#simpan')[0].reset();
                                    window.location.href =
                                        '{{ route('production.admin.index') }}';
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
                            Swal.fire('Error!', xhr.responseJSON.message, 'error');
                        }
                    }
                });
            });
        });


        // $(document).ready(function() {
        //     $('#submitForm').on('submit', function(e) {
        //         e.preventDefault();
        //         var formData = $(this).serialize();
        //         $.ajax({
        //             url: "{{ route('production.admin.store') }}",
        //             method: "POST",
        //             data: formData,
        //             success: function(response) {
        //                 if (response.status === 'success') {
        //                     Swal.fire({
        //                         title: 'Berhasil!',
        //                         text: response.message,
        //                         icon: 'success',
        //                         confirmButtonText: 'OK'
        //                     }).then((result) => {
        //                         if (result.isConfirmed) {
        //                             $('#simpan')[0].reset();
        //                             window.location.href =
        //                                 '{{ route('production.admin.index') }}';
        //                         }
        //                     });
        //                 }
        //             },
        //             error: function(xhr) {
        //                 if (xhr.status === 422) {
        //                     var errors = xhr.responseJSON.errors;
        //                     var errorMessage = '';
        //                     $.each(errors, function(key, value) {
        //                         errorMessage += value + '\n';
        //                     });
        //                     Swal.fire('Error!', errorMessage, 'error');
        //                 } else {
        //                     Swal.fire('Error!', xhr.responseJSON.message, 'error');
        //                 }
        //             }
        //         });
        //     });
        // });



        $(document).on('input', 'input[name="qty[]"', function() {
            var row = $(this).closest('tr');
            calculateTotalRow(row);
            calculateTotal();
        });


        $('.additem').on('click', function(e) {
            e.preventDefault();
            var newRow = `
    <tr>
        <td class="delete-item-row">
            <ul class="table-controls">
                <li><a href="javascript:void(0);" class="delete-item" title="Delete">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </a></li>
            </ul>
        </td>
          <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="So Number" name="so_number[]" />
                                                                </td>
        <td class="description">
            <select name="kode_produk[]" class="form-control form-control-sm kode_produk_select">
                <option value="">Pilih Produk</option>
                @foreach ($produks as $produk)
                    <option value="{{ $produk->kode_produk }}">
                        {{ $produk->nama_barang }}
                    </option>
                @endforeach
            </select>
        </td>
          <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Barcode" name="barcode[]" />
                                                                </td>
        <td class="description">
            <select name="size[]"  class="form-control form-control-sm size_select">
                <option value="">Pilih Produk</option>
                @foreach ($sizes as $size)
                    <option value="{{ $size->size }}">
                        {{ $size->size }}
                    </option>
                @endforeach
            </select>
        </td>
         <td class="text-right">
                <select name="warna[]" class="form-control form-control-sm warna_select">
                    <option value="">Pilih warna</option>
                    @foreach ($warnas as $warna)
                        <option value="{{ $warna->warna }}">{{ $warna->warna }}</option>
                    @endforeach
                </select>
            </td>

        <td class="text-right qty">
            <input type="text" class="form-control form-control-sm" placeholder="Quantity" name="qty[]" />
        </td>
         @foreach ($prosess as $proses)
                                                                    <td class="text-right qty">
                                                                        <div class="d-flex flex-column">
                                                                             <input type="hidden" name="id_proses[]"
                                                                                value="{{ $proses->id }}">
                                                                            <input type="time"
                                                                                class="form-control form-control-sm"
                                                                                name="waktu_proses[]" />
                                                                        </div>
                                                                    </td>
                                                                @endforeach
    </tr>`;

            $('table.item-table tbody').append(newRow);

            $('.warna_select').select2({
                placeholder: "Pilih warna",
                allowClear: true
            });

            $('.size_select').select2({
                placeholder: "Pilih Ukuran",
                allowClear: true
            });

            $('select[name="kode_produk[]"]').last().select2({
                placeholder: "Pilih Barang",
                allowClear: true
            });


            $(document).on('change', 'select[name="kode_produk[]"]', function() {
                var kode_produk = $(this).val();
                var row = $(this).closest('tr');

                if (kode_produk) {
                    $.ajax({
                        url: '/get-produk/admin/' + kode_produk,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.produk !== undefined) {
                                row.find('select[name="warna[]"]').val(data.warna).change();
                                calculateTotalRow(row);
                                calculateTotal();
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('select[name="warna[]"]').val('');
                        }
                    });
                } else {
                    row.find('select[name="warna[]"]').val('');
                }
            });


        });


        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            calculateTotal();
        });

        $(document).on('change', 'select[name="kode_produk[]"]', function() {
            var kode_produk = $(this).val();
            var row = $(this).closest('tr');

            if (kode_produk) {
                $.ajax({
                    url: '/get-produk/admin/' + kode_produk,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            row.find('input[name="harga[]"]').val(formatRupiah(data.harga));
                            calculateTotalRow(row);
                            calculateTotal();
                        }
                    },
                    error: function(xhr, status, error) {
                        row.find('select[name="warna[]"]').val(
                            '');

                    }
                });
            } else {
                row.find('input[name="warna[]"]').val('');

            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_production').value = today;
        });
    </script>
@endsection
