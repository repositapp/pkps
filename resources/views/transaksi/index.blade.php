@extends('layouts.master')
@section('title')
    Manajemen Transaksi
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
            Daftar Transaksi
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('transaksi.index') }}" method="GET" class="form-inline">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control pull-right"
                                    placeholder="Cari ID/Ref Pembayaran/Pelanggan..." value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <select name="status" class="form-control input-sm" onchange="this.form.submit()">
                                <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua
                                    Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                                    Menunggu</option>
                                <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>
                                    Dibayar</option>
                                <option value="gagal" {{ request('status') == 'gagal' ? 'selected' : '' }}>Gagal
                                </option>
                            </select>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <!-- Tombol tambahan bisa ditambahkan di sini -->
                    </div>
                </div>
            </div>

            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px">No.</th>
                                <th scope="col">Pelanggan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal</th>
                                <th class="text-center" style="width: 80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksis as $transaksi)
                                <tr>
                                    <td class="text-center">{{ $transaksis->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a href="{{ route('pemesanan.show', $transaksi->pemesanan->id) }}">
                                            {{ $transaksi->user->name ?? '-' }}
                                        </a>
                                    </td>
                                    <td>Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($transaksi->status_pembayaran == 'menunggu')
                                            <span class="label label-warning">Menunggu</span>
                                        @elseif($transaksi->status_pembayaran == 'dibayar')
                                            <span class="label label-success">Dibayar</span>
                                        @elseif($transaksi->status_pembayaran == 'gagal')
                                            <span class="label label-danger">Gagal</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaksi->tanggal_pembayaran)
                                            {{ \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->locale('id')->translatedFormat('d F Y H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                                class="btn btn-default btn-sm text-blue" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if ($transaksi->status_pembayaran == 'menunggu')
                                                <a href="{{ route('transaksi.edit', $transaksi->id) }}"
                                                    class="btn btn-default btn-sm text-green" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            {{-- @if ($transaksi->status_pembayaran == 'menunggu')
                                                <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}"
                                                    method="POST" style="display:inline;" title="Konfirmasi Pembayaran">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-default btn-sm text-green"
                                                        onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Data transaksi belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan {{ $transaksis->firstItem() }} hingga {{ $transaksis->lastItem() }} dari
                        {{ $transaksis->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $transaksis->appends(['search' => $search, 'status' => $statusFilter])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
