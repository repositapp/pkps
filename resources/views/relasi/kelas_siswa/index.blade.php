@extends('layouts.master')
@section('title')
    Relasi Siswa - Kelas
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Relasi
        @endslot
        @slot('li_2')
            Relasi Siswa
        @endslot
        @slot('title')
            Relasi Siswa-Kelas
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('siswakelas.index') }}" class="form-inline">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('siswakelas.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i>
                                Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('siswakelas.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Relasi
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 40px">No.</th>
                            <th>NISN</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelasSiswas as $item)
                            <tr>
                                <td class="text-center">{{ $kelasSiswas->firstItem() + $loop->index }}</td>
                                <td>{{ $item->siswa->nisn }}</td>
                                <td>{{ $item->siswa->nama_lengkap }}</td>
                                <td>{{ $item->kelas->nama_kelas }}</td>
                                <td>{{ $item->tahunAjaran->tahun_ajaran }} ({{ $item->tahunAjaran->semester }})</td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('siswakelas.edit', $item->id) }}"
                                            class="btn btn-default btn-sm text-green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('siswakelas.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus relasi ini?')" class="d-inline">
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
                                <td colspan="6" class="text-center">Belum ada relasi yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        Menampilkan {{ $kelasSiswas->firstItem() }} hingga {{ $kelasSiswas->lastItem() }} dari
                        {{ $kelasSiswas->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $kelasSiswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
