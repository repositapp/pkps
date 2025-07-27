@extends('layouts.master')
@section('title')
    Laporan Pemasangan Air Baru
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Laporan
        @endslot
        @slot('li_2')
            Pemasangan
        @endslot
        @slot('title')
            Laporan Pemasangan Air Baru
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-8 align-items-center">
                        <form action="{{ route('laporan.pemasangan.index') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control input-sm"
                                    placeholder="Cari nama pelanggan..." value="{{ $search ?? '' }}">
                            </div>
                            <div class="form-group">
                                <select name="bulan" class="form-control input-sm">
                                    <option value="">-- Bulan --</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ isset($bulan) && $bulan == $month ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $month)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="tahun" class="form-control input-sm">
                                    <option value="">-- Tahun --</option>
                                    @for ($year = date('Y'); $year >= date('Y') - 10; $year--)
                                        <option value="{{ $year }}"
                                            {{ isset($tahun) && $tahun == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="status" class="form-control input-sm">
                                    <option value="">-- Status --</option>
                                    <option value="pending" {{ isset($status) && $status == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="proses" {{ isset($status) && $status == 'proses' ? 'selected' : '' }}>
                                        Proses
                                    </option>
                                    <option value="disetujui"
                                        {{ isset($status) && $status == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui</option>
                                    <option value="ditolak" {{ isset($status) && $status == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i>
                                Filter</button>
                            <a href="{{ route('laporan.pemasangan.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-4 align-items-center justify-content-end">
                        <form action="{{ route('laporan.pemasangan.cetak-pdf') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button type="submit" class="btn btn-social btn-sm btn-info"><i class="fa fa-file-pdf-o"></i>
                                Cetak
                                PDF</button>
                        </form>
                        &nbsp;
                        <form action="{{ route('laporan.pemasangan.cetak-excel') }}" method="POST" target="_blank">
                            @csrf
                            <input type="hidden" name="search" value="{{ $search }}">
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button type="submit" class="btn btn-social btn-sm btn-primary"><i
                                    class="fa fa-file-excel-o"></i>
                                Export Excel</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-body no-padding">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px">No.</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Tanggal Permohonan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Nomor Sambungan</th>
                            <th scope="col">Merek Meteran</th>
                            <th scope="col">Kedudukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemasangans as $pemasangan)
                            <tr>
                                <td class="text-center">{{ $pemasangans->firstItem() + $loop->index }}</td>
                                <td>{{ $pemasangan->pelanggan->nama_pelanggan }}</td>
                                <td>{{ Str::limit($pemasangan->pelanggan->alamat, 50) }}</td>
                                <td>{{ \Carbon\Carbon::parse($pemasangan->tanggal_permohonan)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    @if ($pemasangan->status == 'pending')
                                        <span class="label label-warning">Pending</span>
                                    @elseif($pemasangan->status == 'proses')
                                        <span class="label label-info">Proses</span>
                                    @elseif($pemasangan->status == 'disetujui')
                                        <span class="label label-success">Disetujui</span>
                                    @elseif($pemasangan->status == 'ditolak')
                                        <span class="label label-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $pemasangan->pelanggan->nomor_sambungan ?? '-' }}</td>
                                <td>{{ $pemasangan->merek_meteran ?? '-' }}</td>
                                <td>{{ $pemasangan->kedudukan == 1 ? 'Perubahan' : 'Baru' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Data pemasangan tidak ditemukan.
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
                        Menampilkan {{ $pemasangans->firstItem() }} hingga {{ $pemasangans->lastItem() }} dari
                        {{ $pemasangans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $pemasangans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
