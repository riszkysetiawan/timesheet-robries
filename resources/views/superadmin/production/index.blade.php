@extends('superadmin.partials.datatablescustomer')
@section('title', 'List Item Production')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <a href="{{ route('production.admin.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-plus">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Tambah Data
                    </a>
                </nav>
            </div>
            <!-- Scan Button -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <button id="scanButton" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-camera">
                            <path
                                d="M23 19v-11a2 2 0 0 0-2-2h-3.17l-1.84-2.76A2 2 0 0 0 14.2 3H9.8a2 2 0 0 0-1.79 1.24L6.17 7H3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2z">
                            </path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                        Scan QR Code
                    </button>
                </nav>
            </div>


            <!-- Scan Modal -->
            <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scanModalLabel">Scan QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="reader" style="width: 100%;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <button id="getSelected" class="btn btn-primary">Get Selected Data</button> --}}

            <!-- Modal Preview -->
            <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">Preview Progress</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Filter -->
            <div class="row mt-3 mb-4">
                <div class="col-md-4">
                    <input type="text" id="filterTanggal" class="form-control" placeholder="Filter Tanggal" />
                </div>
            </div>

            <!-- DataTable -->
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="penjualan-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>SO Number</th>
                                        <th>Nama Produk</th>
                                        <th>Size</th>
                                        <th>Qty</th>
                                        <th>Warna</th>
                                        <th>Kode Barcode</th>
                                        <th>Barcode</th>
                                        <th>Oven Start</th>
                                        <th>Nama Operator</th>
                                        <th>Oven Finish</th>
                                        <th>Durasi</th>
                                        <th>Nama Operator</th>
                                        <th>Press Start</th>
                                        <th>Nama Operator</th>
                                        <th>Press Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>WBS Start</th>
                                        <th>Nama Operator</th>
                                        <th>WBS Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>WELD Start</th>
                                        <th>Nama Operator</th>
                                        <th>WELD Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>VBS Start</th>
                                        <th>Nama Operator</th>
                                        <th>VBS Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>HBS Start</th>
                                        <th>Nama Operator</th>
                                        <th>HBS Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>Poles Start</th>
                                        <th>Nama Operator</th>
                                        <th>Poles Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>Assembly Start</th>
                                        <th>Nama Operator</th>
                                        <th>Assembly Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>Finishing Start</th>
                                        <th>Nama Operator</th>
                                        <th>Finishing Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>Rework Start</th>
                                        <th>Nama Operator</th>
                                        <th>Rework Finish</th>
                                        <th>Nama Operator</th>
                                        <th>Durasi</th>
                                        <th>Progress</th>
                                        <th>Hasil Akhir</th>
                                        <th>Catatan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <button id="downloadExcel" class="btn btn-success">Download Excel</button>
                    <button class="btn btn-outline-secondary btn-rounded mb-2 me-4"
                        onclick="window.location.href='{{ route('upload.production.files.admin') }}'">
                        Upload File</button>
                    <button id="printSelected" class="btn btn-primary">Print Selected</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script>
        $('#printSelected').on('click', function() {
            const selectedIds = Array.from($('.rowCheckbox:checked')).map((checkbox) => $(checkbox).data('id'));

            if (selectedIds.length === 0) {
                alert('No rows selected!');
                return;
            }

            // Open a new tab for printing
            const form = $('<form>', {
                action: "{{ route('print.labels') }}",
                method: 'POST',
                target: '_blank'
            });

            // Add CSRF token
            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}'
            }));

            // Add selected IDs
            selectedIds.forEach(id => {
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'selected_ids[]',
                    value: id
                }));
            });

            // Append the form to the body and submit
            form.appendTo('body').submit().remove();
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedRows = new Set();

            $('#selectAll').on('click', function() {
                const isChecked = $(this).is(':checked');

                $('.rowCheckbox').each(function() {
                    const id = $(this).data('id');
                    if (isChecked) {
                        selectedRows.add(id);
                        $(this).prop('checked', true); // Check all checkboxes on the current page
                    } else {
                        selectedRows.delete(id);
                        $(this).prop('checked',
                            false); // Uncheck all checkboxes on the current page
                    }
                });
            });

            // Individual row selection
            $(document).on('click', '.rowCheckbox', function() {
                const id = $(this).data('id');
                if ($(this).is(':checked')) {
                    selectedRows.add(id); // Add ID to the selected set
                } else {
                    selectedRows.delete(id); // Remove ID from the selected set
                }

                // Update "Select All" state
                const allChecked = $('.rowCheckbox:checked').length === $('.rowCheckbox').length;
                $('#selectAll').prop('checked', allChecked);
            });

            // Example: Log selected rows
            $('#getSelected').on('click', function() {
                console.log('Selected Rows:', Array.from(selectedRows));
            });
        });

        // $(document).ready(function() {
        //     $('#scanButton').on('click', function() {
        //         $('#scanModal').modal('show');

        //         const html5QrCode = new Html5Qrcode("reader");
        //         const qrCodeSuccessCallback = (decodedText, decodedResult) => {
        //             console.log(`QR Code detected: ${decodedText}`);

        //             // Encode the barcode to ensure special characters like '/' are properly handled
        //             const encodedBarcode = encodeURIComponent(decodedText);

        //             // Redirect or fetch the view
        //             $.ajax({
        //                 url: `/production/admin/timerbarcode/${encodedBarcode}`,
        //                 method: 'GET',
        //                 success: function(response) {
        //                     console.log('Data fetched successfully:', response);
        //                     // Replace the current page content with the response (render the view)
        //                     $('body').html(response);
        //                 },
        //                 error: function(error) {
        //                     console.error('Error fetching data:', error);
        //                     alert('Failed to fetch data. Please try again.');
        //                 }
        //             });

        //             $('#scanModal').modal('hide');
        //             html5QrCode.stop().catch(err => console.log(err));
        //         };

        //         const config = {
        //             fps: 10,
        //             qrbox: {
        //                 width: 500,
        //                 height: 500
        //             }
        //         };

        //         html5QrCode.start({
        //                 facingMode: "environment"
        //             },
        //             config,
        //             qrCodeSuccessCallback
        //         ).catch(err => console.log(`Error starting camera: ${err}`));

        //         $('#scanModal').on('hidden.bs.modal', function() {
        //             html5QrCode.stop().catch(err => console.log(err));
        //         });
        //     });
        // });
        $(document).ready(function() {
            $('#scanButton').on('click', function() {
                $('#scanModal').modal('show');

                const html5QrCode = new Html5Qrcode("reader");
                const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                    console.log(`QR Code detected: ${decodedText}`);

                    // Encode the barcode to ensure special characters like '/' are properly handled
                    const encodedBarcode = encodeURIComponent(decodedText);

                    // Redirect or fetch the view
                    $.ajax({
                        url: `/production/admin/timerbarcode/${encodedBarcode}`,
                        method: 'GET',
                        success: function(response) {
                            console.log('Data fetched successfully:', response);
                            // Replace the current page content with the response (render the view)
                            $('body').html(response);
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                            alert('Failed to fetch data. Please try again.');
                        }
                    });

                    $('#scanModal').modal('hide');
                    html5QrCode.stop().catch(err => console.log(err));
                };

                const config = {
                    fps: 10,
                    qrbox: {
                        width: 500,
                        height: 500
                    }
                };

                html5QrCode.start({
                        facingMode: "environment"
                    },
                    config,
                    qrCodeSuccessCallback
                ).catch(err => console.log(`Error starting camera: ${err}`));

                $('#scanModal').on('hidden.bs.modal', function() {
                    html5QrCode.stop().catch(err => console.log(err));
                });
            });
        });

        $('#downloadExcel').on('click', function() {
            const dateRange = $('#filterTanggal').val();
            let url = "{{ route('production.download.excel.admin') }}";

            if (dateRange) {
                const dates = dateRange.split(" - ");
                url += `?startDate=${dates[0]}&endDate=${dates[1]}`;
            }

            // Jika tidak ada filter, tetap lanjutkan ke URL tanpa parameter tanggal
            window.location.href = url; // Redirect to download route
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedRows = new Set();
            var table = $('#penjualan-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('production.admin.index') }}",
                    type: 'POST', // Ubah metode menjadi POST
                    data: function(d) {
                        var dates = $('#filterTanggal').val().split(' - ');
                        if (dates.length === 2) {
                            d.startDate = dates[0];
                            d.endDate = dates[1];
                        }
                        d._token = '{{ csrf_token() }}'; // Tambahkan CSRF token
                    },
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Check if the row's ID is already selected
                            const isChecked = selectedRows.has(row.id) ? "checked" : "";
                            return `<input type="checkbox" class="rowCheckbox" data-id="${row.id}" ${isChecked}>`;
                        },
                    }, {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tgl_production',
                        name: 'tgl_production',
                    },
                    {
                        data: 'so_number',
                        name: 'so_number'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'size',
                        name: 'size',
                        defaultContent: '-'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        defaultContent: '-'
                    },
                    {
                        data: 'warna',
                        name: 'warna',
                        defaultContent: '-'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode',
                        defaultContent: '-'
                    },
                    {
                        data: 'barcode',
                        name: 'barcode',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                return `<div class="qrcode" data-barcode="${data}"></div>`;
                            }
                            return data;
                        },
                        defaultContent: '-'
                    },
                    {
                        data: 'oven_start',
                        name: 'oven_start'
                    },
                    {
                        data: 'oven_start_operator',
                        name: 'oven_start_operator'
                    },
                    {
                        data: 'oven_finish',
                        name: 'oven_finish'
                    },
                    {
                        data: 'oven_finish_operator',
                        name: 'oven_finish_operator'
                    },
                    {
                        data: 'oven_duration',
                        name: 'oven_duration'
                    },
                    {
                        data: 'press_start',
                        name: 'press_start'
                    },
                    {
                        data: 'press_start_operator',
                        name: 'press_start_operator'
                    },
                    {
                        data: 'press_finish',
                        name: 'press_finish'
                    },
                    {
                        data: 'press_finish_operator',
                        name: 'press_finish_operator',
                    },
                    {
                        data: 'press_duration',
                        name: 'press_duration'
                    },
                    {
                        data: 'wbs_start',
                        name: 'wbs_start'
                    },
                    {
                        data: 'wbs_start_operator',
                        name: 'wbs_start_operator',
                    },
                    {
                        data: 'wbs_finish',
                        name: 'wbs_finish'
                    },
                    {
                        data: 'wbs_finish_operator',
                        name: 'wbs_finish_operator',
                    },
                    {
                        data: 'wbs_duration',
                        name: 'wbs_duration',
                    },
                    {
                        data: 'weld_start',
                        name: 'weld_start'
                    },
                    {
                        data: 'weld_start_operator',
                        name: 'weld_start_operator',
                    },
                    {
                        data: 'weld_finish',
                        name: 'weld_finish'
                    },
                    {
                        data: 'weld_finish_operator',
                        name: 'weld_finish_operator',
                    },
                    {
                        data: 'weld_duration',
                        name: 'weld_duration',
                    },
                    {
                        data: 'vbs_start',
                        name: 'vbs_start'
                    },
                    {
                        data: 'vbs_start_operator',
                        name: 'vbs_start_operator'
                    },
                    {
                        data: 'vbs_finish',
                        name: 'vbs_finish'
                    },
                    {
                        data: 'vbs_finish_operator',
                        name: 'vbs_finish_operator'
                    },
                    {
                        data: 'vbs_duration',
                        name: 'vbs_duration',
                    },
                    {
                        data: 'hbs_start',
                        name: 'hbs_start'
                    },
                    {
                        data: 'hbs_start_operator',
                        name: 'hbs_start_operator',
                    },
                    {
                        data: 'hbs_finish',
                        name: 'hbs_finish'
                    },
                    {
                        data: 'hbs_finish_operator',
                        name: 'hbs_finish_operator',
                    },
                    {
                        data: 'hbs_duration',
                        name: 'hbs_duration'
                    },
                    {
                        data: 'poles_start',
                        name: 'poles_start',
                    },
                    {
                        data: 'poles_start_operator',
                        name: 'poles_start_operator',
                    },
                    {
                        data: 'poles_finish',
                        name: 'poles_finish'
                    },
                    {
                        data: 'poles_finish_operator',
                        name: 'poles_finish_operator',
                    },
                    {
                        data: 'poles_duration',
                        name: 'poles_duration',
                    },
                    {
                        data: 'assembly_start',
                        name: 'assembly_start',
                    },
                    {
                        data: 'assembly_start_operator',
                        name: 'assembly_start_operator',
                    },
                    {
                        data: 'assembly_finish',
                        name: 'assembly_finish',
                    },
                    {
                        data: 'assembly_finish_operator',
                        name: 'assembly_finish_operator',
                    },
                    {
                        data: 'assembly_duration',
                        name: 'assembly_duration',
                    },
                    {
                        data: 'finishing_start',
                        name: 'finishing_start',
                    },
                    {
                        data: 'finishing_start_operator',
                        name: 'finishing_start_operator',
                    },
                    {
                        data: 'finishing_finish',
                        name: 'finishing_finish',
                    },
                    {
                        data: 'finishing_finish_operator',
                        name: 'finishing_finish_operator',
                    },
                    {
                        data: 'finishing_duration',
                        name: 'finishing_duration',
                    },
                    {
                        data: 'rework_start',
                        name: 'rework_start'
                    },
                    {
                        data: 'rework_start_operator',
                        name: 'rework_start_operator',
                    },
                    {
                        data: 'rework_finish',
                        name: 'rework_finish'
                    },
                    {
                        data: 'rework_finish_operator',
                        name: 'rework_finish_operator',
                    },
                    {
                        data: 'rework_duration',
                        name: 'rework_duration',
                    },

                    {
                        data: 'progress',
                        name: 'progress'
                    },
                    {
                        data: 'finish_rework',
                        name: 'finish_rework'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    // Ensure checkboxes reflect selected state after page change
                    $('.rowCheckbox').each(function() {
                        const id = $(this).data('id');
                        if (selectedRows.has(id)) {
                            $(this).prop('checked', true);
                        }
                    });
                },
            });
            // // Inisialisasi Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                },
                autoUpdateInput: false
            });

            // Event: Tanggal dipilih
            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                table.draw(); // Memuat ulang data tabel dengan parameter baru
            });

            // Event: Clear tanggal
            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                table.draw(); // Memuat ulang tabel tanpa filter tanggal
            });
        });
    </script>


    <script>
        // Delete Confirmation Handler
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteProduction(id);
                }
            });
        }

        // Delete Production Handler
        function deleteProduction(id) {
            $.ajax({
                url: '/delete/production/admin/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Dihapus!',
                            'Data production berhasil dihapus.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                $('#penjualan-table').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data penjualan.',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data penjualan.',
                        'error'
                    );
                }
            });
        }
    </script>
@endsection
