@extends('layouts.master')
@section('title')
    Manajemen Layanan
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Layanan
        @endslot
        @slot('li_2')
            Daftar Layanan
        @endslot
        @slot('title')
            Daftar Layanan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('layanan.index') }}" method="GET">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control pull-right"
                                    placeholder="Cari Nama Layanan..." value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('layanan.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Layanan
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
                                <th scope="col">Nama Layanan</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Durasi (Menit)</th>
                                <th scope="col">Status</th>
                                <th class="text-center" style="width: 80px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($layanans as $layanan)
                                <tr>
                                    <td class="text-center">{{ $layanans->firstItem() + $loop->index }}</td>
                                    <td>{{ $layanan->nama }}</td>
                                    <td>{{ Str::limit($layanan->deskripsi, 50) }}</td>
                                    <td>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                                    <td>{{ $layanan->durasi }} Menit</td>
                                    <td>
                                        @if ($layanan->is_active)
                                            <span class="label label-success">Aktif</span>
                                        @else
                                            <span class="label label-danger">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('layanan.edit', $layanan->id) }}"
                                                class="btn btn-default btn-sm text-aqua" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('layanan.toggleStatus', $layanan->id) }}" method="POST"
                                                style="display:inline;"
                                                title="{{ $layanan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-default btn-sm {{ $layanan->is_active ? 'text-green' : 'text-red' }}">
                                                    <i
                                                        class="fa {{ $layanan->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus layanan ini? Ini akan mempengaruhi pemesanan terkait.')">
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
                                    <td colspan="7" class="text-center">
                                        Data layanan belum tersedia.
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
                        Menampilkan {{ $layanans->firstItem() }} hingga {{ $layanans->lastItem() }} dari
                        {{ $layanans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $layanans->appends(['search' => $search])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
