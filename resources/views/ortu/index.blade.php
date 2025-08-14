@extends('layouts.master')
@section('title')
    Data Orang Tua
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Orang Tua
        @endslot
        @slot('li_2')
            Data Orang Tua
        @endslot
        @slot('title')
            Data Orang Tua
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('ortu.index') }}" class="form-inline">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('ortu.index') }}" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>
                                Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-social btn-sm btn-default" data-toggle="modal"
                            data-target="#modal-default">
                            <i class="fa fa-file-excel-o"></i> Import
                        </button>
                        <a href="{{ route('ortu.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px">No.</th>
                            <th>Nama Wali</th>
                            <th>Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th>Username</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ortus as $ortu)
                            <tr>
                                <td class="text-center">{{ $ortus->firstItem() + $loop->index }}</td>
                                <td>{{ $ortu->nama_wali }}</td>
                                <td>{{ $ortu->siswa ? $ortu->siswa->nama_lengkap : '-' }}</td>
                                <td>{{ $ortu->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $ortu->no_hp }}</td>
                                <td><span class="label label-info">{{ $ortu->user->username }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('ortu.edit', $ortu->id) }}"
                                            class="btn btn-default btn-sm text-green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('ortu.destroy', $ortu->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default btn-sm text-red">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data orang tua belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        Menampilkan {{ $ortus->firstItem() }} hingga {{ $ortus->lastItem() }} dari {{ $ortus->total() }}
                        entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $ortus->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form action="{{ route('ortu.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Import Data Orang Tua</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="file" class="col-sm-3 control-label">Pilih File Excel:</label>

                                <div class="col-sm-9">
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
