@extends('layouts.master')
@section('title')
    Data Pemasangan Air Baru
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pemasangan
        @endslot
        @slot('li_2')
            Data Pemasangan Air Baru
        @endslot
        @slot('title')
            Data Pemasangan Air Baru
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <form action="{{ route('pemasangan.index') }}" method="GET" class="form-inline">
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
                                    <option value="disetujui"
                                        {{ isset($status) && $status == 'disetujui' ? 'selected' : '' }}>Disetujui
                                    </option>
                                    <option value="ditolak" {{ isset($status) && $status == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i>
                                Filter</button>
                            <a href="{{ route('pemasangan.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pemasangan.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Permohonan
                        </a>
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
                            <th scope="col">No. Telepon</th>
                            <th scope="col">No. Sambungan</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Tanggal Permohonan</th>
                            <th scope="col">Status</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemasangans as $pemasangan)
                            <tr>
                                <td class="text-center">{{ $pemasangans->firstItem() + $loop->index }}</td>
                                <td>{{ $pemasangan->pelanggan->nama_pelanggan }}</td>
                                <td>{{ $pemasangan->pelanggan->nomor_telepon }}</td>
                                <td>{{ $pemasangan->pelanggan->nomor_sambungan ?? '-' }}</td>
                                <td>{{ Str::limit($pemasangan->deskripsi, 50) }}</td>
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
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        @if ($pemasangan->status !== 'disetujui')
                                            <a href="{{ route('pemasangan.edit', $pemasangan->id) }}"
                                                class="btn btn-default btn-sm text-green" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                        @endif
                                        @if ($pemasangan->status !== 'disetujui')
                                            <form action="{{ route('pemasangan.destroy', $pemasangan->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus permohonan pemasangan ini?')"
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
                                <td colspan="8" class="text-center">
                                    Data permohonan pemasangan tidak ditemukan.
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
