<!doctype html>
<html lang="en" data-bs-theme="">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset("assets/favicon/favicon.ico")}}" type="image/x-icon">

    <!-- Map CSS -->
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css">

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{asset("assets/css/libs.bundle.css")}}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{asset("assets/css/theme.bundle.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/custom.css")}}">

    <style>body {
            display: none;
        }</style>

    <!-- Title -->
    <title>Dashkit</title>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156446909-1"></script>
    <script>window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag("js", new Date());
        gtag("config", "UA-156446909-1");</script>
</head>
<body>


@auth
    @include('components.sidebar')
@endauth

@yield('content')


<script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>
<script src="{{asset("assets/js/vendor.bundle.js")}}"></script>
<script src="{{asset("assets/js/custom.js")}}"></script>
<script src="{{asset("assets/js/faceid.js")}}"></script>
<script src="{{asset("assets/js/theme.bundle.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
