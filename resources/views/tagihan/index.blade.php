@extends('layouts.master')
@section('title')
    Data Tagihan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Tagihan
        @endslot
        @slot('li_2')
            Daftar Tagihan
        @endslot
        @slot('title')
            Data Tagihan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <form action="{{ route('tagihan.index') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control input-sm"
                                    placeholder="Cari nama, no. sambungan..." value="{{ $search ?? '' }}">
                            </div>
                            <div class="form-group">
                                <select name="bulan" class="form-control input-sm">
                                    <option value="">-- Semua Bulan --</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ isset($bulan) && $bulan == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::createFromFormat('m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="tahun" class="form-control input-sm">
                                    <option value="">-- Semua Tahun --</option>
                                    @foreach ($tahunList as $thn)
                                        <option value="{{ $thn }}"
                                            {{ isset($tahun) && $tahun == $thn ? 'selected' : '' }}>
                                            {{ $thn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i>
                                Filter</button>
                            <a href="{{ route('tagihan.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right" style="margin-top: 10px;">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('tagihan.create') }}" class="btn btn-social btn-sm btn-info">
                                <i class="fa fa-plus"></i> Tambah Tagihan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px">No.</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">No. Sambungan</th>
                            <th scope="col">Periode</th>
                            <th scope="col">Meter Awal</th>
                            <th scope="col">Meter Akhir</th>
                            <th scope="col">Volume (m³)</th>
                            <th scope="col">Total Tagihan</th>
                            <th scope="col">Pembaca Meter</th>
                            <th scope="col">Status Bayar</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tagihans as $tagihan)
                            <tr>
                                <td class="text-center">{{ $tagihans->firstItem() + $loop->index }}</td>
                                <td>{{ $tagihan->pelanggan->nama_pelanggan }}</td>
                                <td>{{ $tagihan->pelanggan->nomor_sambungan ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($tagihan->periode)->translatedFormat('d F Y') }}</td>
                                <td>{{ number_format($tagihan->meter_awal, 0, ',', '.') }}</td>
                                <td>{{ number_format($tagihan->meter_akhir, 0, ',', '.') }}</td>
                                <td>{{ number_format($tagihan->volume_air, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($tagihan->total_tagihan, 2, ',', '.') }}</td>
                                <td>{{ $tagihan->pembaca_meter }}</td>
                                <td>
                                    @if ($tagihan->status_pembayaran)
                                        <span class="label label-success">Lunas</span>
                                    @else
                                        <span class="label label-warning">Belum Lunas</span>
                                    @endif
                                </td>
                                @if (Auth::user()->role == 'admin')
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('tagihan.edit', $tagihan->id) }}"
                                                class="btn btn-default btn-sm text-green" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('tagihan.cetak', $tagihan->id) }}"
                                                class="btn btn-default btn-sm text-purple" title="Cetak Struk"
                                                target="_blank"><i class="fa fa-print"></i></a>
                                            <form action="{{ route('tagihan.destroy', $tagihan->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-default btn-sm text-red"><i
                                                        class="fa fa-trash-o"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                @else
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('tagihan.cetak', $tagihan->id) }}"
                                                class="btn btn-default btn-sm text-purple" title="Cetak Struk"
                                                target="_blank"><i class="fa fa-print"></i></a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    Data tagihan tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan {{ $tagihans->firstItem() }} hingga {{ $tagihans->lastItem() }} dari
                        {{ $tagihans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $tagihans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
