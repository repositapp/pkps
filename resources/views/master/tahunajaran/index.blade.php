@extends('layouts.master')
@section('title')
    Tahun Ajaran
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Tahun Ajaran
        @endslot
        @slot('title')
            Tahun Ajaran
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('tahunajaran.index') }}" class="form-inline">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('tahunajaran.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i>
                                Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('tahunajaran.create') }}" class="btn btn-social btn-sm btn-info">
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
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tahunAjarans as $ta)
                            <tr>
                                <td class="text-center">{{ $tahunAjarans->firstItem() + $loop->index }}</td>
                                <td>{{ $ta->tahun_ajaran }}</td>
                                <td>{{ $ta->semester }}</td>
                                <td>
                                    @if ($ta->status)
                                        <span class="label label-success">Aktif</span>
                                    @else
                                        <span class="label label-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('tahunajaran.edit', $ta->id) }}"
                                            class="btn btn-default btn-sm text-green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tahunajaran.destroy', $ta->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default btn-sm text-red"
                                                {{ $ta->status ? 'disabled' : '' }}>
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tahun ajaran belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        Menampilkan {{ $tahunAjarans->firstItem() }} hingga {{ $tahunAjarans->lastItem() }} dari
                        {{ $tahunAjarans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $tahunAjarans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
