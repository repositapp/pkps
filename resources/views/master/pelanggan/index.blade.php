@extends('layouts.master')
@section('title')
    Data Pelanggan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Pelanggan
        @endslot
        @slot('title')
            Data Pelanggan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <div class="row align-items-center">
                    <div class="col-md-6 align-items-center">
                        <form action="{{ route('pelanggan.index') }}" method="GET">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control pull-right"
                                    placeholder="Cari nama, no. sambungan, telepon..." value="{{ $search ?? '' }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('pelanggan.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Pelanggan
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
                            <th scope="col">Nama</th>
                            <th scope="col">JK</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Telepon</th>
                            <th scope="col">No. Sambungan</th>
                            <th scope="col">KTP</th>
                            <th class="text-center" style="width: 80px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelanggans as $pelanggan)
                            <tr>
                                <td class="text-center">{{ $pelanggans->firstItem() + $loop->index }}</td>
                                <td>{{ $pelanggan->nama_pelanggan }}</td>
                                <td>{{ $pelanggan->jenis_kelamin }}</td>
                                <td>{{ Str::limit($pelanggan->alamat, 30) }}</td>
                                <td>{{ $pelanggan->nomor_telepon }}</td>
                                <td>{{ $pelanggan->nomor_sambungan ?? '-' }}</td>
                                <td>
                                    @if ($pelanggan->file_ktp)
                                        @php
                                            $extension = pathinfo(
                                                public_path('storage/' . $pelanggan->file_ktp),
                                                PATHINFO_EXTENSION,
                                            );
                                        @endphp
                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                            <a href="{{ asset('storage/' . $pelanggan->file_ktp) }}" target="_blank">Lihat
                                                Gambar</a>
                                        @elseif(strtolower($extension) === 'pdf')
                                            <a href="{{ asset('storage/' . $pelanggan->file_ktp) }}" target="_blank">Lihat
                                                PDF</a>
                                        @else
                                            <span>File tidak dikenali</span>
                                        @endif
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group d-flex">
                                        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                                            class="btn btn-default btn-sm text-green"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-default btn-sm text-red"><i
                                                    class="fa fa-trash-o"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Data pelanggan tidak ditemukan.
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
                        Menampilkan {{ $pelanggans->firstItem() }} hingga {{ $pelanggans->lastItem() }} dari
                        {{ $pelanggans->total() }} entri
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            {{ $pelanggans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
