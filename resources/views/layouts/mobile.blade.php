<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ URL::asset('build/dist/img/favicon.ico') }}" type="image/x-icon">
    <title>@yield('title') - {{ $aplikasi->title_header }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    @include('layouts.mobile-head-css')
</head>

<body class="bg-light d-flex flex-column vh-100">

    @include('layouts.mobile-top-sidebar')

    <div class="vh-100 my-auto overflow-auto">
        @yield('content')
    </div>

    @include('layouts.mobile-footer')

    @include('layouts.mobile-vendor-scripts')

</body>

</html>
