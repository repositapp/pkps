@extends('layouts.master')
@section('title')
    Manajemen Pemesanan
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
            Daftar Pemesanan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-12 align-items-center">
                        <form action="{{ route('pemesanan.index') }}" method="GET" class="form-inline">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control pull-right"
                                    placeholder="Cari ID/Nama Pelanggan/Layanan..." value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <select name="status" class="form-control input-sm" onchange="this.form.submit()">
                                <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua
                                    Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>
                                    Menunggu</option>
                                <option value="dikonfirmasi" {{ request('status') == 'dikonfirmasi' ? 'selected' : '' }}>
                                    Dikonfirmasi
                                </option>
                                <option value="dalam_pengerjaan"
                                    {{ request('status') == 'dalam_pengerjaan' ? 'selected' : '' }}>Dalam Pengerjaan
                                </option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                    Selesai</option>
                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                            <a href="{{ route('pemesanan.index') }}" class="btn btn-default btn-sm"><i
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
                                <th scope="col">Layanan</th>
                                <th scope="col">Tanggal & Waktu</th>
                                <th scope="col">Status</th>
                                <th class="text-center" style="width: 80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemesanans as $pemesanan)
                                <tr>
                                    <td class="text-center">{{ $pemesanans->firstItem() + $loop->index }}</td>
                                    <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                    <td>{{ $pemesanan->layanan->nama ?? '-' }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($pemesanan->waktu_pemesanan)->locale('id')->translatedFormat('d F Y, H:i') }}
                                    </td>
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
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('pemesanan.show', $pemesanan->id) }}"
                                                class="btn btn-default btn-sm text-blue" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if ($pemesanan->status == 'menunggu')
                                                <form action="{{ route('pemesanan.konfirmasi', $pemesanan->id) }}"
                                                    method="POST" style="display:inline;" title="Konfirmasi">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-default btn-sm text-green">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @elseif($pemesanan->status == 'dikonfirmasi')
                                                <form action="{{ route('pemesanan.proses', $pemesanan->id) }}"
                                                    method="POST" style="display:inline;" title="Proses">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-default btn-sm text-orange">
                                                        <i class="fa fa-cogs"></i>
                                                    </button>
                                                </form>
                                            @elseif($pemesanan->status == 'dalam_pengerjaan')
                                                <form action="{{ route('pemesanan.selesai', $pemesanan->id) }}"
                                                    method="POST" style="display:inline;" title="Selesai">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-default btn-sm text-purple">
                                                        <i class="fa fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if (in_array($pemesanan->status, ['menunggu']))
                                                <form action="{{ route('pemesanan.batalkan', $pemesanan->id) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')"
                                                    title="Batalkan">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-default btn-sm text-red">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data pemesanan belum tersedia.
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
                        Menampilkan {{ $pemesanans->firstItem() }} hingga {{ $pemesanans->lastItem() }} dari
                        {{ $pemesanans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $pemesanans->appends(['search' => $search, 'status' => $statusFilter])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
