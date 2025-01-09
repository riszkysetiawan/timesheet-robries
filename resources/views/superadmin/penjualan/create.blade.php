@extends('superadmin.partials.penjualan')
@section('title', 'Tambah Produk')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <div class="row">
                            <div class="col-xl-12">
                                <form action="" id="formPenjualan">
                                    @csrf
                                    <div class="invoice-content">
                                        <div class="invoice-detail-body">
                                            <div class="invoice-detail-terms">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="number">SO Number</label>
                                                            <input type="text" name="so_number" id="so_number"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="date">Nama Customer</label>
                                                            <input type="text" name="nama_customer" id="nama_customer"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group mb-4">
                                                            <label for="date">Shipping</label>
                                                            <input type="date" name="shipping" id="shipping"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="invoice-detail-items">
                                                <div class="table-responsive">
                                                    <table class="table item-table">
                                                        <thead>
                                                            <tr>
                                                                <th class=""></th>
                                                                <th>Pesanan</th>
                                                                <th class="">Qty</th>
                                                                <th class="">Deskripsi</th>
                                                            </tr>
                                                            <tr aria-hidden="true" class="mt-3 d-block table-row-hidden">
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="delete-item-row">
                                                                    <ul class="table-controls">
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                                class="delete-item" data-toggle="tooltip"
                                                                                data-placement="top" title=""
                                                                                data-original-title="Delete"><svg
                                                                                    xmlns="http://www.w3.org/2000/svg"
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
                                                                                </svg></a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                                <td class="description">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Pesanan" name="pesanan[]"
                                                                        id="pesanan[]" />
                                                                    <textarea class="form-control" placeholder="Additional Details"></textarea>
                                                                </td>
                                                                <td class="rate">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="qty" name="qty[]" id="qty[]" />
                                                                </td>
                                                                <td class="text-right qty">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="deskripsi" name="deskripsi[]"
                                                                        id="deskripsi[]" />
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <button class="btn btn-dark additem">
                                                    Add Item
                                                </button>
                                            </div>
                                            <div class="invoice-detail-note">
                                                <div class="row">
                                                    <div class="col-md-12 align-self-center">
                                                        <div class="form-group row invoice-note">
                                                            <label for="invoice-detail-notes"
                                                                class="col-sm-12 col-form-label col-form-label-sm">Notes:</label>
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" id="invoice-detail-notes"
                                                                    placeholder='Notes - For example, "Thank you for doing business with us"' name="catatan" id="catatan"
                                                                    style="height: 88px"></textarea>
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
    <!-- Include jQuery if you haven't already -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
