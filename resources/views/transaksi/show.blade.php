@extends('layouts.master')
@section('title')
    Detail Transaksi #{{ $transaksi->id }}
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Transaksi
        @endslot
        @slot('li_2')
            Daftar Transaksi
        @endslot
        @slot('title')
            Detail Transaksi
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Informasi Transaksi</h3>
                <div class="pull-right box-tools d-flex">
                    @if ($transaksi->status_pembayaran == 'menunggu')
                        {{-- <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-social btn-sm btn-info"
                                onclick="return confirm('Konfirmasi pembayaran ini?')">
                                <i class="fa fa-check"></i> Konfirmasi Pembayaran
                            </button>
                        </form> --}}

                        <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-social btn-sm btn-info"
                            style="margin-left: 10px;">
                            <i class="fa fa-edit"></i> Update Status
                        </a>
                    @endif

                    <a href="{{ route('transaksi.index') }}" class="btn btn-social btn-sm btn-default"
                        style="margin-left: 10px;">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <td style="width: 200px;"><strong>ID Transaksi</strong></td>
                        <td style="width: 10px;">:</td>
                        <td>{{ $transaksi->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>ID Pemesanan</strong></td>
                        <td>:</td>
                        <td>
                            <a href="{{ route('pemesanan.show', $transaksi->pemesanan->id) }}">
                                #{{ $transaksi->pemesanan->id }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status Pembayaran</strong></td>
                        <td>:</td>
                        <td>
                            @if ($transaksi->status_pembayaran == 'menunggu')
                                <span class="label label-warning">Menunggu</span>
                            @elseif($transaksi->status_pembayaran == 'dibayar')
                                <span class="label label-success">Dibayar</span>
                            @elseif($transaksi->status_pembayaran == 'gagal')
                                <span class="label label-danger">Gagal</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td>:</td>
                        <td>Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Metode Pembayaran</strong></td>
                        <td>:</td>
                        <td>
                            @if ($transaksi->metode_pembayaran)
                                {{ ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}
                            @else
                                <span class="text-muted">Belum diisi</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Referensi Pembayaran</strong></td>
                        <td>:</td>
                        <td>{{ $transaksi->referensi_pembayaran ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Pembuatan</strong></td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('l, d F Y H:i') }}
                        </td>
                    </tr>
                    @if ($transaksi->tanggal_pembayaran)
                        <tr>
                            <td><strong>Tanggal Pembayaran</strong></td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->locale('id')->translatedFormat('l, d F Y H:i') }}
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Pemesanan</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped">
                            <tr>
                                <td style="width: 200px;"><strong>ID Pemesanan</strong></td>
                                <td style="width: 10px;">:</td>
                                <td>{{ $transaksi->pemesanan->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Pemesanan</strong></td>
                                <td>:</td>
                                <td>
                                    @if ($transaksi->pemesanan->status == 'menunggu')
                                        <span class="label label-warning">Menunggu</span>
                                    @elseif($transaksi->pemesanan->status == 'dikonfirmasi')
                                        <span class="label label-info">Dikonfirmasi</span>
                                    @elseif($transaksi->pemesanan->status == 'dalam_pengerjaan')
                                        <span class="label label-primary">Dalam Pengerjaan</span>
                                    @elseif($transaksi->pemesanan->status == 'selesai')
                                        <span class="label label-success">Selesai</span>
                                    @elseif($transaksi->pemesanan->status == 'dibatalkan')
                                        <span class="label label-danger">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Layanan</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->pemesanan->layanan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal & Waktu</strong></td>
                                <td>:</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($transaksi->pemesanan->waktu_pemesanan)->locale('id')->translatedFormat('l, d F Y') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

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
                                <td>{{ $transaksi->user->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->user->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->user->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>:</td>
                                <td>{{ $transaksi->user->alamat ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
