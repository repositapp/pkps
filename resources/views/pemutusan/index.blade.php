@extends('layouts.master')
@section('title')
    Data Pemutusan Air
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pemutusan
        @endslot
        @slot('li_2')
            Data Pemutusan Air
        @endslot
        @slot('title')
            Data Pemutusan Air
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <form action="{{ route('pemutusan.index') }}" method="GET" class="form-inline">
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
                            <a href="{{ route('pemutusan.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pemutusan.create') }}" class="btn btn-social btn-sm btn-success">
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
                            <th scope="col">No. Sambungan</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Jumlah Tunggakan</th>
                            <th scope="col">Status</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pemutusans as $pemutusan)
                            <tr>
                                <td class="text-center">{{ $pemutusans->firstItem() + $loop->index }}</td>
                                <td>{{ $pemutusan->pelanggan->nama_pelanggan }}</td>
                                <td>{{ $pemutusan->pelanggan->nomor_sambungan ?? '-' }}</td>
                                <td>{{ Str::limit($pemutusan->deskripsi, 50) }}</td>
                                <td>Rp {{ number_format($pemutusan->jumlah_tunggakan, 2, ',', '.') }}</td>
                                <td>
                                    @if ($pemutusan->status == 'pending')
                                        <span class="label label-warning">Pending</span>
                                    @elseif($pemutusan->status == 'proses')
                                        <span class="label label-info">Proses</span>
                                    @elseif($pemutusan->status == 'disetujui')
                                        <span class="label label-success">Disetujui</span>
                                    @elseif($pemutusan->status == 'ditolak')
                                        <span class="label label-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('pemutusan.edit', $pemutusan->id) }}"
                                            class="btn btn-default btn-sm text-green" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route('pemutusan.destroy', $pemutusan->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus permohonan pemutusan ini?')"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default btn-sm text-red" title="Hapus"><i
                                                    class="fa fa-trash-o"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Data permohonan pemutusan tidak ditemukan.
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
                        Menampilkan {{ $pemutusans->firstItem() }} hingga {{ $pemutusans->lastItem() }} dari
                        {{ $pemutusans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $pemutusans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
