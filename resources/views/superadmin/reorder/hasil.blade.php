@extends('superadmin.partials.pemasok')
@section('container')
    <div class="layout-px-spacing">

        <div class="middle-content container-xxl p-0">

            <!-- BREADCRUMB -->
            <div class="page-meta">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Data Barang</a></li>
                    </ol>
                    <a href="" class="btn btn-primary mt-2">Tambah Data</a>
                </nav>
            </div>
            <!-- /BREADCRUMB -->

            <div class="row layout-top-spacing">

                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-8">
                        <table id="zero-config" class="table table-striped dt-table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Maximum Usage</th>
                                    <th>Average Usage</th>
                                    <th>Lead Time</th>
                                    <th>Demand / Bulan</th>
                                    <th>SS</th>
                                    <th>ROP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gulaku 1 Kg</td>
                                    <td>20</td>
                                    <td>30</td>
                                    <td>4</td>
                                    <td>33</td>
                                    <td>40</td>
                                    <td>70</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <th>Nama Barang</th>
                                <th>Maximum Usage</th>
                                <th>Average Usage</th>
                                <th>Lead Time</th>
                                <th>Demand / Tahun</th>
                                <th>SS</th>
                                <th>ROP</th>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
