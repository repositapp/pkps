@extends('layouts.master')
@section('title')
    Permohonan Pemasangan
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pemasangan
        @endslot
        @slot('li_2')
            Data Pemasangan
        @endslot
        @slot('title')
            Permohonan Pemasangan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Permohonan Pemasangan</h3>
                <div class="pull-right box-tools">
                    @if ($pemasangan)
                    @else
                        <a href="{{ route('pemasangan.create') }}" class="btn btn-social btn-sm btn-info">
                            <i class="fa fa-plus"></i> Buat Permohonan
                        </a>
                    @endif
                </div>
            </div>
            <div class="box-body">
                <table class="table table-borderless">
                    @if ($pemasangan)
                        <tr>
                            <th style="width: 220px;">Pelanggan</th>
                            <td>: {{ $pemasangan->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon</th>
                            <td>: {{ $pemasangan->pelanggan->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Tujuan Pemasangan</th>
                            <td>: {{ $pemasangan->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>:
                                @if ($pemasangan->lokasi)
                                    {{ $pemasangan->lokasi }}
                                    <br>
                                    <a href="https://www.google.com/maps?q={{ $pemasangan->lokasi }}" target="_blank"
                                        class="btn btn-xs btn-primary">
                                        <i class="fa fa-map-marker"></i> Lihat di Google Maps
                                    </a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Permohonan</th>
                            <td>: {{ \Carbon\Carbon::parse($pemasangan->tanggal_permohonan)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Penelitian</th>
                            <td>:
                                {{ $pemasangan->tanggal_penelitian ? \Carbon\Carbon::parse($pemasangan->tanggal_penelitian)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <td>:
                                {{ $pemasangan->tanggal_bayar ? \Carbon\Carbon::parse($pemasangan->tanggal_bayar)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>SPK Tanggal</th>
                            <td>:
                                {{ $pemasangan->spk_tanggal ? \Carbon\Carbon::parse($pemasangan->spk_tanggal)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>SPK Nomor</th>
                            <td>: {{ $pemasangan->spk_nomor ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>B.A Tanggal</th>
                            <td>:
                                {{ $pemasangan->ba_tanggal ? \Carbon\Carbon::parse($pemasangan->ba_tanggal)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>B.A Nomor</th>
                            <td>: {{ $pemasangan->ba_nomor ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Merek Meteran</th>
                            <td>: {{ $pemasangan->merek_meteran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kedudukan</th>
                            <td>: {{ $pemasangan->kedudukan == 1 ? 'Perubahan' : 'Baru' }}</td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>:
                                @if ($pemasangan->status_pembayaran)
                                    <span class="label label-success">Lunas</span>
                                @else
                                    <span class="label label-warning">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:
                                @if ($pemasangan->status == 'pending')
                                    <span class="label label-warning">Pending</span>
                                @elseif($pemasangan->status == 'proses')
                                    <span class="label label-info">Proses</span>
                                @elseif($pemasangan->status == 'disetujui')
                                    <span class="label label-success">Disetujui</span>
                                @elseif($pemasangan->status == 'ditolak')
                                    <span class="label label-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @if ($pemasangan->status == 'ditolak' && $pemasangan->alasan_ditolak)
                            <tr>
                                <th>Alasan Ditolak</th>
                                <td>: {{ $pemasangan->alasan_ditolak }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Dibuat</th>
                            <td>: {{ \Carbon\Carbon::parse($pemasangan->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diubah</th>
                            <td>: {{ \Carbon\Carbon::parse($pemasangan->updated_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2" class="text-center">
                                Data permohonan pemasangan belum ada.
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </section>
@endsection
