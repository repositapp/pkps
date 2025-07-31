@extends('layouts.master')
@section('title')
    Manajemen Barber
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Barber
        @endslot
        @slot('li_2')
            Daftar Barber
        @endslot
        @slot('title')
            Daftar Barber
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('barber.index') }}" method="GET" class="form-inline">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control pull-right"
                                    placeholder="Cari Barber/Nama Pemilik/Email..." value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <a href="{{ route('barber.index') }}" class="btn btn-default btn-sm"><i
                                    class="fa fa-refresh"></i> Reset</a>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('barber.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Barber
                        </a>
                    </div>
                </div>
            </div>

            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px">No.</th>
                                <th scope="col">Nama Barber</th>
                                <th scope="col">Pemilik</th>
                                <th scope="col">Akun (Username)</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">Status</th>
                                <th scope="col">Verifikasi</th>
                                <th class="text-center" style="width: 80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barbers as $barber)
                                <tr>
                                    <td class="text-center">{{ $barbers->firstItem() + $loop->index }}</td>
                                    <td>{{ $barber->nama }}</td>
                                    <td>{{ $barber->nama_pemilik }}</td>
                                    <td>{{ $barber->user->username }}</td>
                                    <td>{{ $barber->user->email ?? '-' }}</td>
                                    <td>{{ $barber->telepon }}</td>
                                    <td>
                                        @if ($barber->is_active)
                                            <span class="label label-success">Aktif</span>
                                        @else
                                            <span class="label label-danger">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($barber->is_verified)
                                            <span class="label label-primary">Terverifikasi</span>
                                        @else
                                            <span class="label label-warning">Belum</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('barber.edit', $barber->id) }}"
                                                class="btn btn-default btn-sm text-blue" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('barber.toggleStatus', $barber->id) }}" method="POST"
                                                style="display:inline;"
                                                title="{{ $barber->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-default btn-sm {{ $barber->is_active ? 'text-green' : 'text-red' }}">
                                                    <i
                                                        class="fa {{ $barber->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('barber.toggleVerification', $barber->id) }}"
                                                method="POST" style="display:inline;"
                                                title="{{ $barber->is_verified ? 'Batalkan Verifikasi' : 'Verifikasi' }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-default btn-sm {{ $barber->is_verified ? 'text-green' : 'text-red' }}">
                                                    <i class="fa {{ $barber->is_verified ? 'fa-check' : 'fa-close' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('barber.destroy', $barber->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-default btn-sm text-red"
                                                    title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Data barber belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box-footer clearfix">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        Menampilkan {{ $barbers->firstItem() }} hingga {{ $barbers->lastItem() }} dari
                        {{ $barbers->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $barbers->appends(['search' => $search])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
