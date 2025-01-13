<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title') | Store Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('cork/html/src/assets/img/favicon.ico') }}" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet"
        type="text/css" />
    <script src="{{ asset('cork/html/layouts/vertical-light-menu/loader.js') }}"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('cork/html/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/src/table/datatable/datatables.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/css/light/table/datatable/dt-global_style.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/css/dark/table/datatable/dt-global_style.css') }}" />
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('cork/html/src/assets/css/light/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/dark/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

    {{-- Modal --}}
    <link href="{{ asset('cork/html/src/assets/css/light/components/modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/dark/components/modal.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="layout-boxed" data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100">
    @include('sweetalert::alert')
    if

    @include('superadmin.partials.navbar')
    @include('superadmin.partials.aside')

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('cork/html/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('cork/html/layouts/vertical-light-menu/app.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/highlight/highlight.pack.js') }}"></script>
    <!-- END GLOBAL MANDATORY STYLES -->

    <script src="{{ asset('cork/html/src/assets/js/scrollspyNav.js') }}"></script>

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('cork/html/src/plugins/src/table/datatable/datatables.js') }}"></script>


    <!-- Tambahkan jQuery dan SweetAlert -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
