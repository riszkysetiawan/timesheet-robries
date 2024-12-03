@extends('superadmin.partials.pembelian')
@section('title', 'Laporan Penjualan')
@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <!-- Modal untuk Preview -->
            <div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPreviewLabel">Preview Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            <!-- Konten dari AJAX akan dimasukkan di sini -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tanggal -->
            <div class="row mt-4 mb-4">
                <div class="col-md-4">
                    <input type="text" id="filterTanggal" class="form-control" placeholder="Filter by Date Range" />
                </div>
            </div>

            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Invoice</th>
                                        <th>Nama Kasir</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Jumlah Kembalian</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3" id="downloadExcelBtn">Download Excel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambahkan jQuery dan daterangepicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            $('#downloadExcelBtn').on('click', function() {
                let dateRange = $('#filterTanggal').val().split(' - ');
                let startDate = dateRange[0] || '';
                let endDate = dateRange[1] || '';

                // Buat URL dengan parameter tanggal
                let downloadUrl = "{{ route('download.excel.penjualan.admin') }}" + "?start_date=" +
                    startDate + "&end_date=" + endDate;

                // Redirect ke URL download dengan parameter tanggal
                window.location.href = downloadUrl;
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Date Range Picker
            $('#filterTanggal').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear',
                    applyLabel: 'Filter'
                },
                autoUpdateInput: false
            });

            // Saat filter diterapkan
            $('#filterTanggal').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                $('#zero-config').DataTable().ajax.reload();
            });

            // Saat filter dibersihkan
            $('#filterTanggal').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#zero-config').DataTable().ajax.reload();
            });

            // Inisialisasi DataTable
            $('#zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporan.penjualan.admin.index') }}",
                    data: function(d) {
                        // Kirim nilai filter tanggal ke server
                        let dateRange = $('#filterTanggal').val().split(' - ');
                        d.startDate = dateRange[0] || '';
                        d.endDate = dateRange[1] || '';
                    }
                },
                order: [
                    [3, 'desc']
                ], // Urutkan berdasarkan kolom tanggal secara default
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_invoice',
                        name: 'kode_invoice'
                    },
                    {
                        data: 'nama_kasir',
                        name: 'nama_kasir'
                    },
                    {
                        data: 'tgl_buat',
                        name: 'tgl_buat'
                    },
                    {
                        data: 'total_rupiah',
                        name: 'total_rupiah'
                    },
                    {
                        data: 'jumlah_bayar',
                        name: 'jumlah_bayar'
                    },
                    {
                        data: 'kembali',
                        name: 'kembali'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
        });

        // Preview Data
        $(document).on('click', '.btn-preview', function() {
            var invoiceId = $(this).data('id');
            $.ajax({
                url: '/penjualan/admin/' + invoiceId + '/preview',
                method: 'GET',
                success: function(data) {
                    $('#modalPreview .modal-body').html(`
                        <h5>Kode Invoice: ${data.penjualan.kode_invoice}</h5>
                        <p>Nama Kasir: ${data.penjualan.nama_kasir}</p>
                        <p>Tanggal: ${new Date(data.penjualan.created_at).toLocaleDateString()}</p>
                        <h6>Detail Penjualan:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${data.details.map(detail => `
                                                                                <tr>
                                                                                    <td>${detail.kode_barang}</td>
                                                                                    <td>${detail.barang.nama_barang}</td>
                                                                                    <td>${detail.qty}</td>
                                                                                    <td>${detail.satuan}</td>
                                                                                    <td>Rp ${formatRupiah(detail.harga)}</td>
                                                                                    <td>Rp ${formatRupiah(detail.sub_total)}</td>
                                                                                </tr>
                                                                            `).join('')}
                                </tbody>
                            </table>
                        </div>
                        <h6>Total: Rp ${formatRupiah(data.penjualan.total)}</h6>
                        <h6>Jumlah Bayar: Rp ${formatRupiah(data.penjualan.jumlah_bayar)}</h6>
                        <h6>Jumlah Kembalian: Rp ${formatRupiah(data.penjualan.kembali)}</h6>
                    `);
                    $('#modalPreview').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });

        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }
    </script>
@endsection
