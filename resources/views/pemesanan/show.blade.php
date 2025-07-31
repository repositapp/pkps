@extends('layouts.master')
@section('title')
    Detail Pemesanan #{{ $pemesanan->id }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Pemesanan
        @endslot
        @slot('li_2')
            Daftar Pemesanan
        @endslot
        @slot('title')
            Detail Pemesanan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Informasi Pemesanan & Layanan</h3>
                <div class="pull-right box-tools">
                    @if ($pemesanan->status == 'menunggu')
                        <form action="{{ route('pemesanan.konfirmasi', $pemesanan->id) }}" method="POST"
                            style="display: inline-block;" title="Konfirmasi">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-social btn-sm btn-success">
                                <i class="fa fa-check"></i> Konfirmasi
                            </button>
                        </form>
                    @elseif($pemesanan->status == 'dikonfirmasi')
                        <form action="{{ route('pemesanan.proses', $pemesanan->id) }}" method="POST"
                            style="display: inline-block;" title="Proses">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-social btn-sm btn-warning">
                                <i class="fa fa-cogs"></i> Mulai Proses
                            </button>
                        </form>
                    @elseif($pemesanan->status == 'dalam_pengerjaan')
                        <form action="{{ route('pemesanan.selesai', $pemesanan->id) }}" method="POST"
                            style="display: inline-block;" title="Selesai">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-social btn-sm btn-primary">
                                <i class="fa fa-check-circle"></i> Tandai Selesai
                            </button>
                        </form>
                    @endif

                    @if (in_array($pemesanan->status, ['menunggu']))
                        <form action="{{ route('pemesanan.batalkan', $pemesanan->id) }}" method="POST"
                            style="display: inline-block; margin-top: 5px;"
                            onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')" title="Batalkan">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-social btn-sm btn-danger">
                                <i class="fa fa-times"></i> Batalkan
                            </button>
                        </form>
                    @endif

                    <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <td style="width: 200px;"><strong>Status</strong></td>
                        <td style="width: 10px;">:</td>
                        <td>
                            @if ($pemesanan->status == 'menunggu')
                                <span class="label label-warning">Menunggu</span>
                            @elseif($pemesanan->status == 'dikonfirmasi')
                                <span class="label label-info">Dikonfirmasi</span>
                            @elseif($pemesanan->status == 'dalam_pengerjaan')
                                <span class="label label-primary">Dalam Pengerjaan</span>
                            @elseif($pemesanan->status == 'selesai')
                                <span class="label label-success">Selesai</span>
                            @elseif($pemesanan->status == 'dibatalkan')
                                <span class="label label-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td style="width: 200px;"><strong>Nama Layanan</strong></td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $pemesanan->layanan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pemesanan</strong></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->locale('id')->translatedFormat('l, d F Y') }}
                        </td>
                        <td><strong>Deskripsi</strong></td>
                        <td>:</td>
                        <td>{{ $pemesanan->layanan->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Waktu Pemesanan</strong></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($pemesanan->waktu_pemesanan)->locale('id')->translatedFormat('H:i') }}
                        </td>
                        <td><strong>Durasi</strong></td>
                        <td>:</td>
                        <td>{{ $pemesanan->layanan->durasi ?? 0 }} menit</td>
                    </tr>
                    <tr>
                        <td><strong>Catatan Pelanggan</strong></td>
                        <td>:</td>
                        <td>{{ $pemesanan->catatan ?? '-' }}</td>
                        <td><strong>Harga</strong></td>
                        <td>:</td>
                        <td>Rp {{ number_format($pemesanan->layanan->harga ?? 0, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            @if ($pemesanan->transaksi)
                <div class="col-md-6">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Pelanggan</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <tr>
                                    <td style="width: 200px;"><strong>Nama</strong></td>
                                    <td style="width: 10px;">:</td>
                                    <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>:</td>
                                    <td>{{ $pemesanan->user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telepon</strong></td>
                                    <td>:</td>
                                    <td>{{ $pemesanan->user->telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>:</td>
                                    <td>{{ $pemesanan->user->alamat ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Transaksi</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <tr>
                                    <td style="width: 200px;"><strong>Jumlah</strong></td>
                                    <td style="width: 10px;">:</td>
                                    <td>Rp {{ number_format($pemesanan->transaksi->jumlah ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Metode</strong></td>
                                    <td>:</td>
                                    <td>
                                        @if ($pemesanan->transaksi->metode_pembayaran)
                                            {{ ucfirst(str_replace('_', ' ', $pemesanan->transaksi->metode_pembayaran)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status</strong></td>
                                    <td>:</td>
                                    <td>
                                        @if ($pemesanan->transaksi->status_pembayaran == 'menunggu')
                                            <span class="label label-warning">Menunggu</span>
                                        @elseif($pemesanan->transaksi->status_pembayaran == 'dibayar')
                                            <span class="label label-success">Dibayar</span>
                                        @elseif($pemesanan->transaksi->status_pembayaran == 'gagal')
                                            <span class="label label-danger">Gagal</span>
                                        @endif
                                    </td>
                                </tr>
                                @if ($pemesanan->transaksi->tanggal_pembayaran)
                                    <tr>
                                        <td><strong>Tanggal Bayar</strong></td>
                                        <td>:</td>
                                        <td>{{ \Carbon\Carbon::parse($pemesanan->transaksi->tanggal_pembayaran)->locale('id')->translatedFormat('d F Y H:i') }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Pelanggan</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped">
                                <tr>
                                    <td style="width: 200px;"><strong>Nama</strong></td>
                                    <td style="width: 10px;">:</td>
                                    <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td>:</td>
                                    <td>{{ $pemesanan->user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telepon</strong></td>
                                    <td>:</td>
                                    <td>{{ $pemesanan->user->telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td>:</td>
                                    <td>{{ $pemesanan->user->alamat ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
