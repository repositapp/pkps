<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Aplikasi Sekolah</title>
    <link rel="icon" href="{{ URL::asset('build/dist/img/favicon.ico') }}" type="image/x-icon">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Line Awesome -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="{{ URL::asset('dist/css/login.css') }}" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#1d4ed8',
                        'success': '#059669',
                        'danger': '#dc2626',
                    }
                }
            }
        }
    </script>
    @stack('css')
</head>

<body class="font-sans">
    <!-- Main Content -->
    <div class="container mx-auto px-4">
        @yield('content')
    </div>

    @include('mobile.layouts.mobile-vendor-scripts')
</body>

</html>
