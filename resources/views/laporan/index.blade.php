@extends('layouts.master')
@section('title')
    Laporan
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Laporan
        @endslot
        @slot('li_2')
            Laporan
        @endslot
        @slot('title')
            Laporan
        @endslot
    @endcomponent

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Laporan</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('laporan.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jenis_laporan">Jenis Laporan:</label>
                                        <select name="jenis_laporan" id="jenis_laporan" class="form-control">
                                            <option value="pemesanan"
                                                {{ request('jenis_laporan') == 'pemesanan' ? 'selected' : '' }}>Data
                                                Pemesanan Selesai</option>
                                            <option value="keuangan"
                                                {{ request('jenis_laporan') == 'keuangan' ? 'selected' : '' }}>Keuangan
                                                (Pendapatan)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="dari_tanggal">Dari Tanggal:</label>
                                        <input type="date" name="dari_tanggal" id="dari_tanggal" class="form-control"
                                            value="{{ request('dari_tanggal') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sampai_tanggal">Sampai Tanggal:</label>
                                        <input type="date" name="sampai_tanggal" id="sampai_tanggal" class="form-control"
                                            value="{{ request('sampai_tanggal') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">Cari:</label>
                                        <input type="text" name="search" id="search" class="form-control"
                                            placeholder="Cari..." value="{{ request('search') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                    @if (request('dari_tanggal') && request('sampai_tanggal'))
                                        <a href="#" class="btn btn-success" id="btnCetak" data-toggle="modal"
                                            data-target="#modalCetak">
                                            <i class="fa fa-print"></i> Cetak / Export
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (request('dari_tanggal') && request('sampai_tanggal'))
            @if (request('jenis_laporan') == 'pemesanan')
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Data Pemesanan Selesai</h3>
                                <small class="pull-right">
                                    Periode:
                                    {{ \Carbon\Carbon::parse(request('dari_tanggal'))->locale('id')->translatedFormat('d F Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse(request('sampai_tanggal'))->locale('id')->translatedFormat('d F Y') }}
                                </small>
                            </div>
                            <div class="box-body no-padding">
                                @if ($queryPemesanan && $queryPemesanan->isNotEmpty())
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Pemesanan</th>
                                                <th>Pelanggan</th>
                                                <th>Layanan</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($queryPemesanan as $pemesanan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pemesanan->id }}</td>
                                                    <td>{{ $pemesanan->user->name ?? '-' }}</td>
                                                    <td>{{ $pemesanan->layanan->nama ?? '-' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->locale('id')->translatedFormat('d M Y') }}
                                                    </td>
                                                    <td>{{ $pemesanan->waktu_pemesanan }}</td>
                                                    <td>Rp
                                                        {{ number_format($pemesanan->layanan->harga ?? 0, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info" style="margin: 15px;">
                                        <h4><i class="icon fa fa-info"></i> Informasi</h4>
                                        Tidak ada data pemesanan selesai dalam periode yang dipilih.
                                    </div>
                                @endif
                            </div>
                            @if ($queryPemesanan && $queryPemesanan->hasPages())
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        {{ $queryPemesanan->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif(request('jenis_laporan') == 'keuangan')
                <div class="row">
                    <div class="col-md-12">
                        <div class="callout callout-info">
                            <h4><i class="fa fa-line-chart"></i> Ringkasan Keuangan</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Total Pendapatan:</strong> <span class="text-green">Rp
                                            {{ number_format($totalPendapatan, 0, ',', '.') }}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Jumlah Pemesanan Selesai:</strong> {{ $jumlahPemesanan }} transaksi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Data Transaksi (Pendapatan)</h3>
                                <small class="pull-right">
                                    Periode:
                                    {{ \Carbon\Carbon::parse(request('dari_tanggal'))->locale('id')->translatedFormat('d F Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse(request('sampai_tanggal'))->locale('id')->translatedFormat('d F Y') }}
                                </small>
                            </div>
                            <div class="box-body no-padding">
                                @if ($queryKeuangan && $queryKeuangan->isNotEmpty())
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID Transaksi</th>
                                                <th>ID Pemesanan</th>
                                                <th>Pelanggan</th>
                                                <th>Layanan</th>
                                                <th>Tanggal Transaksi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($queryKeuangan as $transaksi)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $transaksi->id }}</td>
                                                    <td>{{ $transaksi->pemesanan->id ?? '-' }}</td>
                                                    <td>{{ $transaksi->user->nama ?? '-' }}</td>
                                                    <td>{{ $transaksi->pemesanan->layanan->nama ?? '-' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->locale('id')->translatedFormat('d M Y H:i') }}
                                                    </td>
                                                    <td>Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info" style="margin: 15px;">
                                        <h4><i class="icon fa fa-info"></i> Informasi</h4>
                                        Tidak ada data transaksi dalam periode yang dipilih.
                                    </div>
                                @endif
                            </div>
                            @if ($queryKeuangan && $queryKeuangan->hasPages())
                                <div class="box-footer clearfix">
                                    <div class="pull-right">
                                        {{ $queryKeuangan->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <h4><i class="icon fa fa-warning"></i> Perhatian</h4>
                        Silakan pilih periode tanggal dan jenis laporan terlebih dahulu.
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- Modal Cetak -->
    <div class="modal fade" id="modalCetak" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('laporan.cetak') }}" method="GET" target="_blank">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Cetak / Export Laporan</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="dari_tanggal_cetak" value="{{ request('dari_tanggal') }}">
                        <input type="hidden" name="sampai_tanggal_cetak" value="{{ request('sampai_tanggal') }}">
                        <input type="hidden" name="jenis_laporan_cetak" value="{{ request('jenis_laporan') }}">

                        <div class="form-group">
                            <label for="format">Pilih Format:</label>
                            <select name="format" id="format" class="form-control" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                        <p class="text-muted">
                            <i class="fa fa-info-circle"></i> Laporan akan dibuka di tab baru untuk dicetak atau diunduh.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-print"></i> Cetak / Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#btnCetak').on('click', function() {
                var dari = '{{ request('dari_tanggal') }}';
                var sampai = '{{ request('sampai_tanggal') }}';
                var jenis = '{{ request('jenis_laporan') }}';

                $('input[name="dari_tanggal_cetak"]').val(dari);
                $('input[name="sampai_tanggal_cetak"]').val(sampai);
                $('input[name="jenis_laporan_cetak"]').val(jenis);
            });

            // Ganti action form berdasarkan format
            $('#modalCetak #format').on('change', function() {
                var format = $(this).val();
                var form = $('#modalCetak form');

                if (format === 'excel') {
                    form.attr('action', '{{ route('laporan.export-excel') }}');
                } else {
                    form.attr('action', '{{ route('laporan.cetak') }}');
                }
            }).trigger('change'); // Trigger saat pertama kali load
        });
    </script>
@endpush
