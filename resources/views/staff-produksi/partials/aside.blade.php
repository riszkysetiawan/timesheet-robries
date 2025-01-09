<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
    <div class="overlay"></div>
    <div class="search-overlay"></div>
    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme"
        style="position: fixed; height: 100%; overflow-y: auto; overflow-x: hidden;">
        <nav id="sidebar" style="max-height: 100%; overflow-y: auto; padding-bottom: 20px;">
            <div class="navbar-nav theme-brand flex-row text-center">
                <div class="nav-logo">
                    <div class="nav-item theme-logo">
                        <a href="{{ route('dashboard.staff-produksi') }}">
                            <img src="{{ asset('logo.jpg') }}" />
                        </a>
                    </div>
                    <div class="nav-item theme-text">
                        <a href="{{ route('dashboard.staff-produksi') }}" class="nav-link"> DASHBOARD </a>
                    </div>
                </div>
                <div class="nav-item sidebar-toggle">
                    <div class="btn-toggle sidebarCollapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevrons-left">
                            <polyline points="11 17 6 12 11 7"></polyline>
                            <polyline points="18 17 13 12 18 7"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="shadow-bottom"></div>
            <ul class="list-unstyled menu-categories" id="accordionExample">

                <!-- Dashboard Menu -->
                <li
                    class="menu  {{ Request::is('dashboard*') || Request::is('profile/production-staff*') ? 'active' : '' }}">
                    <a href="/dashboard-produksi" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            {{-- {{ Request::path() }} --}}
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>

                <li
                    class="menu  {{ Request::is('production/production-staff*') ||
                    Request::is('tambah/production/production-staff*') ||
                    Request::is('edit/production/production-staff*') ||
                    Request::is('edit-timer/production/production-staff*') ||
                    Request::is('mulai-timer/production/production-staff*') ||
                    Request::is('production/production-staff/timerbarcode*') ||
                    Request::is('show/production/production-staff*') ||
                    Request::is('get-produk/production-staff*') ||
                    Request::is('get-ukuran/production-staff*')
                        ? 'active'
                        : '' }}">
                    <a href="{{ route('production.production-staff.index') }}" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9.5V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9.5"></path>
                                <path d="M9 22V12h6v10"></path>
                                <path d="M2 10l10-7 10 7"></path>
                            </svg>
                            <span>Production</span>
                        </div>
                    </a>
                </li>


                {{-- produk --}}
                <li
                    class="menu {{ Request::is('warna/production-staff*') ||
                    Request::is('tambah/warna/production-staff*') ||
                    Request::is('edit/warna/production-staff*') ||
                    Request::is('produk/production-staff*') ||
                    Request::is('tambah/produk/production-staff*') ||
                    Request::is('edit/produk/production-staff*') ||
                    Request::is('upload/files/produk/production-staff*') ||
                    Request::is('size/produk/production-staff*') ||
                    Request::is('tambah/size/produk/production-staff*') ||
                    Request::is('upload/files/size/production-staff*') ||
                    Request::is('edit/size/produk/production-staff*')
                        ? 'show'
                        : '' }}">
                    <a href="#produk" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-package">
                                <path d="M16.5 9.4 7.55 4.24"></path>
                                <path
                                    d="M21 16.5V7.5a2 2 0 0 0-1-1.73L12 2 4 5.77A2 2 0 0 0 3 7.5v9a2 2 0 0 0 1 1.73l7 4.05a2 2 0 0 0 2 0l7-4.05a2 2 0 0 0 1-1.73z">
                                </path>
                                <path d="M16.5 9.4v8.99"></path>
                                <path d="M7.5 4.21v8.99"></path>
                                <path d="M3.27 6.96 12 12.01 20.73 6.96"></path>
                            </svg>
                            <span>Produk</span>
                        </div>

                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::is('warna/production-staff*') ||
                    Request::is('tambah/warna/production-staff*') ||
                    Request::is('edit/warna/production-staff*') ||
                    Request::is('produk/production-staff*') ||
                    Request::is('tambah/produk/production-staff*') ||
                    Request::is('edit/produk/production-staff*') ||
                    Request::is('upload/files/produk/production-staff*') ||
                    Request::is('size/produk/production-staff*') ||
                    Request::is('tambah/size/produk/production-staff*') ||
                    Request::is('upload/files/size/production-staff*') ||
                    Request::is('edit/size/produk/production-staff*')
                        ? 'show'
                        : '' }} "
                        id="produk" data-bs-parent="#accordionExample">
                        <li
                            class="  {{ Request::is('warna/production-staff*') ||
                            Request::is('tambah/warna/production-staff*') ||
                            Request::is('edit/warna/production-staff*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('warna.production-staff.index') }}"> Warna Produk </a>
                        </li>
                        {{-- <li
                            class=" {{ Request::is('produk/production-staff*') ||
                            Request::is('tambah/produk/production-staff*') ||
                            Request::is('edit/produk/production-staff*') ||
                            Request::is('upload/files/produk/production-staff*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('produk.production-staff.index') }}"> Data Produk </a>
                        </li> --}}
                        <li
                            class="{{ Request::is('size/produk/production-staff*') ||
                            Request::is('tambah/size/produk/production-staff*') ||
                            Request::is('upload/files/size/production-staff*') ||
                            Request::is('edit/size/produk/production-staff*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('size-produk.production-staff.index') }}"> Size Produk </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div>
            @yield('container')
        </div>
        <!--  BEGIN FOOTER  -->
        @include('superadmin.partials.footer')
        <!--  END FOOTER  -->
    </div>
    <!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->
