@extends('superadmin.partials.penjualan')
@section('title', 'Update Penjualan')
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
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Nama
                                                                    Kasir</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" id="nama_kasir"
                                                                        placeholder="Nama Kasir" name="nama_kasir"
                                                                        value="{{ Auth::user()->nama }}" readonly />
                                                                </div>
                                                            </div>
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
                                                </div>
                                            </div>

                                            <div class="invoice-detail-terms">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="number">Invoice Number</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="kode_invoice" name="kode_invoice"
                                                                value="{{ old('kode_invoice', $penjualans->kode_invoice) }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="tgl_buat">Tanggal Pembelian</label>
                                                            <input type="date" name="tgl_buat"
                                                                class="form-control form-control-sm" id="tgl_buat"
                                                                value="{{ old('tgl_buat', $penjualans->tgl_buat) }}">
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
                                                                <th>Barcode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Satuan</th>
                                                                <th class="text-right">Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($penjualans->detailPenjualans as $detail)
                                                                <tr>
                                                                    <td class="delete-item-row">
                                                                        <ul class="table-controls">
                                                                            <li><a href="javascript:void(0);"
                                                                                    class="delete-item" title="Delete">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="feather feather-x-circle">
                                                                                        <circle cx="12"
                                                                                            cy="12" r="10"></circle>
                                                                                        <line x1="15"
                                                                                            y1="9" x2="9"
                                                                                            y2="15"></line>
                                                                                        <line x1="9"
                                                                                            y1="9" x2="15"
                                                                                            y2="15"></line>
                                                                                    </svg>
                                                                                </a></li>
                                                                        </ul>
                                                                    </td>
                                                                    <td class="rate">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="kode_barcode"
                                                                            name="kode_barcode[]" id="kode_barcode[]" />
                                                                    </td>
                                                                    <td class="description">
                                                                        <select name="kode_barang[]"
                                                                            class="form-control form-control-sm kode_barang_select">
                                                                            <option value="">Pilih Barang</option>
                                                                            @foreach ($barangs as $barang)
                                                                                <option value="{{ $barang->kode_barang }}"
                                                                                    {{ old('kode_barang.' . $loop->index, $detail->kode_barang) == $barang->kode_barang ? 'selected' : '' }}>
                                                                                    {{ $barang->nama_barang }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="rate">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm" readonly
                                                                            placeholder="Harga" name="harga[]"
                                                                            value="{{ old('harga.' . $loop->index, $detail->harga) }}" />
                                                                    </td>
                                                                    <td class="text-right qty">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="Quantity" name="qty[]"
                                                                            value="{{ old('qty.' . $loop->index, $detail->qty) }}" />
                                                                    </td>
                                                                    <input type="hidden" name="sub_total[]"
                                                                        value="{{ old('sub_total.' . $loop->index, $detail->sub_total) }}" />
                                                                    <td class="text-right">
                                                                        <select name="satuan[]"
                                                                            class="form-control form-control-sm satuan_select">
                                                                            <option value="">Pilih Satuan</option>
                                                                            @foreach ($satuans as $satuan)
                                                                                <option value="{{ $satuan->satuan }}"
                                                                                    {{ old('satuan.' . $loop->index, $detail->satuan) == $satuan->satuan ? 'selected' : '' }}>
                                                                                    {{ $satuan->satuan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-right amount">
                                                                        <span class="currency">Rp</span>
                                                                        <span
                                                                            class="amount">{{ number_format(old('sub_total.' . $loop->index, $detail->sub_total), 0, ',', '.') }}</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn btn-dark additem">Add Item</button>
                                            </div>

                                            <div class="invoice-detail-total">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row invoice-created-by">
                                                            <label for="payment-method-bank-name"
                                                                class="col-sm-3 col-form-label col-form-label-sm">Jumlah
                                                                Pembayaran:</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="jumlah_pembayaran" name="jumlah_pembayaran"
                                                                    placeholder="Jumlah Uang Pembeli"
                                                                    value="{{ old('jumlah_bayar', number_format($penjualans->jumlah_bayar, 0, ',', '.')) }}" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row invoice-created-by">
                                                            <label for="payment-method-bank-name"
                                                                class="col-sm-3 col-form-label col-form-label-sm">Jumlah
                                                                Kembalian:</label>
                                                            <div class="col-sm-9">
                                                                <span class="kembalian"></span>
                                                                <span class="amount"
                                                                    id="kembalian">{{ old('jumlah_kembalian', number_format($penjualans->kembali, 0, ',', '.')) }}</span>
                                                                <input type="hidden" class="form-control form-control-sm"
                                                                    id="jumlah_kembalian" name="jumlah_kembalian"
                                                                    value="{{ old('kembali', $penjualans->kembali) }}" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="totals-row">
                                                            <div class="invoice-totals-row invoice-summary-balance-due">
                                                                <div class="invoice">Total</div>
                                                                <div class="invoice-summary-value">
                                                                    <!-- Tampilkan nilai old di dalam elemen <span> -->
                                                                    <div class="balance-due-amount">
                                                                        <span class="currency"></span>
                                                                        <span class="amount"
                                                                            id="total-display">{{ old('total', $penjualans->total) }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="balance-due-amount">
                                                                    <input type="hidden" id="total" name="total"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ old('total', number_format($penjualans->total, 0)) }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 col-md-4">
                                                        <button type="submit"
                                                            class="btn btn-outline-success btn-rounded mb-2 me-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-save">
                                                                <path
                                                                    d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                                                </path>
                                                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                                <polyline points="7 3 7 8 15 8"></polyline>
                                                            </svg>Simpan</button>
                                                    </div>
                                                    <div class="col-xl-12 col-md-4 pt-2">
                                                        <button type="button"
                                                            class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                                            onclick="window.location.href='{{ route('penjualan.admin.index') }}'">
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
            $('#jumlah_pembayaran').val(formatRupiah($('#jumlah_pembayaran').val()));
            $('#jumlah_pembayaran').on('input', function() {
                calculateKembalian();
            });

            function calculateKembalian() {
                var jumlahPembayaran = parseCurrency($('#jumlah_pembayaran').val());
                var total = parseCurrency($('#total').val());
                var kembalian = jumlahPembayaran - total;

                // Set hasil kembalian ke elemen yang menampilkan kembalian dalam format rupiah
                if (kembalian >= 0) {
                    $('#kembalian').text(formatRupiah(kembalian));
                    $('#jumlah_kembalian').val(kembalian); // Set nilai asli untuk input hidden
                } else {
                    $('#kembalian').text(formatRupiah(0));
                    $('#jumlah_kembalian').val(0); // Reset jika kurang dari total
                }
            }
            $('#jumlah_pembayaran').on('input', function() {
                var input = $(this).val();
                $(this).val(formatRupiah(input));
            });

            // Saat halaman dimuat, langsung format nilai qty dan harga
            $('table.item-table tbody tr').each(function() {
                var row = $(this);

                // Pastikan harga dan qty diformat ulang
                var harga = row.find('input[name="harga[]"]').val();
                if (harga) {
                    row.find('input[name="harga[]"]').val(formatRupiah(parseCurrency(harga)));
                }

                // Hitung ulang subtotal berdasarkan qty dan harga
                calculateTotalRow(row);
            });

            // Hitung total saat halaman pertama kali dimuat
            calculateTotal();

            // Initialize Select2 on all dropdowns with class 'kode_barang_select'
            $('.kode_barang_select').select2({
                placeholder: "Pilih Barang",
                allowClear: true
            });
            $('.satuan_select').select2({
                placeholder: "Pilih Satuan",
                allowClear: true
            });

            // Optionally, you can handle the change event here to update price when a barang is selected
            $(document).on('change', 'select[name="kode_barang[]"]', function() {
                var kode_barang = $(this).val();
                var row = $(this).closest('tr');

                if (kode_barang) {
                    // Panggil API untuk mendapatkan informasi barang (harga dan satuan)
                    $.ajax({
                        url: '/get-barang/admin/' +
                            kode_barang, // Ganti URL dengan route yang sesuai
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data && data.barang) {
                                // Set nilai harga ke input harga pada baris yang sama
                                row.find('input[name="harga[]"]').val(formatRupiah(data.barang
                                    .harga));

                                // Jika ada satuan, update dropdown satuan
                                row.find('select[name="satuan[]"]').val(data.satuan).change();

                                // Hitung ulang subtotal dan total
                                calculateTotalRow(row);
                                calculateTotal();
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('input[name="harga[]"]').val(
                                ''); // Reset harga jika terjadi kesalahan
                            row.find('select[name="satuan[]"]').val(
                                ''); // Kosongkan satuan jika error
                        }
                    });
                } else {
                    // Reset harga dan satuan jika tidak ada barang yang dipilih
                    row.find('input[name="harga[]"]').val('');
                    row.find('select[name="satuan[]"]').val('');
                }
            });

            $(document).on('input', 'input[name="kode_barcode[]"]', function() {
                var barcode = $(this).val();
                var row = $(this).closest('tr');

                if (barcode) {
                    $.ajax({
                        url: '/get-barang-by-barcode/admin/' +
                            barcode, // Ganti URL dengan route yang sesuai
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                // Set nilai harga ke input harga pada baris yang sama
                                row.find('input[name="harga[]"]').val(formatRupiah(data.harga));
                                row.find('select[name="kode_barang[]"]').val(data.kode_barang)
                                    .change();
                                row.find('select[name="satuan[]"]').val(data.satuan)
                                    .change();
                                // Set kode_barang jika perlu
                                calculateTotalRow(row); // Hitung total untuk baris
                                calculateTotal(); // Hitung total keseluruhan
                            } else {
                                // Jika tidak ada data ditemukan, reset harga
                                row.find('input[name="harga[]"]').val('');
                                row.find('select[name="satuan[]"]').val(
                                    '');
                            }
                        },
                        error: function(xhr, status, error) {
                            row.find('input[name="harga[]"]').val('');
                            row.find('select[name="satuan[]"]').val(
                                '');
                        }
                    });
                } else {
                    // Kosongkan harga jika barcode tidak ada
                    row.find('input[name="harga[]"]').val('');
                    row.find('select[name="satuan[]"]').val(
                        '');
                }
            });
            // Function to format price to Rupiah
            // function formatRupiah(angka) {
            //     var number_string = angka.toString().replace(/[^,\d]/g, ""),
            //         sisa = number_string.length % 3,
            //         rupiah = number_string.substr(0, sisa),
            //         ribuan = number_string.substr(sisa).match(/\d{3}/gi);

            //     if (ribuan) {
            //         separator = sisa ? "." : "";
            //         rupiah += separator + ribuan.join(".");
            //     }

            //     return rupiah ? "Rp " + rupiah : "Rp 0";
            // }

            function formatRupiah(angka, prefix = "Rp") {
                var number_string = angka.toString().replace(/[^,\d]/g, ""),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }
                return prefix + rupiah;
            }

            // function parseCurrency(value) {
            //     // Menghapus semua karakter selain angka dan koma, mengganti koma dengan titik
            //     return parseFloat(value.replace(/[Rp\s.]/g, '').replace(',', '.')) || 0;
            // }

            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9]/g, '')) || 0;
            }

            // Recalculate the total row when quantity or price is changed
            $(document).on('input', 'input[name="qty[]"], input[name="harga[]"]', function() {
                var row = $(this).closest('tr');
                calculateTotalRow(row);
                calculateTotal();
                calculateKembalian();
            });

            // Add new item row
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
                    <td class="rate">
                        <input type="text" class="form-control form-control-sm" placeholder="kode_barcode" name="kode_barcode[]" />
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

                // Append new row
                $('table.item-table tbody').append(newRow);

                // Initialize Select2 for the newly added select element
                $('select[name="kode_barang[]"]').last().select2({
                    placeholder: "Pilih Barang",
                    allowClear: true
                });

                $('.satuan_select').select2({
                    placeholder: "Pilih Satuan",
                    allowClear: true
                });


                $(document).on('change', 'select[name="kode_barang[]"]', function() {
                    var kode_barang = $(this).val();
                    var row = $(this).closest('tr');

                    if (kode_barang) {
                        $.ajax({
                            url: '/get-barang/admin/' + kode_barang,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                if (data && data.barang && data.barang.harga !==
                                    undefined) {
                                    row.find('input[name="harga[]"]').val(formatRupiah(
                                        data.barang
                                        .harga));
                                    row.find('select[name="satuan[]"]').val(data.satuan)
                                        .change();
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

            // Delete item row
            $(document).on('click', '.delete-item', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
                calculateTotal();
            });

            // Fungsi untuk menghitung subtotal pada tiap baris
            function calculateTotalRow(row) {
                var qty = parseFloat(row.find('input[name="qty[]"]').val()) || 0;
                var harga = parseCurrency(row.find('input[name="harga[]"]').val());
                var subTotal = harga * qty;

                row.find('.amount').text(formatRupiah(subTotal));
                row.find('input[name="sub_total[]"]').val(subTotal);
            }


            // Fungsi untuk menghitung total invoice
            // Fungsi untuk menghitung total invoice
            function calculateTotal() {
                var total = 0;

                // Hitung subtotal dari semua item
                $('table.item-table tbody tr').each(function() {
                    var subTotal = parseCurrency($(this).find('input[name="sub_total[]"]').val());
                    total += subTotal || 0;
                });

                // Update tampilan total
                $('#total-display').text(formatRupiah(total));
                $('#total').val(total); // Set nilai asli di input hidden

                calculateKembalian(); // Hitung ulang kembalian setelah total diperbarui
            }


            $('#submitForm').on('submit', function(e) {
                e.preventDefault();

                // Format harga menjadi angka murni sebelum dikirim
                $('input[name="harga[]"]').each(function() {
                    var harga = $(this).val();
                    $(this).val(parseCurrency(harga));
                });

                // Format jumlah pembayaran dan total menjadi angka murni sebelum dikirim
                var jumlahPembayaran = parseCurrency($('#jumlah_pembayaran').val());
                $('#jumlah_pembayaran').val(jumlahPembayaran);

                var jumlahKembalian = parseCurrency($('#jumlah_kembalian').val());
                $('#jumlah_kembalian').val(jumlahKembalian);

                var total = $('#total').val();
                $('#total').val(parseCurrency(total));

                // Serialisasi data form
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('penjualan.superadmin.update', Crypt::encryptString($penjualans->kode_invoice)) }}",
                    type: 'PUT',
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
                                    // Tanyakan apakah ingin mencetak nota
                                    Swal.fire({
                                        title: 'Cetak Nota?',
                                        text: "Apakah Anda ingin mencetak nota?",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonText: 'Ya',
                                        cancelButtonText: 'Tidak'
                                    }).then((printResult) => {
                                        if (printResult.isConfirmed) {
                                            // Buka jendela popup dan cetak
                                            var printWindow = window.open(
                                                response.print_url,
                                                '_blank',
                                                'width=800,height=600');
                                            printWindow.onload = function() {
                                                printWindow.print();
                                                printWindow.onafterprint =
                                                    function() {
                                                        printWindow
                                                            .close(); // Tutup jendela popup setelah print selesai
                                                        window.location
                                                            .href =
                                                            '{{ route('penjualan.admin.index') }}';
                                                    };
                                            };
                                        } else {
                                            // Jika memilih "Tidak", arahkan ke halaman index
                                            window.location.href =
                                                '{{ route('penjualan.admin.index') }}';
                                        }
                                    });
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

            // Fungsi untuk membersihkan format rupiah menjadi angka murni
            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9]/g, '')) || 0;
            }
            // Submit form with AJAX
            // $('#submitForm').on('submit', function(e) {
            //     e.preventDefault();

            //     $('input[name="harga[]"]').each(function() {
            //         var harga = $(this).val();
            //         $(this).val(parseCurrency(harga));
            //     });

            //     var total = $('#total').val();
            //     $('#total').val(parseCurrency(total));

            //     var formData = $(this).serialize();

            //     $.ajax({
            //         url: "{{ route('penjualan.superadmin.update', Crypt::encryptString($penjualans->kode_invoice)) }}",
            //         type: 'PUT',
            //         data: formData,
            //         success: function(response) {
            //             if (response.status === 'success') {
            //                 Swal.fire({
            //                     title: 'Berhasil!',
            //                     text: response.message,
            //                     icon: 'success',
            //                     confirmButtonText: 'OK'
            //                 }).then((result) => {
            //                     if (result.isConfirmed) {
            //                         $('#submitForm')[0].reset();
            //                         window.location.href =
            //                             '{{ route('penjualan.admin.index') }}';
            //                     }
            //                 });
            //             }
            //         },
            //         error: function(xhr) {
            //             if (xhr.status === 422) {
            //                 var errors = xhr.responseJSON.errors;
            //                 var errorMessage = '';
            //                 $.each(errors, function(key, value) {
            //                     errorMessage += value + '\n';
            //                 });
            //                 Swal.fire('Error!', errorMessage, 'error');
            //             } else {
            //                 Swal.fire('Error!', xhr.responseJSON.message, 'error');
            //             }
            //         }
            //     });
            // });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_buat').value = today;
        });
    </script>
@endsection
