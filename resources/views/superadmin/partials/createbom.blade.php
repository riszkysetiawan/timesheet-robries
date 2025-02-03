<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Ecommerce Create | CORK - Multipurpose Bootstrap Dashboard Template </title>
    <link rel="icon" type="image/x-icon" href="../src/assets/img/favicon.ico" />
    <link href="{{ asset('cork/html/layouts/vertical-light-menu/css/light/loader.css ') }}" rel="stylesheet"
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

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link rel="stylesheet" href="{{ asset('cork/html/src/plugins/src/filepond/filepond.min.css ') }}">
    <link rel="stylesheet" href="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImagePreview.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/plugins/src/tagify/tagify.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/assets/css/light/forms/switches.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/css/light/editors/quill/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/css/light/tagify/custom-tagify.css') }}">
    <link href="{{ asset('cork/html/src/plugins/css/light/filepond/custom-filepond.css ') }}" rel="stylesheet"
        type="text/css " />

    <link rel="stylesheet" type="text/css" href="{{ asset('cork/html/src/assets/css/dark/forms/switches.css ') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/css/dark/editors/quill/quill.snow.css ') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cork/html/src/plugins/css/dark/tagify/custom-tagify.css ') }}">
    <link href="{{ asset('cork/html/src/plugins/css/dark/filepond/custom-filepond.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link rel="stylesheet" href="{{ asset('cork/html/src/assets/css/light/apps/ecommerce-create.css') }}">
    <link rel="stylesheet" href="{{ asset('cork/html/src/assets/css/dark/apps/ecommerce-create.css') }}">
    <!--  END CUSTOM STYLE FILE  -->
</head>

<body class="">

    @include('superadmin.partials.navbar')
    @include('superadmin.partials.aside')
    @include('sweetalert::alert')


    @stack('scripts')

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <script src="{{ asset('cork/html/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/mousetrap/mousetrap.min.js') }}"></script>
    <script src="{{ asset('cork/html/layouts/vertical-light-menu/app.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/highlight/highlight.pack.js') }}"></script>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('cork/html/src/plugins/src/editors/quill/quill.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImagePreview.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageCrop.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageResize.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/FilePondPluginImageTransform.min.js') }}"></script>
    <script src="{{ asset('cork/html/src/plugins/src/filepond/filepondPluginFileValidateSize.min.js') }}"></script>

    <script src="{{ asset('cork/html/src/plugins/src/tagify/tagify.min.js') }}"></script>

    <script src="{{ asset('cork/html/src/assets/js/apps/ecommerce-create.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>
