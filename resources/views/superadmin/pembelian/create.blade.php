@extends('superadmin.partials.penjualan')
@section('title', 'Tambah Pembelian')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <form id="submitForm">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="invoice-content">
                                        <div class="invoice-detail-body">
                                            <div class="invoice-detail-title">
                                                <div class="invoice-title">
                                                    <input type="text" class="form-control" placeholder="Purchase Order"
                                                        value="Invoice Pembelian" readonly />
                                                </div>
                                            </div>

                                            <div class="invoice-detail-header">
                                                <div class="row justify-content-between">
                                                    <div class="col-xl-5 invoice-address-company">
                                                        <h4>From:-</h4>
                                                        <div class="invoice-address-company-fields">
                                                            <div class="form-group row">
                                                                <label for="company-name"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-name" placeholder="Business Name"
                                                                        value="{{ $profile->nama_toko }}" readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="company-email"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-email" placeholder="name@company.com"
                                                                        value="{{ $profile->email }}" readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="company-address"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-address" placeholder="XYZ Street"
                                                                        value="{{ $profile->alamat }}" readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="company-phone"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">No
                                                                    Hp</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-phone" placeholder="(123) 456 789"
                                                                        value="{{ $profile->no_hp }}" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-5 invoice-address-client">
                                                        <h4>Ditujukan Kepada:-</h4>
                                                        <div class="invoice-address-client-fields">
                                                            <div class="form-group row">
                                                                <label for="client-name"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Nama
                                                                    Supplier</label>
                                                                <div class="col-sm-9">
                                                                    <select name="id_supplier" id="id_supplier"
                                                                        class="form-control form-control-sm">
                                                                        <option value="">Pilih Supplier</option>
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->id }}">
                                                                                {{ $supplier->nama_supplier }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="client-email"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="client-email" readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="client-address"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="client-address" readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="client-phone"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">No
                                                                    Hp</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="client-phone" readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invoice-detail-terms">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="number">Invoice Number</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="number" name="kode_po" value="{{ $poCode }}"
                                                                readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="tgl_buat">Tanggal Pembelian</label>
                                                            <input type="date" name="tgl_buat"
                                                                class="form-control form-control-sm" id="tgl_buat"
                                                                readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="eta">Estimasi Kedatangan</label>
                                                            <input type="date" name="eta"
                                                                class="form-control form-control-sm" id="eta" />
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
                                                                <th>Description</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Satuan</th>
                                                                <th class="text-right">Sub Total</th>
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
                                                                <td class="description">
                                                                    <select name="kode_barang[]"
                                                                        class="form-control form-control-sm"
                                                                        id="kode_barang_select">
                                                                        <option value="">Pilih Barang</option>
                                                                        @foreach ($barangs as $barang)
                                                                            <option value="{{ $barang->kode_barang }}">

                                                                                {{ $barang->nama_barang }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <textarea class="form-control" placeholder="Keterangan Tambahan" name="keterangan_tambahan[]"></textarea>
                                                                </td>
                                                                <td class="rate">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Harga" name="harga[]" readonly />
                                                                </td>
                                                                <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Quantity" name="qty[]" />
                                                                </td>
                                                                <input type="hidden" name="sub_total[]"
                                                                    value="" />
                                                                <td class="text-right">
                                                                    <select name="satuan[]"
                                                                        class="form-control form-control-sm satuan_select">
                                                                        <option value="">Pilih Satuan</option>
                                                                        @foreach ($satuans as $satuan)
                                                                            <option value="{{ $satuan->satuan }}">
                                                                                {{ $satuan->satuan }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td class="text-right amount">
                                                                    <span class="currency">Rp</span>
                                                                    <span class="amount">0.00</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn btn-dark additem">Add Item</button>
                                            </div>

                                            <div class="invoice-detail-total">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="totals-row">
                                                            <div class="invoice-totals-row invoice-summary-balance-due">
                                                                <div class="invoice">Total</div>
                                                                <div class="invoice-summary-value">
                                                                    <div class="balance-due-amount ">
                                                                        <span class="currency"></span>
                                                                        <span class="amount"
                                                                            id="total-display">0.00</span>
                                                                    </div>
                                                                </div>
                                                                <div class="balance-due-amount">
                                                                    <input type="hidden" id="total" name="total"
                                                                        class="form-control form-control-sm" readonly />
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="status"
                                                                value="Belum Diterima" />
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-xl-12 col-md-4">
                                                        <a href="./app-invoice-preview.html"
                                                            class="btn btn-secondary btn-preview">Preview</a>
                                                    </div> --}}
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
                                                            Save</button>
                                                    </div>
                                                    <div class="col-xl-12 col-md-4 pt-2">
                                                        <button type="button"
                                                            class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                                            onclick="window.location.href='{{ route('pembelian.admin.index') }}'">
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

                                {{-- <div class="col-xl-3">
                                    <div class="invoice-actions-btn">
                                        <div class="row">

                                        </div>
                                    </div>
                                </div> --}}
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
            // Initialize Select2 on the barang dropdown
            $('#kode_barang_select').select2({
                placeholder: "Pilih Barang",
                allowClear: true
            });

            $('.satuan_select').select2({
                placeholder: "Pilih Satuan",
                allowClear: true
            });

            // Optionally, you can handle the change event here to update price when a barang is selected
            $('#kode_barang_select').on('change', function() {
                var kode_barang = $(this).val();
                var row = $(this).closest('tr');

                if (kode_barang) {
                    $.ajax({
                        url: '/get-barang/admin/' + kode_barang,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                row.find('input[name="harga[]"]').val(formatRupiah(data.barang
                                    .harga_beli));
                                row.find('select[name="satuan[]"]').val(data.satuan)
                                    .change(); // Mengisi dropdown satuan
                                calculateTotalRow(row);
                                calculateTotal();
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('input[name="harga[]"]').val('');
                            row.find('select[name="satuan[]"]').val(''); // Kosongkan jika error
                        }
                    });
                } else {
                    row.find('input[name="harga[]"]').val('');
                    row.find('select[name="satuan[]"]').val(
                        ''); // Kosongkan jika tidak ada barang yang dipilih
                }
            });
        });

        $(document).on('input', 'input[name="kode_barcode[]"]', function() {
            var barcode = $(this).val();
            var row = $(this).closest('tr');

            if (barcode) {
                $.ajax({
                    url: '/get-barang-by-barcode/admin/' + barcode, // Ganti URL dengan route yang sesuai
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            // Set nilai harga ke input harga pada baris yang sama
                            row.find('input[name="harga[]"]').val(formatRupiah(data.harga));
                            row.find('select[name="kode_barang[]"]').val(data.kode_barang)
                                .change(); // Set kode_barang jika perlu
                            calculateTotalRow(row); // Hitung total untuk baris
                            calculateTotal(); // Hitung total keseluruhan
                        } else {
                            // Jika tidak ada data ditemukan, reset harga
                            row.find('input[name="harga[]"]').val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        row.find('input[name="harga[]"]').val('');
                    }
                });
            } else {
                // Kosongkan harga jika barcode tidak ada
                row.find('input[name="harga[]"]').val('');
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Ketika dropdown supplier berubah
            $('#id_supplier').on('change', function() {
                var supplierID = $(this).val();

                if (supplierID) {
                    // AJAX request untuk mengambil data supplier
                    $.ajax({
                        url: '/get-supplier/admin/' + supplierID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                // Isi otomatis field email, alamat, dan no hp
                                $('#client-email').val(data.email);
                                $('#client-address').val(data.alamat);
                                $('#client-phone').val(data.no_telp);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error: ' + error);
                        }
                    });
                } else {
                    // Kosongkan input jika tidak ada supplier yang dipilih
                    $('#client-email').val('');
                    $('#client-address').val('');
                    $('#client-phone').val('');
                }
            });
        });
    </script>
    <script>
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ""),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }
            return rupiah ? "Rp" + rupiah : "Rp0";
        }


        function parseCurrency(value) {
            // Hapus semua karakter non-angka dan ubah menjadi format angka murni
            return parseFloat(value.replace(/[^0-9]/g, '')) || 0;
        }



        $(document).ready(function() {
            $('#submitForm').on('submit', function(e) {
                e.preventDefault();
                $('input[name="harga[]"]').each(function() {
                    var harga = $(this).val();
                    $(this).val(parseCurrency(harga));
                });

                var total = $('#total').val();
                $('#total').val(parseCurrency(total));

                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('pembelian.admin.store') }}",
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
                                    $('#submitForm')[0].reset();
                                    window.location.href =
                                        '{{ route('pembelian.admin.index') }}';
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

        $(document).on('input', 'input[name="qty[]"], input[name="harga[]"]', function() {
            var row = $(this).closest('tr');
            calculateTotalRow(row);
            calculateTotal();
        });

        function calculateTotalRow(row) {
            var qty = row.find('input[name="qty[]"]').val();
            var harga = parseCurrency(row.find('input[name="harga[]"]').val()); // Mengambil angka murni
            var subTotal = parseFloat(harga) * parseFloat(qty);

            // Update tampilan subTotal tanpa koma desimal
            row.find('.amount').text(formatRupiah(subTotal));
            row.find('input[name="sub_total[]"]').val(subTotal); // Simpan subTotal dalam input tanpa desimal
        }

        function calculateTotal() {
            var total = 0;

            // Loop melalui setiap baris dan tambahkan subTotal
            $('table.item-table tbody tr').each(function() {
                var subTotal = parseCurrency($(this).find('input[name="sub_total[]"]').val());
                total += subTotal || 0; // Tambahkan nilai subTotal yang valid
            });

            // Update tampilan total di dalam elemen <span> dengan id #total-display
            $('#total-display').text(formatRupiah(total));

            // Update nilai total di dalam input hidden dengan id #total
            $('#total').val(total);
        }



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
        <td class="description">
            <select name="kode_barang[]" class="form-control form-control-sm kode_barang_select">
                <option value="">Pilih Barang</option>
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->kode_barang }}">
                        {{ $barang->nama_barang }}
                    </option>
                @endforeach
            </select>
             <textarea class="form-control" placeholder="Keterangan Tambahan" name="keterangan_tambahan[]"></textarea>
        </td>
        <td class="rate">
            <input type="text" class="form-control form-control-sm" placeholder="Harga" name="harga[]" readonly />
        </td>
        <td class="text-right qty">
            <input type="text" class="form-control form-control-sm" placeholder="Quantity" name="qty[]" />
        </td>
        <input type="hidden" name="sub_total[]" value="" />
        <td class="text-right">
            <select name="satuan[]" class="form-control form-control-sm satuan_select">
                <option value="">Pilih Satuan</option>
                @foreach ($satuans as $satuan)
                    <option value="{{ $satuan->satuan }}">
                        {{ $satuan->satuan }}</option>
                @endforeach
            </select>
        </td>
        <td class="text-right amount">
            <span class="currency">Rp</span>
            <span class="amount">0.00</span>
        </td>
    </tr>`;

            // Tambahkan baris baru ke tabel
            $('table.item-table tbody').append(newRow);

            // Inisialisasi Select2 pada dropdown yang baru ditambahkan
            $('select[name="kode_barang[]"]').last().select2({
                placeholder: "Pilih Barang",
                allowClear: true
            });
            $('.satuan_select').select2({
                placeholder: "Pilih Satuan",
                allowClear: true
            });
            $(document).on('click', '.delete-item', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
                calculateTotal();
            });
            // Jika Anda ingin menambahkan penanganan untuk perubahan barang yang baru ditambahkan
            $(document).on('change', 'select[name="kode_barang[]"]', function() {
                var kode_barang = $(this).val();
                var row = $(this).closest('tr');

                if (kode_barang) {
                    $.ajax({
                        url: '/get-barang/admin/' + kode_barang,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.barang && data.barang.harga !== undefined) {
                                row.find('input[name="harga[]"]').val(formatRupiah(data.barang
                                    .harga_beli));
                                row.find('select[name="satuan[]"]').val(data.satuan).change();
                                calculateTotalRow(row);
                                calculateTotal();
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('input[name="harga[]"]').val('');
                            row.find('select[name="satuan[]"]').val('');
                        }
                    });
                } else {
                    row.find('input[name="harga[]"]').val('');
                    row.find('select[name="satuan[]"]').val('');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_buat').value = today;
        });
    </script>
@endsection
