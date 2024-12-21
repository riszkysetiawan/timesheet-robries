<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Warehouse Management System</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('logo.jpg') }}" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet"
        type="text/css" />
    <script src="{{ asset('cork/html/layouts/vertical-light-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet" />
    <link href="{{ asset('cork/html/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('cork/html/src/plugins/src/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('cork/html/src/plugins/src/filepond/filepond.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}" />

    <link href="{{ asset('cork/html/src/plugins/css/light/filepond/custom-filepond.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/plugins/css/light/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/light/apps/invoice-add.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('cork/html/src/plugins/css/dark/filepond/custom-filepond.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/plugins/css/dark/flatpickr/custom-flatpickr.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/dark/apps/invoice-add.css') }}" rel="stylesheet" type="text/css" />

    <!--  END CUSTOM STYLE FILE  -->
</head>

<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    @include('staff-produksi.partials.navbar')
    @include('staff-produksi.partials.aside')

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('cork/html/src/plugins/src/global/vendors.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('cork/html/layouts/vertical-light-menu/app.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImagePreview.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageCrop.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageResize.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageTransform.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/flatpickr/flatpickr.js') }}"></script>
    {{-- <script src="{{ asset('cork/html/src/assets/js/apps/invoice-add.js') }}"></script> --}}
</body>

</html>
