<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ $aplikasi->title_header }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="{{ URL::asset('build/dist/img/favicon.ico') }}" type="image/x-icon">
    @include('layouts.head-css')
</head>

<body class="hold-transition skin-blue-light fixed sidebar-mini">
    <div class="wrapper">
        @include('layouts.topbar')

        @include('layouts.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('layouts.footer')
    </div>

    @include('layouts.vendor-scripts')
</body>

</html>
