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
                        <a href="{{ route('dashboard.superadmin') }}">
                            <img src="{{ asset('cork/html/src/assets/img/logo.svg') }}" alt="logo" />
                        </a>
                    </div>
                    <div class="nav-item theme-text">
                        <a href="{{ route('dashboard.superadmin') }}" class="nav-link"> DASHBOARD </a>
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
                <li class="menu  {{ Request::is('dashboard*') || Request::is('profile/superadmin*') ? 'active' : '' }}">
                    <a href="/dashboard" aria-expanded="false" class="dropdown-toggle">
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

                <!-- User Menu -->
                <li
                    class="menu {{ Request::is('users*') || Request::is('edit/user*') || Request::is('tambah/user/admin*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user">
                                <path d="M20.7 17.29a10.94 10.94 0 0 0-9.7-6.29 10.94 10.94 0 0 0-9.7 6.29"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>User</span>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="{{ route('proses.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-user">
                                <path d="M20.7 17.29a10.94 10.94 0 0 0-9.7-6.29 10.94 10.94 0 0 0-9.7 6.29"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Progress</span>
                        </div>
                    </a>
                </li>


                <!-- Supplier Menu -->
                {{-- <li
                    class="menu {{ Request::is('supplier*') || Request::is('edit/supplier/admin*') || Request::is('tambah/supplier/admin*') ? 'active' : '' }}">
                    <a href="/supplier/admin" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Supplier</span>
                        </div>
                    </a>
                </li> --}}

                <li class="menu active">
                    <a href="{{ route('production.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 0.88h9.72a1 1 0 0 0 1-0.88L23 6H6"></path>
                            </svg>
                            <span>Production</span>
                        </div>
                    </a>
                </li>

                <!-- Pembelian Menu -->
                {{-- <li
                    class="menu {{ Request::is('pembelian*') || Request::is('edit/pembelian/admin*') || Request::is('tambah/pembelian/admin*') || Request::is('show/pembelian/admin*') ? 'active' : '' }}">
                    <a href="/pembelian/admin" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M9 2h6a2 2 0 0 1 2 2v18a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"></path>
                                <path d="M9 2v2h6V2"></path>
                            </svg>
                            <span>Pembelian</span>
                        </div>
                    </a>
                </li> --}}

                {{-- <li class="menu ">
                    <a href="{{ route('inbound.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span>Inbond</span>
                        </div>
                    </a>
                </li> --}}

                <!-- Barang Menu -->
                <li class="menu ">
                    <a href="#invoice" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-box">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73L13 2.73a2 2 0 0 0-2 0L4 6.27A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>Barang</span>
                        </div>

                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="invoice" data-bs-parent="#accordionExample">
                        <li class="">
                            <a href="{{ route('warna.admin.index') }}"> Warna Barang </a>
                        </li>
                        <li class="">
                            <a href="{{ route('kategori.admin.index') }}"> Kategori</a>
                        </li>
                        <li class="">
                            <a href="{{ route('produk.admin.index') }}"> Data Barang </a>
                        </li>
                        <li class="">
                            <a href="{{ route('stock-produk.admin.index') }}"> Stock Produk </a>
                        </li>
                        <li class="">
                            <a href="{{ route('size-produk.admin.index') }}"> Size Produk </a>
                        </li>
                        <li class="">
                            <a href=""> Barcode Barang</a>
                        </li>
                        <li class="">
                            <a href=""> Mapping Barang</a>
                        </li>
                    </ul>
                </li>

                <!-- Reject Stock Menu -->
                <li class="menu ">
                    <a href="#wastes" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            <span>Reject Stock</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="wastes" data-bs-parent="#accordionExample">
                        <li class="">
                            <a href="/alasan/waste/admin"> Alasan Waste</a>
                        </li>
                        <li class="">
                            <a href="/waste/barang/admin"> Waste Barang</a>
                        </li>
                    </ul>
                </li>

                <!-- Laporan Menu -->
                {{-- <li class="menu ">
                    <a href="#laporan" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span>Laporan</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="laporan" data-bs-parent="#accordionExample">
                        <li class="">
                            <a href=""> Laporan Pembelian </a>
                        </li>
                        <li class="">
                            <a href=""> Laporan Penjualan</a>
                        </li>
                        <li class="">
                            <a href=""> Laporan inbond</a>
                        </li>
                        <li class="">
                            <a href=""> Laporan Barang</a>
                        </li>
                    </ul>
                </li> --}}



                <!-- Profile Toko Menu -->
                <li class="menu {{ Request::is('profile*') || Request::is('edit/profile/toko*') ? 'active' : '' }}">
                    <a href="/profile/toko" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2">
                                </rect>
                                <path d="M16 7V5a2 2 0 0 0-2-2H10a2 2 0 0 0-2 2v2"></path>
                            </svg>
                            <span>Profil Perusahaan</span>
                        </div>
                    </a>
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
