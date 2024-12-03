@extends('superadmin.partials.penjualan')
@section('title', 'Terima Pembelian')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="invoice-content">
                                    <div class="invoice-detail-body">
                                        <div class="invoice-detail-title">

                                            <div class="invoice-title">
                                                <input type="text" class="form-control" placeholder="Invoice Pembelian"
                                                    value="Invoice Pembelian" />
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
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="company-name" placeholder="Business Name" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="company-email"
                                                                class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="company-email" placeholder="name@company.com" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="company-address"
                                                                class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="company-address" placeholder="XYZ Street" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="company-phone"
                                                                class="col-sm-3 col-form-label col-form-label-sm">No
                                                                Hp</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="company-phone" placeholder="(123) 456 789" />
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
                                                                <select name="" id=""
                                                                    class="form-control form-control-sm">
                                                                    <option value="">Pilih Supplier</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="client-email"
                                                                class="col-sm-3 col-form-label col-form-label-sm">Email</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="client-email" placeholder="name@company.com" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="client-address"
                                                                class="col-sm-3 col-form-label col-form-label-sm">Alamat</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="client-address" placeholder="XYZ Street" />
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="client-phone"
                                                                class="col-sm-3 col-form-label col-form-label-sm">No
                                                                Hp</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="client-phone" placeholder="(123) 456 789" />
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
                                                            id="number" placeholder="#0001" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group mb-4">
                                                        <label for="date">Invoice Date</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="date" placeholder="Add date picker" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group mb-4">
                                                        <label for="due">Due Date</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="due" placeholder="None" />
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
                                                            <th>Description</th>
                                                            <th class="">Harga</th>
                                                            <th class="">Qty PO</th>
                                                            <th class="">Qty Actual</th>
                                                            <th class="text-right">Jumlah</th>
                                                        </tr>
                                                        <tr aria-hidden="true" class="mt-3 d-block table-row-hidden"></tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="delete-item-row">
                                                                <ul class="table-controls">
                                                                    <li>
                                                                        <a href="javascript:void(0);" class="delete-item"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title=""
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
                                                                                    x2="9" y2="15"></line>
                                                                                <line x1="9" y1="9"
                                                                                    x2="15" y2="15"></line>
                                                                            </svg></a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            <td class="description">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Item Description" />
                                                                <textarea class="form-control" placeholder="Additional Details"></textarea>
                                                            </td>
                                                            <td class="rate">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Price" />
                                                            </td>
                                                            <td class="text-right qty">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Quantity" />
                                                            </td>
                                                            <td class="text-right qty">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Quantity" />
                                                            </td>
                                                            <td class="text-right amount">
                                                                <span class="editable-amount"><span
                                                                        class="currency">$</span>
                                                                    <span class="amount">100.00</span></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="invoice-detail-total">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="totals-row">
                                                        <div class="invoice-totals-row invoice-summary-balance-due">
                                                            <div class="invoice">
                                                                Total
                                                            </div>

                                                            <div class="invoice-summary-value">
                                                                <div class="balance-due-amount">
                                                                    <span class="currency">$</span><span>0.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3">
                                <div class="invoice-actions-btn">
                                    <div class="invoice-action-btn">
                                        <div class="row">
                                            {{-- <div class="col-xl-12 col-md-4">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-send">Send
                                                    Invoice</a>
                                            </div> --}}
                                            {{-- <div class="col-xl-12 col-md-4">
                                                <a href="./app-invoice-preview.html"
                                                    class="btn btn-secondary btn-preview">Preview</a>
                                            </div> --}}
                                            <div class="col-xl-12 col-md-4">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-success btn-download">Save</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
