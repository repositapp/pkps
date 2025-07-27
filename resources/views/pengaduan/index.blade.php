@extends('layouts.master')
@section('title')
    Data Pengaduan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pengaduan
        @endslot
        @slot('li_2')
            Pengaduan
        @endslot
        @slot('title')
            Data Pengaduan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <form action="{{ route('pengaduan.index') }}" method="GET" class="form-inline">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control input-sm"
                                    placeholder="Cari nama, deskripsi..." value="{{ $search ?? '' }}">
                            </div>
                            <div class="form-group">
                                <select name="status" class="form-control input-sm">
                                    <option value="">-- Semua Status --</option>
                                    <option value="pending" {{ isset($status) && $status == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="proses" {{ isset($status) && $status == 'proses' ? 'selected' : '' }}>
                                        Proses</option>
                                    <option value="selesai" {{ isset($status) && $status == 'selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i>
                                Filter</button>
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @if (Auth::user()->role == 'admin')
                            <a href="{{ route('pengaduan.create') }}" class="btn btn-social btn-sm btn-info">
                                <i class="fa fa-plus"></i> Tambah Pengaduan
                            </a>
                        @else
                            @php
                                $pemasangan = \App\Models\Pemasangan::where(
                                    'pelanggan_id',
                                    session('pelanggan_id'),
                                )->first();
                            @endphp
                            @if ($pemasangan->status == 'disetujui')
                                <a href="{{ route('pengaduan.create') }}" class="btn btn-social btn-sm btn-info">
                                    <i class="fa fa-plus"></i> Tambah Pengaduan
                                </a>
                            @endif
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
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Tanggal Pengaduan</th>
                            <th scope="col">Status</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengaduans as $pengaduan)
                            <tr>
                                <td class="text-center">{{ $pengaduans->firstItem() + $loop->index }}</td>
                                <td>{{ $pengaduan->pelanggan->nama_pelanggan }}</td>
                                <td>{{ $pengaduan->pelanggan->nomor_sambungan ?? '-' }}</td>
                                <td>{{ Str::limit($pengaduan->deskripsi, 50) }}</td>
                                <td>{{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d F Y, H:i') }}
                                </td>
                                <td>
                                    @if ($pengaduan->status == 'pending')
                                        <span class="label label-warning">Pending</span>
                                    @elseif($pengaduan->status == 'proses')
                                        <span class="label label-info">Proses</span>
                                    @elseif($pengaduan->status == 'selesai')
                                        <span class="label label-success">Selesai</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        @if ($pengaduan->status == 'pending')
                                            <a href="{{ route('pengaduan.edit', $pengaduan->id) }}"
                                                class="btn btn-default btn-sm text-green" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-default btn-sm text-red"
                                                    title="Hapus"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Data pengaduan tidak ditemukan.
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
                        Menampilkan {{ $pengaduans->firstItem() }} hingga {{ $pengaduans->lastItem() }} dari
                        {{ $pengaduans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $pengaduans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
