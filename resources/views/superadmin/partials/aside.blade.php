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
                            <img src="{{ $logo ? asset('storage/' . $logo->foto) : asset('default-logo.jpg') }}" />
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
                <li
                    class="menu {{ Request::is('role/admin*') || Request::is('edit/role/admin*') || Request::is('tambah/role/admin*') ? 'active' : '' }}">
                    <a href="{{ route('role.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-award">
                                <circle cx="12" cy="8" r="7"></circle>
                                <path
                                    d="M8.21 13.89l-1.2 4.36a2 2 0 0 0 2.89 2.28L12 19.12l2.1 1.41a2 2 0 0 0 2.89-2.28l-1.2-4.36">
                                </path>
                            </svg>

                            <span>Role </span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ Request::is('proses/admin*') || Request::is('edit/proses/admin/*') || Request::is('tambah/proses/admin*') ? 'active' : '' }}">
                    <a href="{{ route('proses.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-trending-up">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                <polyline points="17 6 23 6 23 12"></polyline>
                            </svg>
                            <span>Progress</span>
                        </div>
                    </a>
                </li>


                <!-- Supplier Menu -->
                <li
                    class="menu {{ Request::is('supplier*') || Request::is('edit/supplier/admin*') || Request::is('tambah/supplier/admin*') ? 'active' : '' }}">
                    <a href="{{ route('supplier.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Supplier</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ Request::is('pembelian*') || Request::is('edit/pembelian/admin*') || Request::is('tambah/pembelian/admin*') ? 'active' : '' }}">
                    <a href="{{ route('pembelian.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Pembelian</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ Request::is('inbond*') || Request::is('edit/inbond/admin*') || Request::is('tambah/inbond/admin*') ? 'active' : '' }}">
                    <a href="{{ route('inbond.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Inbond</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ Request::is('penjualan*') || Request::is('edit/penjualan/admin*') || Request::is('tambah/penjualan/admin*') ? 'active' : '' }}">
                    <a href="{{ route('penjualan.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Penjualan</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu {{ Request::is('packing*') || Request::is('edit/packing/admin*') || Request::is('tambah/packing/admin*') ? 'active' : '' }}">
                    <a href="{{ route('packing.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Packing</span>
                        </div>
                    </a>
                </li>


                <li
                    class="menu {{ Request::is('history*') ||
                    Request::is('history/admin*') ||
                    Request::is('history-stock*') ||
                    Request::is('edit/history-stock/admin*') ||
                    Request::is('tambah/history-stock/admin*') ||
                    Request::is('show/history-stock/admin*') ||
                    Request::is('movement/admin*') ||
                    Request::is('edit/movement/admin*') ||
                    Request::is('tambah/movement/admin*') ||
                    Request::is('show/movement/admin*')
                        ? 'show'
                        : '' }}">
                    <a href="#ecommerce" data-bs-toggle="collapse"
                        aria-expanded="{{ Request::is('history*') || Request::is('history/admin*') ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            <span>History</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::is('history*') || Request::is('history/admin*') ? 'show' : '' }}"
                        id="ecommerce" data-bs-parent="#accordionExample">
                        <li
                            class="menu {{ Request::is('history*') || Request::is('edit/history/admin*') || Request::is('tambah/history/admin*') || Request::is('show/history/admin*') ? 'active' : '' }}">
                            <a href="{{ route('history.admin.index') }}">
                                History User
                            </a>
                        </li>
                        <li
                            class="menu {{ Request::is('history-stock*') || Request::is('edit/history-stock/admin*') || Request::is('tambah/history-stock/admin*') || Request::is('show/history-stock/admin*') ? 'active' : '' }}">
                            <a href="{{ route('history-stock.admin.index') }}"> History Stock </a>
                        </li>
                        <li
                            class="menu {{ Request::is('movement*') || Request::is('edit/movement/admin*') || Request::is('tambah/movement/admin*') || Request::is('show/movement/admin*') ? 'active' : '' }}">
                            <a href="{{ route('movement.admin.index') }}"> Stock Movement</a>
                        </li>
                    </ul>
                </li>



                <li
                    class="menu {{ Request::is('vendor-pengiriman/admin*') || Request::is('edit/vendor-pengiriman/admin*') || Request::is('tambah/vendor-pengiriman/admin*') ? 'active' : '' }}">
                    <a href="{{ route('vendor-pengiriman.admin.index') }}" aria-expanded="false"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                <path d="M1 3h15v13H1z"></path>
                                <path d="M16 8h5l2 3v5h-7z"></path>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                            <span>Vendor Pengiriman</span>
                        </div>
                    </a>
                </li>
                <li
                    class="menu  {{ Request::is('production/admin*') ||
                    Request::is('tambah/production/admin*') ||
                    Request::is('edit/production/admin*') ||
                    Request::is('edit-timer/production/admin*') ||
                    Request::is('mulai-timer/production/admin*') ||
                    Request::is('production/admin/timerbarcode*') ||
                    Request::is('show/production/admin*') ||
                    Request::is('get-produk/admin*') ||
                    Request::is('get-ukuran/admin*')
                        ? 'active'
                        : '' }}">
                    <a href="{{ route('production.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9.5V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9.5"></path>
                                <path d="M9 22V12h6v10"></path>
                                <path d="M2 10l10-7 10 7"></path>
                            </svg>
                            <span>Production</span>
                        </div>
                    </a>
                </li>



                <li
                    class="menu {{ Request::is('oven*') || Request::is('edit/oven/admin*') || Request::is('tambah/oven/admin*') || Request::is('show/oven/admin*') ? 'active' : '' }}">
                    <a href="{{ route('oven.admin.index') }}" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span>Oven</span>
                        </div>
                    </a>
                </li>

                <!-- Barang Menu -->
                <li
                    class="menu {{ Request::is('barang/admin*') ||
                    Request::is('tambah/barang/admin*') ||
                    Request::is('edit/barang/admin*') ||
                    Request::is('upload/files/barang/admin*') ||
                    Request::is('satuan-barang/admin*') ||
                    Request::is('tambah/satuan-barang/admin*') ||
                    Request::is('edit/satuan-barang/admin*') ||
                    Request::is('kategori/admin*') ||
                    Request::is('tambah/kategori/admin*') ||
                    Request::is('stock/produk/admin*') ||
                    Request::is('tambah/stock/produk/admin*') ||
                    Request::is('edit/stock/produk/admin*') ||
                    Request::is('upload/files/stock/admin*')
                        ? 'show'
                        : '' }}">
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
                    <ul class="collapse submenu list-unstyled {{ Request::is('barang/admin*') ||
                    Request::is('tambah/barang/admin*') ||
                    Request::is('edit/barang/admin*') ||
                    Request::is('upload/files/barang/admin*') ||
                    Request::is('satuan-barang/admin*') ||
                    Request::is('tambah/satuan-barang/admin*') ||
                    Request::is('edit/satuan-barang/admin*') ||
                    Request::is('kategori/admin*') ||
                    Request::is('tambah/kategori/admin*') ||
                    Request::is('stock/produk/admin*') ||
                    Request::is('tambah/stock/produk/admin*') ||
                    Request::is('edit/stock/produk/admin*') ||
                    Request::is('upload/files/stock/admin*')
                        ? 'show'
                        : '' }} "
                        id="invoice" data-bs-parent="#accordionExample">
                        <li
                            class=" {{ Request::is('kategori/admin*') || Request::is('tambah/kategori/admin*') || Request::is('edit/kategori/admin*') ? 'active' : '' }}">
                            <a href="{{ route('kategori.admin.index') }}"> Kategori</a>
                        </li>
                        <li
                            class=" {{ Request::is('satuan-barang/admin*') || Request::is('tambah/satuan-barang/admin*') || Request::is('edit/satuan-barang/admin*') ? 'active' : '' }}">
                            <a href="{{ route('satuan-barang.admin.index') }}">UOM Barang</a>
                        </li>
                        <li
                            class=" {{ Request::is('barang/admin*') || Request::is('tambah/barang/admin*') || Request::is('edit/barang/admin*') || Request::is('upload/files/barang/admin*') ? 'active' : '' }}">
                            <a href="{{ route('barang.admin.index') }}"> Data Barang </a>
                        </li>
                        <li
                            class=" {{ Request::is('stock/produk/admin*') ||
                            Request::is('tambah/stock/produk/admin*') ||
                            Request::is('edit/stock/produk/admin*') ||
                            Request::is('upload/files/stock/admin*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('stock-produk.admin.index') }}"> Stock Barang </a>
                        </li>
                        {{-- <li class="">
                            <a href=""> Barcode Barang</a>
                        </li> --}}
                    </ul>
                </li>

                {{-- produk --}}
                <li
                    class="menu {{ Request::is('warna/admin*') ||
                    Request::is('tambah/warna/admin*') ||
                    Request::is('edit/warna/admin*') ||
                    Request::is('produk/admin*') ||
                    Request::is('tambah/produk/admin*') ||
                    Request::is('edit/produk/admin*') ||
                    Request::is('upload/files/produk/admin*') ||
                    Request::is('size/produk/admin*') ||
                    Request::is('tambah/size/produk/admin*') ||
                    Request::is('upload/files/size/admin*') ||
                    Request::is('edit/size/produk/admin*')
                        ? 'show'
                        : '' }}">
                    <a href="#produk" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-package">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::is('warna/admin*') ||
                    Request::is('tambah/warna/admin*') ||
                    Request::is('edit/warna/admin*') ||
                    Request::is('produk/admin*') ||
                    Request::is('tambah/produk/admin*') ||
                    Request::is('edit/produk/admin*') ||
                    Request::is('upload/files/produk/admin*') ||
                    Request::is('size/produk/admin*') ||
                    Request::is('tambah/size/produk/admin*') ||
                    Request::is('upload/files/size/admin*') ||
                    Request::is('edit/size/produk/admin*')
                        ? 'show'
                        : '' }} "
                        id="produk" data-bs-parent="#accordionExample">
                        <li
                            class="  {{ Request::is('warna/admin*') || Request::is('tambah/warna/admin*') || Request::is('edit/warna/admin*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('warna.admin.index') }}"> Warna Produk </a>
                        </li>
                        <li
                            class=" {{ Request::is('produk/admin*') ||
                            Request::is('tambah/produk/admin*') ||
                            Request::is('edit/produk/admin*') ||
                            Request::is('upload/files/produk/admin*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('produk.admin.index') }}"> Data Produk </a>
                        </li>
                        <li
                            class="{{ Request::is('size/produk/admin*') ||
                            Request::is('tambah/size/produk/admin*') ||
                            Request::is('upload/files/size/admin*') ||
                            Request::is('edit/size/produk/admin*')
                                ? 'active'
                                : '' }}">
                            <a href="{{ route('size-produk.admin.index') }}"> Size Produk </a>
                        </li>
                    </ul>
                </li>

                <!-- Reject Stock Menu -->
                <li
                    class="menu {{ Request::is('alasan-waste/admin*') ||
                    Request::is('tambah/alasan-waste/admin*') ||
                    Request::is('edit/alasan-waste/admin*') ||
                    Request::is('waste-barang/admin*') ||
                    Request::is('tambah/waste/admin*') ||
                    Request::is('edit/waste/admin*')
                        ? 'show'
                        : '' }}">
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
                    <ul class="collapse submenu list-unstyled {{ Request::is('alasan-waste/admin*') ||
                    Request::is('tambah/alasan-waste/admin*') ||
                    Request::is('edit/alasan-waste/admin*') ||
                    Request::is('waste-barang/admin*') ||
                    Request::is('tambah/waste/admin*') ||
                    Request::is('edit/waste/admin*')
                        ? 'show'
                        : '' }}"
                        id="wastes" data-bs-parent="#accordionExample">
                        <li
                            class="{{ Request::is('alasan-waste/admin*') || Request::is('tambah/alasan-waste/admin*') || Request::is('edit/alasan-waste/admin*') ? 'active' : '' }}">
                            <a href="{{ route('alasan-waste.admin.index') }}"> Alasan Waste</a>
                        </li>
                        <li
                            class="{{ Request::is('/waste-barang/admin*') || Request::is('tambah/waste/admin*') || Request::is('edit/waste/admin*') ? 'active' : '' }}">
                            <a href="{{ route('waste.admin.index') }}"> Waste Barang</a>
                        </li>
                    </ul>
                </li>
                <li
                    class="menu {{ Request::is('area-mapping/admin*') ||
                    Request::is('tambah/area-mapping/admin*') ||
                    Request::is('edit/area-mapping/admin*') ||
                    Request::is('mapping/admin*') ||
                    Request::is('tambah/mapping/admin*') ||
                    Request::is('edit/mapping/admin*')
                        ? 'show'
                        : '' }}">
                    <a href="#mapping" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 2H8a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z">
                                </path>
                                <rect x="9" y="2" width="6" height="4" rx="1" ry="1">
                                </rect>
                            </svg>
                            <span>Mapping Stock</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ Request::is('area-mapping/admin*') ||
                    Request::is('tambah/area-mapping/admin*') ||
                    Request::is('edit/area-mapping/admin*') ||
                    Request::is('mapping/admin*') ||
                    Request::is('tambah/mapping/admin*') ||
                    Request::is('edit/mapping/admin*')
                        ? 'show'
                        : '' }}"
                        id="mapping" data-bs-parent="#accordionExample">
                        <li
                            class="{{ Request::is('area-mapping/admin*') || Request::is('tambah/area-mapping/admin*') || Request::is('edit/area-mapping/admin*') ? 'active' : '' }}">
                            <a href="{{ route('area-mapping.admin.index') }}"> Area</a>
                        </li>
                        <li
                            class=" {{ Request::is('mapping/admin*') || Request::is('tambah/mapping/admin*') || Request::is('edit/mapping/admin*') ? 'active' : '' }}">
                            <a href="{{ route('mapping.admin.index') }}"> Mapping Barang</a>
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
                <li
                    class="menu {{ Request::is('profile/company*') || Request::is('edit/profile/company*') ? 'active' : '' }}">
                    <a href="{{ route('profil.company.admin.index') }}" aria-expanded="false"
                        class="dropdown-toggle">
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
