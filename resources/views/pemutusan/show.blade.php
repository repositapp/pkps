@extends('layouts.master')
@section('title')
    Detail Permohonan Pemutusan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pemutusan
        @endslot
        @slot('li_2')
            Data Pemutusan
        @endslot
        @slot('title')
            Detail Permohonan Pemutusan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Detail Permohonan Pemutusan</h3>
                <div class="pull-right box-tools">
                    @if ($pemutusan)
                    @else
                        @php
                            $pemasangan = \App\Models\Pemasangan::where(
                                'pelanggan_id',
                                session('pelanggan_id'),
                            )->first();
                        @endphp
                        @if ($pemasangan->status == 'disetujui')
                            <a href="{{ route('pemutusan.create') }}" class="btn btn-social btn-sm btn-info">
                                <i class="fa fa-plus"></i> Buat Permohonan
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="box-body">
                <table class="table table-borderless">
                    @if ($pemutusan)
                        <tr>
                            <th>Pelanggan:</th>
                            <td>{{ $pemutusan->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <th>No. Sambungan:</th>
                            <td>{{ $pemutusan->pelanggan->nomor_sambungan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon:</th>
                            <td>{{ $pemutusan->pelanggan->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Tujuan Pemutusan:</th>
                            <td>{{ $pemutusan->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi:</th>
                            <td>
                                @if ($pemutusan->lokasi)
                                    {{ $pemutusan->lokasi }}
                                    <br>
                                    <a href="https://www.google.com/maps?q={{ $pemutusan->lokasi }}" target="_blank"
                                        class="btn btn-xs btn-primary">
                                        <i class="fa fa-map-marker"></i> Lihat di Google Maps
                                    </a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Tunggakan:</th>
                            <td>Rp {{ number_format($pemutusan->jumlah_tunggakan, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if ($pemutusan->status == 'pending')
                                    <span class="label label-warning">Pending</span>
                                @elseif($pemutusan->status == 'proses')
                                    <span class="label label-info">Proses</span>
                                @elseif($pemutusan->status == 'disetujui')
                                    <span class="label label-success">Disetujui</span>
                                @elseif($pemutusan->status == 'ditolak')
                                    <span class="label label-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @if ($pemutusan->status == 'ditolak' && $pemutusan->alasan_ditolak)
                            <tr>
                                <th>Alasan Ditolak:</th>
                                <td>{{ $pemutusan->alasan_ditolak }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ \Carbon\Carbon::parse($pemutusan->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diubah</th>
                            <td>: {{ \Carbon\Carbon::parse($pemutusan->updated_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2" class="text-center">
                                Data permohonan pemutusan belum ada.
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </section>
@endsection
