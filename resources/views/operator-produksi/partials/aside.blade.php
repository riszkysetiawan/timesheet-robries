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
                        <a href="{{ route('dashboard.operator-produksi') }}">
                            <img src="{{ asset('logo.jpg') }}" />
                        </a>
                    </div>
                    <div class="nav-item theme-text">
                        <a href="{{ route('dashboard.operator-produksi') }}" class="nav-link"> DASHBOARD </a>
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
                    class="menu  {{ Request::is('dashboard*') || Request::is('profile/operator-produksi*') ? 'active' : '' }}">
                    <a href="/dashboard-operator-produksi" aria-expanded="false" class="dropdown-toggle">
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
                    class="menu  {{ Request::is('production/operator-produksi*') ||
                    Request::is('tambah/production/operator-produksi*') ||
                    Request::is('edit/production/operator-produksi*') ||
                    Request::is('edit-timer/production/operator-produksi*') ||
                    Request::is('mulai-timer/production/operator-produksi*') ||
                    Request::is('production/operator-produksi/timerbarcode*') ||
                    Request::is('show/production/operator-produksi*') ||
                    Request::is('get-produk/operator-produksi*') ||
                    Request::is('get-ukuran/operator-produksi*')
                        ? 'active'
                        : '' }}">
                    <a href="{{ route('production.operator-produksi.index') }}" aria-expanded="false"
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
