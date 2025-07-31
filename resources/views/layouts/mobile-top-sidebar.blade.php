@if (Request::is('user/login'))
    <div class="d-flex align-items-center gap-3 p-3 bg-primary inner-page-heaer">
        <div>
            <h6 class="fw-bold text-white mb-0">Selamat Datang</h6>
            <p class="text-white-50 small m-0">Silakan masuk ke akun Anda</p>
        </div>
    </div>
@elseif (Request::is('user/register'))
    <div class="d-flex align-items-center gap-3 p-3 bg-primary inner-page-heaer">
        <div>
            <h6 class="fw-bold text-white mb-0">Registrasi Akun</h6>
            <p class="text-white-50 small m-0">Daftarkan akun anda</p>
        </div>
    </div>
@elseif (Request::is('mobile/dashboard'))
    <div class="homepage-navbar shadow mb-auto p-3 bg-primary">
        <div class="d-flex align-items-center">
            <a href="#" class="link-dark text-truncate d-flex align-items-center gap-2" data-bs-toggle="offcanvas"
                data-bs-target="#location" aria-controls="location">
                @if (Request::is('mobile/dashboard'))
                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="logo" class="login-logo"
                        width="40">
                    <span>
                        <h6 class="fw-bold text-white mb-0">Aplikasi Barber Shop</h6>
                        <p class="text-white-50 d-inline-block mb-0 w-75 align-bottom">Komunitas Barber Kota
                            Baubau</p>
                    </span>
                @else
                    <span>
                        <h6 class="fw-bold text-white mb-0">@yield('title')</h6>
                        <p class="text-white-50 d-inline-block mb-0 w-75 align-bottom">Daftar @yield('title')</p>
                    </span>
                @endif
            </a>
            @if (Request::is('mobile/dashboard'))
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="javascript:void();" class="link-dark"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="bg-dark bg-opacity-75 rounded-circle user-icon"><i
                                class="bi bi-arrow-bar-right d-flex m-0 h5 text-white"></i></div>
                    </a>
                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endif
        </div>
    </div>
@elseif (Request::is('mobile/barber', 'mobile/transaksi', 'mobile/profil'))
    <div class="homepage-navbar shadow mb-auto p-3 bg-primary">
        <div class="d-flex align-items-center">
            <a href="#" class="link-dark text-truncate d-flex align-items-center gap-2" data-bs-toggle="offcanvas"
                data-bs-target="#location" aria-controls="location">
                <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="logo" class="login-logo" width="40">
                <span>
                    <h6 class="fw-bold text-white mb-0">@yield('title')</h6>
                    <p class="text-white-50 d-inline-block mb-0 w-75 align-bottom">Daftar @yield('title')</p>
                </span>
            </a>
        </div>
    </div>
@else
    @if (Request::is('mobile/barber/detail*'))
        <div class="d-flex align-items-center gap-3 p-3 bg-primary inner-page-heaer">
            <a href="{{ redirect()->back()->getTargetUrl() }}" class="text-white"><i
                    class="bi bi-arrow-left fs-5"></i></a>
            <div>
                <h6 class="fw-bold text-white mb-0">@yield('title')</h6>
                <p class="text-white-50 small m-0">Data Detail Barber</p>
            </div>
            <div class="d-flex align-items-center gap-2 ms-auto">
                @yield('img')
            </div>
        </div>
    @else
        <div class="d-flex align-items-center gap-3 p-3 bg-primary inner-page-heaer">
            <a href="{{ redirect()->back()->getTargetUrl() }}" class="text-white"><i
                    class="bi bi-arrow-left fs-5"></i></a>
            <div>
                <h6 class="fw-bold text-white mb-0">@yield('title')</h6>
                {{-- <p class="text-white-50 small m-0">Data @yield('title')</p> --}}
            </div>
        </div>
    @endif
@endif
