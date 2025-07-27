<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title') - {{ $aplikasi->title_header }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link rel="icon" href="{{ URL::asset('build/dist/img/favicon.ico') }}" type="image/x-icon">
    <link href="{{ URL::asset('dist/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    @include('layouts.dist-head-css')
</head>

<body class="index-page">

    @include('layouts.dist-top-sidebar')

    <main class="main">
        @yield('content')
    </main>

    @include('layouts.dist-footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    @include('layouts.dist-vendor-scripts')

</body>

</html>
