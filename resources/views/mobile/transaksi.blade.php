@extends('layouts.mobile')
@section('title')
    Transaksi
@endsection
@section('content')
    @if ($pemesananAktif)
        <section class="py-3">
            <div class="container px-3">
                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                    <h5 class="m-0">Pemesanan Aktif</h5>
                </div>
                <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-3 osahan-my-orders">
                    <div class="col">
                        <div data-bs-toggle="offcanvas" data-bs-target="#viewdetails" aria-controls="viewdetails"
                            class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                            <div class="w-75">
                                <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                    <i class="lni lni-shopping-basket text-success fs-4"></i>
                                    <div>
                                        @if ($pemesananAktif->status == 'menunggu')
                                            <small
                                                class="badge bg-warning-subtle text-warning rounded-pill fw-normal small-sm mb-2">Menunggu
                                                Konfirmasi</small>
                                        @elseif($pemesananAktif->status == 'dikonfirmasi')
                                            <small
                                                class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm mb-2">Dikonfirmasi
                                                - Menunggu Antrian</small>
                                        @endif
                                        <h6 class="fw-bold mb-1 d-flex align-items-center">
                                            {{ $pemesananAktif->layanan->nama }} </h6>
                                        <p class="text-muted text-truncate mb-0 small">
                                            {{ \Carbon\Carbon::parse($antrianAktif->tanggal_antrian)->locale('id')->translatedFormat('l, d F Y') }}
                                            {{ \Carbon\Carbon::parse($antrianAktif->waktu_antrian)->locale('id')->translatedFormat('H:i') }}
                                        </p>
                                        <p class="text-muted text-truncate mb-0 small">
                                            <strong>Barber:</strong> {{ $pemesananAktif->barber->nama }}<br>
                                            @if ($antrianAktif)
                                                <strong>Estimasi Waktu:</strong>
                                                {{ \Carbon\Carbon::parse($antrianAktif->waktu_antrian)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @if ($antrianAktif)
                                <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                    <a href="#" class="small" style="line-height: 0.4;">
                                        <h1>{{ $antrianAktif->nomor_antrian }}</h1><br>Nomor Antrian
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="py-3">
        <div class="container px-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="m-0">Riwayat Pemesanan Terbaru</h5>
            </div>
            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-3 osahan-my-orders">
                @forelse ($riwayatTerbaru as $riwayat)
                    <div class="col">
                        <div data-bs-toggle="offcanvas" data-bs-target="#viewdetails" aria-controls="viewdetails"
                            class="d-flex align-items-center justify-content-between bg-white border p-3 rounded-3">
                            <div class="w-75">
                                <div class="d-flex align-items-center gap-3 osahan-mb-1">
                                    <i class="lni lni-shopping-basket text-success fs-4"></i>
                                    <div>
                                        @if ($riwayat->status == 'menunggu')
                                            <small
                                                class="badge bg-warning-subtle text-warning rounded-pill fw-normal small-sm mb-2">Menunggu</small>
                                        @elseif($riwayat->status == 'dikonfirmasi')
                                            <small
                                                class="badge bg-info-subtle text-info rounded-pill fw-normal small-sm mb-2">Dikonfirmasi</small>
                                        @elseif($riwayat->status == 'dalam_pengerjaan')
                                            <small
                                                class="badge bg-primary-subtle text-primary rounded-pill fw-normal small-sm mb-2">Dalam
                                                Pengerjaan</small>
                                        @elseif($riwayat->status == 'selesai')
                                            <small
                                                class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm mb-2">Selesai</small>
                                        @elseif($riwayat->status == 'dibatalkan')
                                            <small
                                                class="badge bg-danger-subtle text-danger rounded-pill fw-normal small-sm mb-2">Dibatalkan</small>
                                        @endif
                                        <h6 class="fw-bold mb-1 d-flex align-items-center">
                                            {{ $riwayat->layanan->nama }} </h6>
                                        <p class="text-muted text-truncate mb-0 small">
                                            {{ \Carbon\Carbon::parse($riwayat->waktu_pemesanan)->locale('id')->translatedFormat('l, d F Y, H:i') }}
                                        </p>
                                        <p class="text-muted text-truncate mb-0 small">
                                            <strong>Barber:</strong> {{ $riwayat->barber->nama }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="ms-auto d-flex align-items-center gap-3 text-center small">
                                <a href="{{ route('transaksi.detail', $riwayat->transaksi->id) }}" class="small"><i
                                        class="lni lni-eye fs-6"></i><br>View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger" role="alert">
                        Data transaksi belum tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
