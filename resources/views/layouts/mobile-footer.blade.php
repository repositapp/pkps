@if (Request::is('mobile/dashboard', 'mobile/barber', 'mobile/transaksi', 'mobile/profil'))
    <div class="footer bg-white shadow mt-auto border-top">
        <div class="d-flex align-items-center justify-content-between py-1">
            <a href="{{ route('dashboard') }}"
                class="{{ Request::is('mobile/dashboard*') ? 'text-primary' : 'text-muted' }} text-center col py-2 p-1">
                <i class="bi bi-house h3 m-0"></i>
                <p class="small m-0 pt-1">Beranda</p>
            </a>
            <a href="{{ route('barber') }}"
                class="{{ Request::is('mobile/barber*') ? 'text-primary' : 'text-muted' }} text-center col py-2 p-1">
                <i class="bi bi-building h3 m-0"></i>
                <p class="small m-0 pt-1">Barber</p>
            </a>
            <a href="{{ route('transaksi') }}"
                class="{{ Request::is('mobile/transaksi*') ? 'text-primary' : 'text-muted' }} text-center col py-2 p-1">
                <i class="bi bi-shuffle h3 m-0"></i>
                <p class="small m-0 pt-1">Transaksi</p>
            </a>
            <a href="{{ route('profil') }}"
                class="{{ Request::is('mobile/profil*') ? 'text-primary' : 'text-muted' }} text-center col py-2 p-1">
                <i class="bi bi-person h3 m-0"></i>
                <p class="small m-0 pt-1">Profil</p>
            </a>
        </div>
    </div>
@endif
