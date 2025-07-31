@extends('layouts.master')
@section('title')
    Manajemen Jadwal
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Jadwal
        @endslot
        @slot('li_2')
            Daftar Jadwal
        @endslot
        @slot('title')
            Daftar Jadwal
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Jadwal Operasional Barber</h3>
                <div class="pull-right box-tools">
                    @if (!$semuaHariTerisi)
                        <a href="{{ route('jadwal.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Tambah Jadwal
                        </a>
                    @endif
                </div>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">No.</th>
                                <th>Hari</th>
                                <th>Waktu Buka</th>
                                <th>Waktu Tutup</th>
                                <th>Max Pelanggan/Jam</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 80px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwals as $jadwal)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $jadwal->nama_hari }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->waktu_buka)->format('H:i') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->waktu_tutup)->format('H:i') }}
                                    </td>
                                    <td>{{ $jadwal->maksimum_pelanggan_per_jam }}</td>
                                    <td>
                                        @if ($jadwal->hari_kerja)
                                            <span class="label label-success">Hari Kerja</span>
                                        @else
                                            <span class="label label-danger">Hari Libur</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group d-flex">
                                            <a href="{{ route('jadwal.edit', $jadwal->hari_dalam_minggu) }}"
                                                class="btn btn-default btn-sm text-blue" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('jadwal.toggleStatus', $jadwal->id) }}" method="POST"
                                                style="display:inline;"
                                                title="{{ $jadwal->hari_kerja ? 'Tandai Libur' : 'Tandai Kerja' }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-default btn-sm {{ $jadwal->hari_kerja ? 'text-green' : 'text-red' }}">
                                                    <i
                                                        class="fa {{ $jadwal->hari_kerja ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data jadwal belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <small class="text-muted">
                    <i class="fa fa-info-circle"></i> Jadwal ini digunakan untuk mengatur ketersediaan waktu booking
                    pelanggan.
                </small>
            </div>
        </div>
    </section>
@endsection
