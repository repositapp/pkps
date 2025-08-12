@extends('layouts.master')
@section('title')
    Data Pelajaran
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Data Pelajaran
        @endslot
        @slot('title')
            Data Pelajaran
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('pelajaran.index') }}" class="form-inline">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('pelajaran.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i>
                                Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pelajaran.create') }}" class="btn btn-social btn-sm btn-info">
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
                            <th>Mata Pelajaran</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelajarans as $pelajaran)
                            <tr>
                                <td class="text-center">{{ $pelajarans->firstItem() + $loop->index }}</td>
                                <td>{{ $pelajaran->nama_mapel }}</td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('pelajaran.edit', $pelajaran->id) }}"
                                            class="btn btn-default btn-sm text-green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pelajaran.destroy', $pelajaran->id) }}" method="POST"
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
                                <td colspan="3" class="text-center">Data pelajaran belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        Menampilkan {{ $pelajarans->firstItem() }} hingga {{ $pelajarans->lastItem() }} dari
                        {{ $pelajarans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $pelajarans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
