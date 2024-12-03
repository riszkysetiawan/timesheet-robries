@extends('superadmin.partials.detail')
@section('title', 'Detail Inbond')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row invoice layout-top-spacing layout-spacing">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="doc-container">
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="invoice-container">
                                    <div class="invoice-inbox">
                                        <div id="ct" class="">
                                            <div class="invoice-00001">
                                                <div class="content-section">
                                                    <div class="inv--head-section inv--detail-section">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-12 mr-auto">
                                                                {{-- <div class="d-flex">
                                                                    <img class="company-logo"
                                                                        src="../src/assets/img/cork-logo.png"
                                                                        alt="company" />
                                                                    <h3 class="in-heading align-self-center">
                                                                        Cork Inc.
                                                                    </h3>
                                                                </div> --}}
                                                                <p class="inv-street-addr mt-3">
                                                                    {{ $profile->alamat }}
                                                                </p>
                                                                <p class="inv-email-address">
                                                                    {{ $profile->email }}
                                                                </p>
                                                                <p class="inv-email-address">
                                                                    {{ $profile->no_telp }}
                                                                </p>
                                                            </div>

                                                            <div class="col-sm-6 text-sm-end">
                                                                <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4">
                                                                    <span class="inv-title">Invoice :
                                                                    </span>
                                                                    <span
                                                                        class="inv-number">{{ $purchaseOrder->kode_po }}</span>
                                                                </p>
                                                                <p class="inv-created-date mt-sm-5 mt-3">
                                                                    <span class="inv-title">Tanggal Pembuatan :
                                                                    </span>
                                                                    <span
                                                                        class="inv-date">{{ $purchaseOrder->tgl_buat }}</span>
                                                                </p>
                                                                <p class="inv-due-date">
                                                                    <span class="inv-title">Estimasi Kedatangan :
                                                                    </span>
                                                                    <span class="inv-date">{{ $purchaseOrder->eta }}</span>
                                                                </p>
                                                                <p class="inv-due-date">
                                                                    <span class="inv-title">Status :
                                                                    </span>
                                                                    <span
                                                                        class="inv-date">{{ $pembelian->status ?? '' }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="inv--detail-section inv--customer-detail-section">
                                                        <div class="row">
                                                            <div
                                                                class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                                <p class="inv-to">Invoice To</p>
                                                            </div>

                                                            <div
                                                                class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 text-sm-end mt-sm-0 mt-5">
                                                                <h6 class="inv-title">
                                                                    {{ $purchaseOrder->supplier->nama_supplier }}</h6>
                                                            </div>

                                                            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                                <p class="inv-customer-name">
                                                                    {{ $purchaseOrder->supplier->nama_supplier }}
                                                                </p>
                                                                <p class="inv-street-addr">
                                                                    {{ $purchaseOrder->supplier->alamat }}
                                                                </p>
                                                                <p class="inv-email-address">
                                                                    {{ $purchaseOrder->supplier->email }}
                                                                </p>
                                                                <p class="inv-email-address">
                                                                    {{ $purchaseOrder->supplier->alamat }}
                                                                </p>
                                                            </div>

                                                            <div
                                                                class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1 text-sm-end">
                                                                <p class="inv-customer-name">
                                                                    {{ $profile->nama_toko }}
                                                                </p>
                                                                <p class="inv-street-addr">
                                                                    {{ $profile->alamat }}
                                                                </p>
                                                                <p class="inv-email-address">
                                                                    {{ $profile->email }}
                                                                </p>
                                                                <p class="inv-email-address">
                                                                    {{ $profile->no_telp }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="inv--product-table-section">
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead class="">
                                                                    <tr>
                                                                        <th scope="col">No</th>
                                                                        <th scope="col">Nama Barang</th>
                                                                        <th class="text-end" scope="col">
                                                                            Jumlah PO
                                                                        </th>
                                                                        <th class="text-end" scope="col">
                                                                            Jumlah Actual
                                                                        </th>
                                                                        <th class="text-end" scope="col">
                                                                            Reject
                                                                        </th>
                                                                        <th class="text-end" scope="col">
                                                                            Final Qty
                                                                        </th>
                                                                        <th class="text-end" scope="col">
                                                                            Satuan
                                                                        </th>
                                                                        <th class="text-end" scope="col">
                                                                            Harga
                                                                        </th>
                                                                        <th class="text-end" scope="col">
                                                                            Sub Total
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($purchaseOrder->details as $index => $detail)
                                                                        <tr>
                                                                            <td>{{ $index + 1 }}</td>
                                                                            <td>{{ $detail->barang->nama_barang }}</td>
                                                                            <td class="text-end">{{ $detail->qty_po }}</td>
                                                                            <td class="text-end">{{ $detail->qty_actual }}
                                                                            </td>
                                                                            <td class="text-end">
                                                                                {{ $detail->reject ?? '0' }}</td>
                                                                            <td class="text-end">{{ $detail->final_qty }}
                                                                            </td>
                                                                            <td class="text-end">{{ $detail->satuan }}</td>

                                                                            <!-- Akses data dari DetailPurchaseOrder -->
                                                                            @if ($detail->inbound->purchaseOrder->details->isNotEmpty())
                                                                                <td class="text-end">
                                                                                    Rp.
                                                                                    {{ number_format($detail->inbound->purchaseOrder->details->first()->harga) }}
                                                                                    <!-- Format sebagai Rupiah -->
                                                                                </td>
                                                                                <td class="text-end">
                                                                                    Rp.
                                                                                    {{ number_format($detail->inbound->purchaseOrder->details->first()->sub_total) }}
                                                                                    <!-- Format sebagai Rupiah -->
                                                                                </td>
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>

                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="inv--total-amounts">
                                                        <div class="row mt-4">
                                                            <div class="col-sm-5 col-12 order-sm-0 order-1"></div>
                                                            <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                                <div class="text-sm-end">
                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-7 mt-3">
                                                                            <h4 class=""> Total : Rp</h4>
                                                                        </div>
                                                                        <div class="col-sm-4 col-5  mt-3">
                                                                            <h4 class="">

                                                                                {{ number_format($pembelian->total) }}
                                                                                <!-- Format sebagai Rupiah -->
                                                                            </h4>
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
                            </div>

                            <div class="col-xl-3">
                                <div class="invoice-actions-btn">
                                    <div class="invoice-action-btn">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="javascript:void(0);" class="btn btn-secondary btn-print"
                                                    id="btn_print">Print</a>
                                            </div>
                                            <a href="{{ route('inbond.admin.pdf', Crypt::encryptString($purchaseOrder->kode_po)) }}"
                                                class="btn btn-success btn-download">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13">
                                                    </line>
                                                    <line x1="16" y1="17" x2="8" y2="17">
                                                    </line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>
                                                Download PDF</a>

                                            <div class="col-xl-12 col-md-3 col-sm-6">
                                                <a href="{{ route('inbound.admin.edit', Crypt::encryptString($purchaseOrder->kode_po)) }}"
                                                    class="btn btn-dark btn-edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                        </path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                            </div>

                                            <div class="col-xl-12 col-md-3 col-sm-6 pt-2">
                                                <a href="{{ route('inbound.admin.index') }}"
                                                    class="btn btn-outline-dark btn-rounded mb-2 me-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-arrow-left">
                                                        <line x1="19" y1="12" x2="5"
                                                            y2="12"></line>
                                                        <polyline points="12 19 5 12 12 5"></polyline>
                                                    </svg>
                                                    Kembali
                                                </a>
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
    <script>
        document.getElementById('btn_print').addEventListener('click', function() {
            var printContents = document.querySelector('.invoice-container').innerHTML;

            // Create a new window to hold the print content
            var printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.write('<html><head><title>Print Invoice</title>');
            // Tambahkan link ke file CSS
            printWindow.document.write(
                '<link rel="stylesheet" href="{{ asset('cork/html/src/bootstrap/css/bootstrap.min.css') }}" type="text/css" />'
            );
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');

            // Ensure that the CSS has been loaded before printing
            printWindow.document.close();
            printWindow.focus();

            // Set a small timeout to give the browser time to render the content properly
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500); // Delay 500ms to ensure everything is ready for print
        });
    </script>
@endsection
