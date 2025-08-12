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
    <link href="{{ URL::asset('dist/css/mobile.css') }}" rel="stylesheet">
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

<body class="font-sans bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4 px-4 flex justify-between items-center fixed top-0 left-0 right-0 z-50">
        @if (Request::is('mobile/guru/dashboard', 'mobile/guru/jadwal', 'mobile/guru/profil') ||
                Request::is('mobile/ortu/dashboard', 'mobile/ortu/absensi', 'mobile/ortu/perilaku', 'mobile/ortu/profil'))
            <div class="flex items-center">
                <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo" class="w-6 h-6 mr-3">
                <span class="font-bold text-lg">Aplikasi Sekolah</span>
            </div>
            <a href="javascript:void(0);"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="las la-sign-out-alt text-xl text-gray-600"></i>
            </a>
            <form id="logout-form" action="{{ route('mobile.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <div class="flex items-center">
                @if (Request::is('mobile/guru/absensi') ||
                        Request::is('mobile/guru/absensi/laporan') ||
                        Request::is('mobile/guru/perilaku') ||
                        Request::is('mobile/guru/perilaku/laporan'))
                    <a href="{{ route('mobile.guru.dashboard') }}" class="mr-3">
                        <i class="las la-angle-left text-xl text-gray-600"></i>
                    </a>
                @else
                    <a href="{{ url()->previous() }}" class="mr-3">
                        <i class="las la-angle-left text-xl text-gray-600"></i>
                    </a>
                @endif
                <span class="font-bold text-lg">@yield('title')</span>
            </div>
        @endif
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 pt-20 pb-20">
        @yield('content')
    </div>

    <!-- Bottom Navigation -->
    @if (Request::is('mobile/guru/dashboard') || Request::is('mobile/guru/jadwal') || Request::is('mobile/guru/profil'))
        @include('mobile.layouts.mobile-navigation')
    @elseif (Request::is('mobile/ortu/*'))
        @include('mobile.layouts.mobile-navigation')
    @endif

    @include('mobile.layouts.mobile-vendor-scripts')
</body>

</html>
