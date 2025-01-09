<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
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

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" href="{{ asset('cork/html/src/plugins/src/filepond/filepond.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}" />
    <link href="{{ asset('cork/html/src/plugins/src/notification/snackbar/snackbar.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('cork/html/src/plugins/src/sweetalerts2/sweetalerts2.css') }}" />

    <link href="{{ asset('cork/html/src/plugins/css/light/filepond/custom-filepond.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/light/components/tabs.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/assets/css/light/elements/alert.css') }}" />

    <link href="{{ asset('cork/html/src/plugins/css/light/sweetalerts2/custom-sweetalert.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/plugins/css/light/notification/snackbar/custom-snackbar.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/assets/css/light/forms/switches.css') }}" />
    <link href="{{ asset('cork/html/src/assets/css/light/components/list-group.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('cork/html/src/assets/css/light/users/account-setting.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('cork/html/src/plugins/css/dark/filepond/custom-filepond.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/assets/css/dark/components/tabs.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/assets/css/dark/elements/alert.css') }}" />

    <link href="{{ asset('cork/html/src/plugins/css/dark/sweetalerts2/custom-sweetalert.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('cork/html/src/plugins/css/dark/notification/snackbar/custom-snackbar.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/assets/css/dark/forms/switches.css') }}" />
    <link href="{{ asset('cork/html/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('cork/html/src/assets/css/dark/users/account-setting.css') }}" rel="stylesheet"
        type="text/css" />

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
    @include('sweetalert::alert')
    @include('superadmin.partials.navbar')
    @include('superadmin.partials.aside')


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('cork/html/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('cork/html/layouts/vertical-light-menu/app.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="{{ asset('cork/html/src/plugins/src/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImagePreview.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageCrop.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageResize.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageTransform.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/notification/snackbar/snackbar.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/assets/js/users/account-settings.js') }}"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
</body>

</html>
