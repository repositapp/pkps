@extends('layouts.master')
@section('title')
    Data Guru
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Guru
        @endslot
        @slot('li_2')
            Data Guru
        @endslot
        @slot('title')
            Data Guru
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('guru.index') }}" class="form-inline">
                            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('guru.index') }}" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>
                                Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('guru.create') }}" class="btn btn-social btn-sm btn-info">
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
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Username</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gurus as $guru)
                            <tr>
                                <td class="text-center">{{ $gurus->firstItem() + $loop->index }}</td>
                                <td>{{ $guru->nip ?? '-' }}</td>
                                <td>{{ $guru->nama_lengkap }}</td>
                                <td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $guru->no_hp }}</td>
                                <td>{{ $guru->user->email }}</td>
                                <td>{{ $guru->alamat }}</td>
                                <td><span class="label label-info">{{ $guru->user->username }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('guru.edit', $guru->id) }}"
                                            class="btn btn-default btn-sm text-green">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('guru.destroy', $guru->id) }}" method="POST"
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
                                <td colspan="9" class="text-center">Data guru belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        Menampilkan {{ $gurus->firstItem() }} hingga {{ $gurus->lastItem() }} dari
                        {{ $gurus->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $gurus->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
