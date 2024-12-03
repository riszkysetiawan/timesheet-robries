@extends('superadmin.partials.createuser')
@section('title', 'Update Perhitungan ROP')
@section('container')
    <div class="container">
        <div class="container">

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    {{-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Form</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Layouts</li>
                    </ol> --}}
                </nav>
            </div>
            <!-- /BREADCRUMB -->
            <div class="row">
                <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>Tambah Barang</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <form id="reorderForm">
                                @csrf
                                <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Maximum Usage</th>
                                            <th>Average Usage</th>
                                            <th>Lead Time</th>
                                            <th>SS</th>
                                            <th>ROP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barangs as $barang)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="kode_barang[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->kode_barang }}" required>
                                                    <input type="text" name="nama_barang[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->nama_barang }}" readonly>
                                                </td>
                                                <td><input type="text" name="maximum_usage[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->maximum_usage }}" required></td>
                                                <td><input type="text" name="average_usage[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->average_usage }}" required></td>
                                                <td><input type="text" name="lead_time[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->lead_time }}" required></td>
                                                <td><input type="text" name="safety_stock[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->safety_stock }}" readonly>
                                                </td>
                                                <td><input type="text" name="reorder_point[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $barang->reorder_point }}" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Maximum Usage</th>
                                            <th>Average Usage</th>
                                            <th>Lead Time</th>
                                            <th>SS</th>
                                            <th>ROP</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <button type="button" class="btn btn-primary" id="submitForm">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk menghitung Safety Stock dan Reorder Point
            function calculateSSandROP(row) {
                var maximumUsage = parseFloat(row.find('input[name="maximum_usage[]"]').val()) || 0;
                var averageUsage = parseFloat(row.find('input[name="average_usage[]"]').val()) || 0;
                var leadTime = parseFloat(row.find('input[name="lead_time[]"]').val()) || 0;

                var safetyStock = (maximumUsage - averageUsage) * leadTime;
                var reorderPoint = (leadTime * averageUsage) + safetyStock;

                // Update field Safety Stock dan Reorder Point
                row.find('input[name="safety_stock[]"]').val(safetyStock);
                row.find('input[name="reorder_point[]"]').val(reorderPoint);
            }

            // Perhitungan otomatis saat user mengisi input
            $('input[name="maximum_usage[]"], input[name="average_usage[]"], input[name="lead_time[]"]').on('input',
                function() {
                    var row = $(this).closest('tr');
                    calculateSSandROP(row);
                });

            // Menggunakan AJAX untuk menyimpan data
            $('#submitForm').on('click', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('reorder.store') }}",
                    method: 'POST',
                    data: $('#reorderForm').serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "{{ route('rop.admin') }}";
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: response.responseText
                        });
                    }
                });
            });
        });
    </script>
@endsection
