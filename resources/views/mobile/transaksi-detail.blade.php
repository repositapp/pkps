@extends('layouts.mobile')
@section('title')
    Detail Transaksi
@endsection
@section('content')
    <section class="p-0">
        <div class="container p-0">
            <div class="row border osahan-my-account-page border-secondary-subtle g-0 col-lg-8 mx-auto overflow-hidden">
                <div class="col-lg-9 bg-light">
                    <div class="tab-content border-start bg-white" id="v-pills-tabContent">
                        <!-- snaks & munchies -->
                        <div id="v-pills-snaks" role="tabpanel" tabindex="0" aria-labelledby="#v-pills-snaks-tab">
                            <!-- chips -->
                            <div class="row row-cols-xl-1 row-cols-lg-1 row-cols-md-1 row-cols-1 g-0">
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">ID Pemesanan</p>
                                            <h6 class="card-title fw-bold">
                                                {{ $transaksi->pemesanan->id }}
                                            </h6>
                                        </div>
                                        <div
                                            class="card-footer bg-transparent border-0 d-flex align-items-end justify-content-between pt-0 gap-3 text-end">
                                            <h6 class="fw-bold m-0">
                                                @if ($transaksi->pemesanan->status == 'menunggu')
                                                    <small
                                                        class="badge bg-warning-subtle text-warning rounded-pill fw-normal small-sm mb-2">Menunggu</small>
                                                @elseif($transaksi->pemesanan->status == 'dikonfirmasi')
                                                    <small
                                                        class="badge bg-info-subtle text-info rounded-pill fw-normal small-sm mb-2">Dikonfirmasi</small>
                                                @elseif($transaksi->pemesanan->status == 'dalam_pengerjaan')
                                                    <small
                                                        class="badge bg-primary-subtle text-primary rounded-pill fw-normal small-sm mb-2">Dalam
                                                        Pengerjaan</small>
                                                @elseif($transaksi->pemesanan->status == 'selesai')
                                                    <small
                                                        class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm mb-2">Selesai</small>
                                                @elseif($transaksi->pemesanan->status == 'dibatalkan')
                                                    <small
                                                        class="badge bg-danger-subtle text-danger rounded-pill fw-normal small-sm mb-2">Dibatalkan</small>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">Layanan</p>
                                            <h6 class="card-title fw-bold">
                                                {{ $transaksi->pemesanan->layanan->nama ?? '-' }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">Tanggal & Waktu</p>
                                            <h6 class="card-title fw-bold">
                                                {{ \Carbon\Carbon::parse($transaksi->pemesanan->waktu_pemesanan)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">ID Transaksi Pembayaran</p>
                                            <h6 class="card-title fw-bold">
                                                {{ $transaksi->id }}
                                            </h6>
                                        </div>
                                        <div
                                            class="card-footer bg-transparent border-0 d-flex align-items-end justify-content-between pt-0 gap-3 text-end">
                                            <h6 class="fw-bold m-0">
                                                @if ($transaksi->status_pembayaran == 'menunggu')
                                                    <small
                                                        class="badge bg-warning-subtle text-warning rounded-pill fw-normal small-sm mb-2">Menunggu
                                                        Pembayaran</small>
                                                @elseif($transaksi->status_pembayaran == 'dibayar')
                                                    <small
                                                        class="badge bg-success-subtle text-success rounded-pill fw-normal small-sm mb-2">Dibayar</small>
                                                @elseif($transaksi->status_pembayaran == 'gagal')
                                                    <small
                                                        class="badge bg-danger-subtle text-danger rounded-pill fw-normal small-sm mb-2">Gagal</small>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">Jumlah</p>
                                            <h6 class="card-title fw-bold">
                                                Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">Metode Pembayaran</p>
                                            <h6 class="card-title fw-bold">
                                                @if ($transaksi->metode_pembayaran)
                                                    {{ ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}
                                                @else
                                                    Belum diisi
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">Tanggal Pembuatan</p>
                                            <h6 class="card-title fw-bold">
                                                {{ \Carbon\Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col shop-list-page border-bottom border-end p-3 px-3">
                                    <div
                                        class="d-flex align-items-center bg-transparent border-0 rounded-0 h-100 osahan-card-list pe-3">

                                        <div class="card-body pt-0">
                                            <p class="text-muted small m-0">Tanggal Pembayaran</p>
                                            <h6 class="card-title fw-bold">
                                                {{ \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->locale('id')->translatedFormat('l, d F Y H:i') }}
                                            </h6>
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
