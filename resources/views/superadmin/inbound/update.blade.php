@extends('superadmin.partials.penjualan')
@section('title', 'Update Inbond')
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
                                                                        id="company-phone" value="{{ $profile->no_telp }}"
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
                                                                        class="form-control form-control-sm" readonly>
                                                                        <option value="">Pilih Supplier</option>
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->id }}"
                                                                                {{ old('id_supplier', $inbond->id_supplier) == $supplier->id ? 'selected' : '' }}>
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
                                                                        value="{{ old('email', $inbond->supplier->email) }}"
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
                                                                        value="{{ old('alamat', $inbond->supplier->alamat) }}"
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
                                                                        value="{{ old('no_hp', $inbond->supplier->no_telp) }}"
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
                                                                value="{{ old('kode_po', $inbond->kode_po) }}" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="eta">Estimasi Kedatangan</label>
                                                            <input type="date" name="eta"
                                                                class="form-control form-control-sm" id="eta"
                                                                value="{{ old('eta', $inbond->eta) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detail Items -->
                                            <div class="invoice-detail-items">
                                                <div class="table-responsive">
                                                    <table class="table item-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Qty PO</th>
                                                                <th>Qty Actual</th>
                                                                <th>Reject</th>
                                                                <th>Final Qty</th>
                                                                <th>Gambar</th>
                                                                <th>Tanggal Exp</th>
                                                                <th>Satuan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($inbond->details as $detail)
                                                                <tr>
                                                                    <td class="description">
                                                                        <select name="kode_barang[]"
                                                                            class="form-control form-control-sm">
                                                                            @foreach ($barangs as $barang)
                                                                                <option value="{{ $barang->kode_barang }}"
                                                                                    {{ old('kode_barang.' . $loop->index, $detail->kode_barang) == $barang->kode_barang ? 'selected' : '' }}>
                                                                                    {{ $barang->nama_barang }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <textarea class="form-control" placeholder="Keterangan Tambahan" name="keterangan[]">{{ old('keterangan_tambahan.' . $loop->index, $detail->keterangan) }}</textarea>
                                                                    </td>
                                                                    <td><input type="text" name="qty_po[]"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ old('qty_po.' . $loop->index, $detail->qty_po) }}"
                                                                            readonly></td>
                                                                    <td><input type="text" name="qty_actual[]"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ old('qty_actual.' . $loop->index, $detail->qty_actual) }}">
                                                                    </td>
                                                                    <td><input type="text" name="reject[]"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ old('reject.' . $loop->index, $detail->reject) }}">
                                                                    </td>
                                                                    <td><input type="text" name="final_qty[]"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ old('final_qty.' . $loop->index, $detail->final_qty) }}">
                                                                    </td>
                                                                    <td class="description">
                                                                        <input type="file" name="gambar[]"
                                                                            class="form-control form-control-sm" multiple>

                                                                        @if (isset($detail->gambar))
                                                                            <!-- Gambar clickable -->
                                                                            <a href="#" data-bs-toggle="modal"
                                                                                data-bs-target="#imagePreviewModal-{{ $loop->index }}">
                                                                                <img src="{{ asset('storage/' . $detail->gambar) }}"
                                                                                    class="image-preview"
                                                                                    style="max-width: 100px; display: block; margin-top: 10px; cursor: pointer;">
                                                                            </a>

                                                                            <!-- Bootstrap Modal -->
                                                                            <div class="modal fade"
                                                                                id="imagePreviewModal-{{ $loop->index }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="imagePreviewModalLabel"
                                                                                aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="imagePreviewModalLabel">
                                                                                                Pratinjau Gambar</h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="modal-body text-center">
                                                                                            <img src="{{ asset('storage/' . $detail->gambar) }}"
                                                                                                style="max-width: 100%; height: auto;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td><input type="date" name="exp[]"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ old('exp.' . $loop->index, $detail->exp) }}">
                                                                    </td>
                                                                    <td>
                                                                        <select name="satuan[]"
                                                                            class="form-control form-control-sm satuan_select">
                                                                            @foreach ($satuans as $satuan)
                                                                                <option value="{{ $satuan->satuan }}"
                                                                                    {{ old('satuan.' . $loop->index, $detail->satuan) == $satuan->satuan ? 'selected' : '' }}>
                                                                                    {{ $satuan->satuan }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
                                                                    placeholder='Notes - For example, "Thank you for doing business with us"' style="height: 88px" name="catatan">{{ old('catatan', $inbond->catatan) }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
                $('input[type="file"]').on('change', function(event) {
                    let input = event.target;
                    let row = $(this).closest('tr');

                    if (input.files && input.files[0]) {
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            row.find('.image-preview').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                });

                function calculateFinalQty(row) {
                    var qty_actual = parseFloat(row.find('input[name="qty_actual[]"]').val()) || 0;
                    var reject = parseFloat(row.find('input[name="reject[]"]').val()) || 0;
                    var final_qty = qty_actual - reject;
                    row.find('input[name="final_qty[]"]').val(final_qty); // Set the calculated final_qty
                }

                // Event listener on qty_actual[] and reject[] inputs to recalculate final_qty
                $(document).on('input', 'input[name="qty_actual[]"], input[name="reject[]"]', function() {
                    var row = $(this).closest('tr'); // Get the current row
                    calculateFinalQty(row); // Calculate and set final_qty for the current row
                });

                $('.satuan_select').select2({
                    placeholder: "Pilih Satuan",
                    allowClear: true
                });

                $('#updateForm').on('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('inbound.admin.update', Crypt::encryptString($inbond->kode_po)) }}",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('inbound.admin.index') }}';
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Terjadi kesalahan, coba lagi.', 'error');
                        }
                    });
                });
            });
        </script>
    @endsection
