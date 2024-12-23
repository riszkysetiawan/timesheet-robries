@extends('operator-produksi.partials.dashboard')
@section('title', 'Dashboard Superadmin')

@section('container')
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            <div class="row layout-top-spacing">
                <!-- Total Produk -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <h6 style="font-weight: bold; color: black; font-size: 20px;">Total Produk</h6>
                            <p class="value" style="font-weight: bold; color: black; font-size: 24px;">
                                {{ $total_products ?? '0' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
