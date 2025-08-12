@extends('layouts.master')
@section('title')
    Data Siswa
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Siswa
        @endslot
        @slot('li_2')
            Data Siswa
        @endslot
        @slot('title')
            Data Siswa
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('siswa.index') }}" class="form-inline">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('siswa.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i>
                                Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('siswa.create') }}" class="btn btn-social btn-sm btn-info">
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
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswas as $siswa)
                            <tr>
                                <td class="text-center">{{ $siswas->firstItem() + $loop->index }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama_lengkap }}</td>
                                <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $siswa->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                                <td>{{ $siswa->alamat }}</td>
                                {{-- <td>{{ $siswa->ortu ? $siswa->ortu->nama_wali : '-' }}</td> --}}
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('siswa.edit', $siswa->id) }}"
                                            class="btn btn-default btn-sm text-green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST"
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
                                <td colspan="7" class="text-center">Data siswa belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        Menampilkan {{ $siswas->firstItem() }} hingga {{ $siswas->lastItem() }} dari
                        {{ $siswas->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $siswas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
