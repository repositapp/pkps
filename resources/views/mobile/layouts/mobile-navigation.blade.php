@if (Auth::user()->role == 'guru')
    <nav class="bg-white shadow-lg fixed bottom-0 left-0 right-0 py-3 border-t">
        <div class="flex justify-around">
            <a href="{{ route('mobile.guru.dashboard') }}"
                class="flex flex-col items-center {{ Request::is('mobile/guru/dashboard') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-home text-2xl mb-1"></i>
                <span class="text-xs">Dashboard</span>
            </a>
            <a href="{{ route('mobile.guru.jadwal') }}"
                class="flex flex-col items-center {{ Request::is('mobile/guru/jadwal') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-calendar-alt text-2xl mb-1"></i>
                <span class="text-xs">Jadwal</span>
            </a>
            {{-- <a href="{{ route('mobile.guru.absensi.index') }}"
                class="flex flex-col items-center {{ Request::is('mobile/guru/absensi*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-check-circle text-2xl mb-1"></i>
                <span class="text-xs">Absensi</span>
            </a>
            <a href="{{ route('mobile.guru.perilaku.index') }}"
                class="flex flex-col items-center {{ Request::is('mobile/guru/perilaku*') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-star text-2xl mb-1"></i>
                <span class="text-xs">Perilaku</span>
            </a> --}}
            <a href="{{ route('mobile.guru.profil') }}"
                class="flex flex-col items-center {{ Request::is('mobile/guru/profil') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-user text-2xl mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </nav>
@elseif (Auth::user()->role == 'ortu')
    <nav class="bg-white shadow-lg fixed bottom-0 left-0 right-0 py-3 border-t">
        <div class="flex justify-around">
            <a href="{{ route('mobile.ortu.dashboard') }}"
                class="flex flex-col items-center {{ Request::is('mobile/ortu/dashboard') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-home text-2xl mb-1"></i>
                <span class="text-xs">Beranda</span>
            </a>
            <a href="{{ route('mobile.ortu.absensi') }}"
                class="flex flex-col items-center {{ Request::is('mobile/ortu/absensi') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-calendar-alt text-2xl mb-1"></i>
                <span class="text-xs">Kehadiran</span>
            </a>
            <a href="{{ route('mobile.ortu.perilaku') }}"
                class="flex flex-col items-center {{ Request::is('mobile/ortu/perilaku') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-info-circle text-2xl mb-1"></i>
                <span class="text-xs">Perilaku</span>
            </a>
            <a href="{{ route('mobile.ortu.profil') }}"
                class="flex flex-col items-center {{ Request::is('mobile/ortu/profil') ? 'text-primary' : 'text-gray-500' }}">
                <i class="las la-user text-2xl mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </nav>
@endif
