@extends('superadmin.partials.penjualan')
@section('title', 'Update Pembelian')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <form id="updateForm">
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
                                                                        class="form-control form-control-sm">
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
                                                            <label for="eta">Estimasi Kedatangan</label>
                                                            <input type="date" name="eta"
                                                                class="form-control form-control-sm" id="eta"
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
                                                                    <th>Qty</th>
                                                                    <th>Satuan</th>
                                                                    <th class="text-right">Sub Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($purchaseOrder->details as $detail)
                                                                    <tr>
                                                                        <td class="delete-item-row">
                                                                            <ul class="table-controls">
                                                                                <li>
                                                                                    <a href="javascript:void(0);"
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
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </td>
                                                                        <td class="description">
                                                                            <select name="kode_barang[]"
                                                                                class="form-control form-control-sm"
                                                                                id="kode_barang_select">
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
                                                                            <textarea class="form-control" placeholder="Keterangan Tambahan" name="keterangan_tambahan[]">{{ old('keterangan_tambahan.' . $loop->index, $detail->keterangan) }}</textarea>
                                                                        </td>
                                                                        <td class="rate">
                                                                            <input type="text"
                                                                                class="form-control form-control-sm"
                                                                                placeholder="Harga" name="harga[]"
                                                                                value="{{ old('harga.' . $loop->index, $detail->harga) }}"
                                                                                readonly />
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
                                                <button class="btn btn-dark additem">Add Item</button>
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
                                                                            {{ old('total', number_format($purchaseOrder->total, 0, ',', '.')) }}
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
                                                            <input type="hidden" name="status"
                                                                value="Belum Diterima" />
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
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-save">
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

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                var totalDisplayElement = $('#total-display');
                var currentValue = totalDisplayElement.text(); // Get the text inside the total display span

                if (currentValue) {
                    totalDisplayElement.text(formatRupiah(currentValue)); // Format to Rupiah
                }

                // Function to format the number to Rupiah
                function formatRupiah(angka) {
                    var number_string = angka.replace(/[^,\d]/g, ''), // Ensure it's numeric
                        sisa = number_string.length % 3,
                        rupiah = number_string.substr(0, sisa),
                        ribuan = number_string.substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        var separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    return rupiah ? 'Rp ' + rupiah : 'Rp 0';
                }
                $('input[name="harga[]"]').each(function() {
                    var currentValue = $(this).val(); // Get the value
                    if (currentValue) {
                        $(this).val(formatRupiah(currentValue)); // Format to Rupiah
                    }
                });

                // Format the prices dynamically when changing quantity or price
                $(document).on('input', 'input[name="harga[]"], input[name="qty[]"]', function() {
                    var row = $(this).closest('tr');
                    calculateTotalRow(row); // Recalculate the row total
                    calculateTotal(); // Recalculate the total invoice amount
                });

                function calculateTotalRow(row) {
                    var qty = parseFloat(row.find('input[name="qty[]"]').val()) || 0;
                    var harga = parseCurrency(row.find('input[name="harga[]"]').val()) || 0;
                    var subTotal = qty * harga;

                    // Set the formatted subtotal value
                    row.find('.amount').text(formatRupiah(subTotal.toString()));
                }

                // Function to remove non-numeric characters for currency parsing
                function parseCurrency(value) {
                    return parseFloat(value.replace(/[Rp\s.,]/g, '')) || 0;
                }

                // Recalculate the total amount of the invoice
                function calculateTotal() {
                    var total = 0;
                    $('table.item-table tbody tr').each(function() {
                        var subTotal = parseCurrency($(this).find('.amount').text());
                        total += subTotal;
                    });
                    $('#total-display').text(formatRupiah(total.toString()));
                    $('#total').val(total); // Set hidden field with unformatted value
                }

                // Function to format number as Rupiah
                function formatRupiah(angka) {
                    var number_string = angka.toString().replace(/[^,\d]/g, ''),
                        sisa = number_string.length % 3,
                        rupiah = number_string.substr(0, sisa),
                        ribuan = number_string.substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        var separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    return rupiah ? 'Rp ' + rupiah : 'Rp 0';
                }
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
                                    row.find('input[name="harga[]"]').val(formatRupiah(data
                                        .harga_beli));
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
                // Fetch Supplier Data
                $('#id_supplier').on('change', function() {
                    var supplierID = $(this).val();
                    if (supplierID) {
                        $.ajax({
                            url: '/get-supplier/admin/' + supplierID,
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
                    // Hapus semua karakter selain angka
                    return parseFloat(value.replace(/[^0-9]/g, '')) || 0;
                }


                // Format number into Rupiah
                function formatRupiah(angka) {
                    var number_string = angka.toString().replace(/[^,\d]/g, ""),
                        sisa = number_string.length % 3,
                        rupiah = number_string.substr(0, sisa),
                        ribuan = number_string.substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? "." : "";
                        rupiah += separator + ribuan.join(".");
                    }

                    return rupiah ? "Rp" + rupiah : "Rp0";
                }


                // Update Subtotal and Total dynamically
                function calculateTotalRow(row) {
                    var qty = row.find('input[name="qty[]"]').val(); // Ambil quantity
                    var harga = parseCurrency(row.find('input[name="harga[]"]').val()); // Ambil harga, hapus format
                    var subTotal = parseFloat(harga) * parseFloat(qty); // Hitung subtotal

                    // Update subtotal dalam tampilan dan input tersembunyi
                    row.find('.amount').text(formatRupiah(subTotal.toFixed(0))); // Format ke rupiah dan update tampilan
                    row.find('input[name="sub_total[]"]').val(subTotal.toFixed(0)); // Simpan nilai tanpa format
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

                // Recalculate total and subtotal when quantity or price is changed
                $(document).on('input', 'input[name="qty[]"], input[name="harga[]"]', function() {
                    var row = $(this).closest('tr');
                    calculateTotalRow(row);
                    calculateTotal();
                });

                // Handle Form Submission
                $('#updateForm').on('submit', function(e) {
                    e.preventDefault();

                    $('input[name="harga[]"]').each(function() {
                        var harga = $(this).val();
                        $(this).val(parseCurrency(harga));
                    });

                    $('input[name="sub_total[]"]').each(function() {
                        var sub_total = $(this).val();
                        $(this).val(parseCurrency(sub_total));
                    });

                    var total = $('#total').val();
                    $('#total').val(parseCurrency(total));
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "{{ route('pembelian.superadmin.update', Crypt::encryptString($purchaseOrder->id)) }}",
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
                                        $('#updateForm')[0].reset();
                                        window.location.href =
                                            '{{ route('pembelian.admin.index') }}';
                                    }
                                });
                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = '';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorMessage += value + '\n';
                                });
                            } else {
                                errorMessage = 'Failed to update data: ' + xhr.status + ' - ' + xhr
                                    .statusText;
                            }
                            Swal.fire('Error!', errorMessage, 'error');
                        }
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
                                            data.barang.harga_beli
                                        ));
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

                // Update harga when selecting barang
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
                                    row.find('input[name="harga[]"]').val(formatRupiah(data
                                        .harga_beli));
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
