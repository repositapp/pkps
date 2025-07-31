@extends('layouts.mobile')
@section('title')
    {{ $barber->nama }}
@endsection
@section('img')
    @if ($barber->gambar)
        <img class="img-fluid d-block mx-auto" src="{{ asset('storage/' . $barber->gambar) }}" alt="Logo" width="40">
    @else
        <img class="img-fluid d-block mx-auto" src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo" width="40">
    @endif
@endsection
@section('content')
    @if (session('error'))
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="p-0">
        <div class="container p-0">
            <div class="row border osahan-my-account-page border-secondary-subtle g-0 col-lg-8 mx-auto overflow-hidden">
                <div class="col-lg-3 border-bottom bg-white">
                    <div class="nav d-flex justify-content-center my-account-pills" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        <button class="nav-link d-flex flex-column active" id="v-pills-my-address-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-my-address" type="button" role="tab"
                            aria-controls="v-pills-my-address" aria-selected="true">
                            <i class="bi bi-list-ul"></i>Layanan</button>
                        <button class="nav-link d-flex flex-column" id="v-pills-my-order-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-my-order" type="button" role="tab"
                            aria-controls="v-pills-my-order" aria-selected="false" tabindex="-1">
                            <i class="bi bi-clock"></i>Jadwal</button>
                        <button class="nav-link d-flex flex-column" id="v-pills-my-wallet-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-my-wallet" type="button" role="tab"
                            aria-controls="v-pills-my-wallet" aria-selected="false" tabindex="-1">
                            <i class="bi bi-building"></i>Barber</button>
                    </div>
                </div>
                <div class="col-lg-9 bg-light">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- my address -->
                        <div class="tab-pane fade show active" id="v-pills-my-address" role="tabpanel" tabindex="0"
                            aria-labelledby="#v-pills-my-address-tab">
                            <div class="row m-0">
                                <div class="col-lg-9 p-0">
                                    <div class="tab-content border-start bg-white" id="v-pills-tabContent">
                                        <!-- snaks & munchies -->
                                        <div id="v-pills-snaks" role="tabpanel" tabindex="0"
                                            aria-labelledby="#v-pills-snaks-tab">
                                            <div
                                                class="d-flex align-items-center justify-content-between p-3 border-bottom border-end">
                                                <h5 class="fw-bold m-0">Layanan Barber</h5>
                                            </div>
                                            <!-- chips -->
                                            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-0">
                                                @forelse ($layanans as $layanan)
                                                    <div class="col shop-list-page border-bottom border-end">
                                                        <div
                                                            class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">
                                                            <a href="product-detail.html">
                                                                @if ($barber->gambar)
                                                                    <img class="card-img-top"
                                                                        src="{{ asset('storage/' . $barber->gambar) }}"
                                                                        alt="Logo" width="40">
                                                                @else
                                                                    <img class="card-img-top"
                                                                        src="{{ asset('storage/' . $aplikasi->logo) }}"
                                                                        alt="Logo" width="40">
                                                                @endif
                                                            </a>
                                                            <div class="card-body pt-0">
                                                                <h6 class="card-title fw-bold">
                                                                    {{ $layanan->nama }}
                                                                </h6>
                                                                <p class="text-muted small m-0">Durasi Layanan
                                                                    ({{ $layanan->durasi }} menit)
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="card-footer bg-transparent border-0 d-flex align-items-end justify-content-between pt-0 gap-3 text-end">
                                                                <h6 class="fw-bold m-0">
                                                                    Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                                                </h6>
                                                                <a href="#"
                                                                    class="btn btn-danger rounded-pill text-link text-decoration-none btn-sm text-start"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#layanan{{ $layanan->id }}"><i
                                                                        class="bi bi-cart4 me-1"></i> Pilih
                                                                    Layanan</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="layanan{{ $layanan->id }}"
                                                        aria-hidden="true" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content border-0 rounded-4 overflow-hidden">
                                                                <div class="modal-body p-0">
                                                                    <div class="row g-0">
                                                                        <div class="col-lg-6 p-4">
                                                                            <button type="button"
                                                                                class="btn-close float-end shadow-none"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                            <div class="mb-3 pe-5">
                                                                                <h6 class="fw-bold mb-1">
                                                                                    Layanan {{ $layanan->nama }} </h6>
                                                                                <p class="text-muted small m-0">Selesaikan
                                                                                    waktu pemesanan anda </p>
                                                                            </div>
                                                                            <form action="{{ route('barber.booking') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="barber_id"
                                                                                    value="{{ $barber->id }}">
                                                                                <input type="hidden" name="layanan_id"
                                                                                    value="{{ $layanan->id }}">

                                                                                <div class="form-floating mb-3">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="name"
                                                                                        value="{{ Auth::user()->name }}"
                                                                                        disabled>
                                                                                    <label for="floatingInput">Nama
                                                                                        Pelanggan</label>
                                                                                </div>
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="date"
                                                                                        class="form-control datepicker @error('tanggal_pemesanan') is-invalid @enderror"
                                                                                        id="tanggal_pemesanan"
                                                                                        name="tanggal_pemesanan"
                                                                                        placeholder="Pilih Tanggal"
                                                                                        value="{{ old('tanggal_pemesanan') }}">
                                                                                    <label for="tanggal_pemesanan">Tanggal
                                                                                        Pemesanan</label>
                                                                                    @error('tanggal_pemesanan')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-floating mb-3">
                                                                                    <input type="time"
                                                                                        class="form-control timepicker @error('waktu_pemesanan') is-invalid @enderror"
                                                                                        id="waktu_pemesanan"
                                                                                        name="waktu_pemesanan"
                                                                                        value="{{ old('waktu_pemesanan') }}"
                                                                                        placeholder="Pilih Waktu">
                                                                                    <label for="waktu_pemesanan">Waktu
                                                                                        Pemesanan</label>
                                                                                    @error('waktu_pemesanan')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-floating mb-3">
                                                                                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan">{{ old('catatan') }}
                                                                                    </textarea>
                                                                                    <label for="floatingInput">Catatan
                                                                                        tambahan untuk barber</label>
                                                                                    @error('catatan')
                                                                                        <div class="text-danger">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger fw-bold py-3 px-4 w-100 rounded-4 shadow">
                                                                                    <i class="fa fa-paper-plane"></i> Kirim
                                                                                    Pesanan
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-danger" role="alert">
                                                        Data layanan belum tersedia.
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- my orders -->
                        <div class="tab-pane fade" id="v-pills-my-order" role="tabpanel" tabindex="0"
                            aria-labelledby="#v-pills-my-order-tab">
                            <div class="row m-0">
                                <div class="col-lg-9 p-0">
                                    <div class="tab-content border-start bg-white" id="v-pills-tabContent">
                                        <!-- snaks & munchies -->
                                        <div id="v-pills-snaks" role="tabpanel" tabindex="0"
                                            aria-labelledby="#v-pills-snaks-tab">
                                            <div
                                                class="d-flex align-items-center justify-content-between p-3 border-bottom border-end">
                                                <h5 class="fw-bold m-0">Jadwal Operasional</h5>
                                            </div>
                                            <!-- chips -->
                                            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-0">
                                                @forelse ($jadwals as $jadwal)
                                                    <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                                        <div
                                                            class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                                            <div class="card-body pt-0">
                                                                <h6 class="card-title fw-bold">
                                                                    {{ $jadwal->nama_hari }}
                                                                </h6>
                                                                <p class="text-muted small m-0">
                                                                    @if ($jadwal->hari_kerja)
                                                                        Buka :
                                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->waktu_buka)->format('H:i') }}
                                                                        | Tutup :
                                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->waktu_tutup)->format('H:i') }}
                                                                    @else
                                                                        <del>
                                                                            Buka :
                                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->waktu_buka)->format('H:i') }}
                                                                            | Tutup :
                                                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->waktu_tutup)->format('H:i') }}
                                                                        </del>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="card-footer bg-transparent border-0 d-flex align-items-end justify-content-between pt-0 gap-3 text-end">
                                                                <h6 class="fw-bold m-0">
                                                                    @if ($jadwal->hari_kerja)
                                                                        <small
                                                                            class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm">Hari
                                                                            Kerja</small>
                                                                    @else
                                                                        <small
                                                                            class="badge bg-danger-subtle text-danger rounded-pill fw-normal small-sm">Hari
                                                                            Libur</small>
                                                                    @endif
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="alert alert-danger" role="alert">
                                                        Data jadwal operasional belum tersedia.
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- my wallet -->
                        <div class="tab-pane fade bg-white" id="v-pills-my-wallet" role="tabpanel" tabindex="0"
                            aria-labelledby="#v-pills-my-wallet-tab">
                            <div class="d-flex align-items-center justify-content-between p-3 border-bottom border-end">
                                <h4 class="m-0">Data Detail Barber</h4>
                            </div>
                            <div class="row p-3">
                                <div class="col-lg-6 col-12 py-3">
                                    <div class="mb-lg-5">
                                        <div class="big-img overflow-hidden mb-3 mx-2 slick-initialized slick-slider"
                                            style="display: block;">
                                            <div class="big-img-1">
                                                @if ($barber->gambar)
                                                    <img class="img-fluid d-block mx-auto"
                                                        src="{{ asset('storage/' . $barber->gambar) }}" alt="Logo">
                                                @else
                                                    <img class="img-fluid d-block mx-auto"
                                                        src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Product Details -->
                                    <div class="product-details pt-4">
                                        <h4 class="fw-bold pb-3">{{ $barber->nama }}</h4>
                                        <div class="mb-4">
                                            <h6 class="fw-bold">Data Barber</h6>
                                            <ul class="list-unstyled d-grid gap-1 text-muted">
                                                <li><span class="text-dark">Pemilik:</span> {{ $barber->nama_pemilik }}
                                                </li>
                                                <li><span class="text-dark">Telepon:</span> <a
                                                        href="tel:{{ $barber->telepon }}"
                                                        class="__cf_email__">{{ $barber->telepon }}</a></li>
                                                <li><span class="text-dark">Email:</span> <a
                                                        href="mailto:{{ $barber->email }}"
                                                        class="__cf_email__">{{ $barber->email }}</a></li>
                                                <li><span class="text-dark">Alamat:</span> <br> {{ $barber->alamat }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold">Deskripsi</h6>
                                            <p class="text-muted m-0">{{ $barber->deskripsi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
