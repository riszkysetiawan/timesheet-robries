@extends('superadmin.partials.penjualan')
@section('title', 'Terima Inbond')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <form id="updateForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="invoice-content">
                                        <div class="invoice-detail-body">
                                            <div class="invoice-detail-title">
                                                <div class="invoice-title">
                                                    <input type="text" class="form-control" placeholder="Purchase Order"
                                                        value="Update Invoice Pembelian" readonly />
                                                </div>
                                            </div>

                                            <div class="invoice-detail-header">
                                                <div class="row justify-content-between">
                                                    <div class="col-xl-5 invoice-address-company">
                                                        <h4>From:-</h4>
                                                        <div class="invoice-address-company-fields">
                                                            <!-- Data Profil -->
                                                            <div class="form-group row">
                                                                <label for="company-name"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Nama</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-name" value="{{ $profile->nama_toko }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <!-- Kontak Email dan Alamat -->
                                                            <div class="form-group row">
                                                                <label for="company-email"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-email" value="{{ $profile->email }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="company-address"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-address" value="{{ $profile->alamat }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="company-phone"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">No
                                                                    Hp</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="company-phone" value="{{ $profile->no_hp }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="company-phone"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Status</label>
                                                                <div class="col-sm-9">
                                                                    <select name="status" id="status"
                                                                        class="form-control form-control-sm" required>
                                                                        <option value="">Status</option>
                                                                        <option value="Diterima">Diterima</option>
                                                                        <option value="Reject">Reject</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Ditujukan kepada -->
                                                    <div class="col-xl-5 invoice-address-client">
                                                        <h4>Ditujukan Kepada:-</h4>
                                                        <div class="invoice-address-client-fields">
                                                            <div class="form-group row">
                                                                <label for="client-name"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Nama
                                                                    Supplier</label>
                                                                <div class="col-sm-9">
                                                                    <select name="id_supplier" id="id_supplier"
                                                                        class="form-control form-control-sm" readonly>
                                                                        <option value="">Pilih Supplier</option>
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->id }}"
                                                                                {{ old('id_supplier', $purchaseOrder->id_supplier) == $supplier->id ? 'selected' : '' }}>
                                                                                {{ $supplier->nama_supplier }}
                                                                            </option>
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
                                                                        id="client-email"
                                                                        value="{{ old('email', $purchaseOrder->supplier->email) }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="client-address"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="client-address"
                                                                        value="{{ old('alamat', $purchaseOrder->supplier->alamat) }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="client-phone"
                                                                    class="col-sm-3 col-form-label col-form-label-sm">No
                                                                    Hp</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="client-phone"
                                                                        value="{{ old('no_hp', $purchaseOrder->supplier->no_telp) }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Invoice Details -->
                                            <div class="invoice-detail-terms">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="number">Invoice Number</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="number" name="kode_po"
                                                                value="{{ old('kode_po', $purchaseOrder->kode_po) }}"
                                                                readonly />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="tgl_buat">Tanggal Pembelian</label>
                                                            <input type="date" name="tgl_buat"
                                                                class="form-control form-control-sm" id="tgl_buat"
                                                                value="{{ old('tgl_buat', $purchaseOrder->tgl_buat) }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="eta">Tanggal Kedatangan</label>
                                                            <input type="date" name="tgl_kedatangan"
                                                                class="form-control form-control-sm" id="tgl_kedatangan"
                                                                value="{{ old('eta', $purchaseOrder->eta) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detail Items -->
                                            <div class="invoice-detail-items">
                                                <div class="table-responsive">
                                                    <div class="table-responsive">
                                                        <table class="table item-table">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Description</th>
                                                                    <th>Harga</th>
                                                                    <th>Qty PO</th>
                                                                    <th>Qty Actual</th>
                                                                    <th>Reject</th>
                                                                    <th>Final Qty</th>
                                                                    <th>Bukti Foto</th>
                                                                    <th>Satuan</th>
                                                                    <th class="text-right">Sub Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($purchaseOrder->details as $detail)
                                                                    <tr>
                                                                        <td class="delete-item-row">
                                                                            <ul class="table-controls">
                                                                                <li><a href="javascript:void(0);"
                                                                                        class="delete-item"
                                                                                        title="Delete">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                                            width="24" height="24"
                                                                                            viewBox="0 0 24 24"
                                                                                            fill="none"
                                                                                            stroke="currentColor"
                                                                                            stroke-width="2"
                                                                                            stroke-linecap="round"
                                                                                            stroke-linejoin="round"
                                                                                            class="feather feather-x-circle">
                                                                                            <circle cx="12"
                                                                                                cy="12" r="10">
                                                                                            </circle>
                                                                                            <line x1="15"
                                                                                                y1="9"
                                                                                                x2="9"
                                                                                                y2="15"></line>
                                                                                            <line x1="9"
                                                                                                y1="9"
                                                                                                x2="15"
                                                                                                y2="15"></line>
                                                                                        </svg>
                                                                                    </a></li>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="description">
                                                                            <select name="kode_barang[]"
                                                                                class="form-control form-control" readonly>
                                                                                <option value="">Pilih Barang
                                                                                </option>
                                                                                @foreach ($barangs as $barang)
                                                                                    <option
                                                                                        value="{{ $barang->kode_barang }}"
                                                                                        {{ old('kode_barang.' . $loop->index, $detail->kode_barang) == $barang->kode_barang ? 'selected' : '' }}>
                                                                                        {{ $barang->nama_barang }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <textarea class="form-control" placeholder="Keterangan Tambahan" name="keterangan[]"></textarea>
                                                                        </td>
                                                                        <td class="rate">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm harga-input"
                                                                                placeholder="Harga" name="harga[]"
                                                                                value="{{ old('harga.' . $loop->index, $detail->harga) }}"
                                                                                readonly />
                                                                        </td>
                                                                        <td class="text-right qty">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                placeholder="Quantity" name="qty[]"
                                                                                value="{{ old('qty.' . $loop->index, $detail->qty) }}"
                                                                                readonly />
                                                                        </td>
                                                                        <td class="text-right qty">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="qty_actual[]" />
                                                                        </td>
                                                                        <td class="text-right qty">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="reject[]" />
                                                                        </td>
                                                                        <td class="text-right qty">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                name="final_qty[]" />
                                                                        </td>
                                                                        <td class="text-right qty">
                                                                            <input type="file"
                                                                                class="form-control form-control-sm"
                                                                                name="gambar[]" />
                                                                        </td>

                                                                        <input type="hidden" name="sub_total[]"
                                                                            value="{{ old('sub_total.' . $loop->index, $detail->sub_total) }}" />
                                                                        <td class="text-right">
                                                                            <select name="satuan[]"
                                                                                class="form-control form-control-sm satuan_select">
                                                                                <option value="">Pilih Satuan
                                                                                </option>
                                                                                @foreach ($satuans as $satuan)
                                                                                    <option value="{{ $satuan->satuan }}"
                                                                                        {{ old('satuan.' . $loop->index, $detail->satuan) == $satuan->satuan ? 'selected' : '' }}>
                                                                                        {{ $satuan->satuan }}
                                                                                    </option>
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
                                                </div>
                                                {{-- <button class="btn btn-dark additem">Add Item</button> --}}
                                            </div>

                                            <!-- Total -->
                                            <div class="invoice-detail-total">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="totals-row">
                                                            <div class="invoice-totals-row invoice-summary-balance-due">
                                                                <div class="invoice">Total</div>
                                                                <div class="invoice-summary-value">
                                                                    <div class="balance-due-amount">
                                                                        <span class="currency"></span>
                                                                        <span class="amount" id="total-display">
                                                                            Rp{{ number_format(old('total', $purchaseOrder->total), 0, ',', '.') }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="balance-due-amount">
                                                                    <input type="hidden" id="total" name="total"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ number_format(old('total', $purchaseOrder->total), 0, ',', '.') }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invoice-detail-note">
                                                <div class="row">
                                                    <div class="col-md-12 align-self-center">
                                                        <div class="form-group row invoice-note">
                                                            <label for="invoice-detail-notes"
                                                                class="col-sm-12 col-form-label col-form-label-sm">Notes:</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="invoice-detail-notes"
                                                                    placeholder='Notes - For example, "Thank you for doing business with us"' style="height: 88px"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                {{-- <div class="col-xl-12 col-md-4">
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-secondary btn-preview">Preview</a>
                                                </div> --}}
                                                <div class="col-xl-12 col-md-4">
                                                    <button type="submit"
                                                        class="btn btn-outline-primary btn-rounded mb-2 me-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-save">
                                                            <path
                                                                d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                                            </path>
                                                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                            <polyline points="7 3 7 8 15 8"></polyline>
                                                        </svg>
                                                        Save</button>
                                                </div>
                                                <div class="col-xl-12 col-md-4 pt-2">
                                                    <button type="button"
                                                        class="btn btn-outline-dark btn-rounded mb-2 me-4"
                                                        onclick="window.location.href='{{ route('pembelian.admin.index') }}'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-arrow-left">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.harga-input').each(function() {
                    var hargaValue = parseCurrency($(this).val());
                    $(this).val(formatRupiah(hargaValue));
                });

                function parseCurrency(value) {
                    return value.replace(/[^\d]/g, "");
                }

                function formatRupiah(angka) {
                    let number_string = angka.toString(),
                        sisa = number_string.length % 3,
                        rupiah = number_string.substr(0, sisa),
                        ribuan = number_string.substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? "." : "";
                        rupiah += separator + ribuan.join(".");
                    }
                    return "Rp" + rupiah;
                }

                function calculateFinalQty(row) {
                    var qty_actual = parseFloat(row.find('input[name="qty_actual[]"]').val()) || 0;
                    var reject = parseFloat(row.find('input[name="reject[]"]').val()) || 0;
                    var final_qty = qty_actual - reject;
                    row.find('input[name="final_qty[]"]').val(final_qty); // Update final_qty
                }

                // Event listener on qty_actual[] and reject[] inputs
                $(document).on('input', 'input[name="qty_actual[]"], input[name="reject[]"]', function() {
                    var row = $(this).closest('tr'); // Get the closest row
                    calculateFinalQty(row); // Call the function to calculate and update final_qty
                });
                $('.satuan_select').select2({
                    placeholder: "Pilih Satuan",
                    allowClear: true
                });
                // Fetch Supplier Data
                $('#id_supplier').on('change', function() {
                    var supplierID = $(this).val();
                    if (supplierID) {
                        $.ajax({
                            url: '/get-supplier/' + supplierID,
                            type: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                if (data) {
                                    $('#client-email').val(data.email);
                                    $('#client-address').val(data.alamat);
                                    $('#client-phone').val(data.no_telp);
                                }
                            },
                            error: function(xhr) {
                                console.log('Error: ' + xhr.responseText);
                            }
                        });
                    } else {
                        $('#client-email').val('');
                        $('#client-address').val('');
                        $('#client-phone').val('');
                    }
                });

                // Format Currency to remove non-numeric characters
                function parseCurrency(value) {
                    return value.replace(/[^\d]/g, "");
                }

                // Format number into Rupiah
                function formatRupiah(angka) {
                    let number_string = angka.toString(),
                        sisa = number_string.length % 3,
                        rupiah = number_string.substr(0, sisa),
                        ribuan = number_string.substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? "." : "";
                        rupiah += separator + ribuan.join(".");
                    }
                    return "Rp" + rupiah;
                }


                // Update Subtotal and Total dynamically
                function calculateTotalRow(row) {
                    var qty = row.find('input[name="qty[]"]').val();
                    var harga = parseCurrency(row.find('input[name="harga[]"]').val());
                    var subTotal = parseFloat(harga) * parseFloat(qty);
                    row.find('.amount').text(formatRupiah(subTotal.toFixed(0)));
                    row.find('input[name="sub_total[]"]').val(subTotal.toFixed(0));
                }

                function calculateTotal() {
                    var total = 0;

                    // Loop melalui setiap baris dan tambahkan subTotal
                    $('table.item-table tbody tr').each(function() {
                        var subTotal = parseInt(parseCurrency($(this).find('input[name="sub_total[]"]').val()),
                            10);
                        total += subTotal || 0; // Tambahkan nilai subTotal yang valid
                    });

                    // Update tampilan total di dalam elemen <span> dengan id #total-display
                    $('#total-display').text(formatRupiah(total.toString()));

                    // Update nilai total di dalam input hidden dengan id #total
                    $('#total').val(total);
                }


                // Recalculate total and subtotal when quantity or price is changed
                $(document).on('input', 'input[name="qty[]"], input[name="harga[]"]', function() {
                    var row = $(this).closest('tr');
                    calculateTotalRow(row);
                    calculateTotal();
                });
                $(document).ready(function() {
                    $(document).ready(function() {
                        $('#updateForm').on('submit', function(e) {
                            e.preventDefault();
                            var formData = new FormData(this);

                            $.ajax({
                                url: "{{ route('inbond.admin.store') }}",
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    Swal.fire(
                                        'Berhasil!',
                                        response.message,
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href =
                                                '{{ route('inbond.admin.index') }}';
                                        }
                                    });
                                },
                                error: function(xhr) {
                                    // Mengecek apakah ada error validasi
                                    if (xhr.responseJSON && xhr.responseJSON
                                        .errors) {
                                        var errors = xhr.responseJSON.errors;
                                        var errorMessages = '';

                                        // Membuat pesan error untuk ditampilkan dalam SweetAlert
                                        $.each(errors, function(field, messages) {
                                            $.each(messages, function(index,
                                                message) {
                                                errorMessages +=
                                                    `<p><strong>${field}:</strong> ${message}</p>`;
                                            });
                                        });

                                        // Menampilkan error menggunakan SweetAlert
                                        Swal.fire({
                                            title: 'Gagal!',
                                            html: errorMessages, // Menampilkan error sebagai HTML
                                            icon: 'error'
                                        });
                                    } else if (xhr.responseJSON && xhr.responseJSON
                                        .message) {
                                        // Jika ada exception atau kesalahan lainnya
                                        Swal.fire('Gagal', xhr.responseJSON.message,
                                            'error');
                                    } else {
                                        Swal.fire('Gagal',
                                            'Terjadi kesalahan saat menyimpan data.',
                                            'error');
                                    }
                                }
                            });
                        });
                    });
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
                        <td class="description">
                            <select name="kode_barang[]" class="form-control form-control-sm">
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->kode_barang }}">
                                        {{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            <textarea class="form-control" placeholder="Keterangan Tambahan" name="keterangan_tambahan[]"></textarea>
                        </td>
                        <td class="rate">
                            <input type="text" class="form-control form-control-sm" placeholder="Harga" name="harga[]" />
                        </td>
                        <td class="text-right qty">
                            <input type="text" class="form-control form-control-sm" placeholder="Quantity" name="qty[]" />
                        </td>
                        <input type="hidden" name="sub_total[]" value="" />
                        <td class="text-right">
                            <select name="satuan[]" class="form-control form-control-sm">
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
                    $('table.item-table tbody').append(newRow);
                });

                // Delete item row
                $(document).on('click', '.delete-item', function(e) {
                    e.preventDefault();
                    $(this).closest('tr').remove();
                    calculateTotal(); // Hitung ulang total setelah menghapus baris
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
                                if (data) {
                                    row.find('input[name="harga[]"]').val(formatRupiah(
                                        data.harga_beli));
                                    calculateTotalRow(row);
                                    calculateTotal();
                                }
                            },
                            error: function(xhr, status, error) {
                                row.find('input[name="harga[]"]').val('');
                            }
                        });
                    } else {
                        row.find('input[name="harga[]"]').val('');
                    }
                });
            });
        </script>
    @endsection
