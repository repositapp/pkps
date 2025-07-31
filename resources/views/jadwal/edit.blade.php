@extends('layouts.master')
@section('title')
    Ubah Jadwal {{ $namaHari }}
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
            Ubah Jadwal {{ $namaHari }}
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Ubah Jadwal untuk Hari {{ $namaHari }}</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('jadwal.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('jadwal.update', $jadwal->hari_dalam_minggu) }}"
                    method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="hari" class="col-sm-2 control-label">Hari</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hari" value="{{ $namaHari }}" readonly>
                            <input type="hidden" name="hari_dalam_minggu" value="{{ $jadwal->hari_dalam_minggu }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="waktu_buka" class="col-sm-2 control-label">Waktu Buka <span
                                class="text-red">*</span></label>
                        <div class="col-sm-5">
                            <input type="time" class="form-control @error('waktu_buka') is-invalid @enderror"
                                id="waktu_buka" name="waktu_buka" value="{{ old('waktu_buka', $jadwal->waktu_buka) }}">
                            @error('waktu_buka')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="waktu_tutup" class="col-sm-1 control-label">Waktu Tutup <span
                                class="text-red">*</span></label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control @error('waktu_tutup') is-invalid @enderror"
                                id="waktu_tutup" name="waktu_tutup" value="{{ old('waktu_tutup', $jadwal->waktu_tutup) }}">
                            @error('waktu_tutup')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="maksimum_pelanggan_per_jam" class="col-sm-2 control-label">Max Pelanggan/Jam <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="number"
                                class="form-control @error('maksimum_pelanggan_per_jam') is-invalid @enderror"
                                id="maksimum_pelanggan_per_jam" name="maksimum_pelanggan_per_jam"
                                value="{{ old('maksimum_pelanggan_per_jam', $jadwal->maksimum_pelanggan_per_jam) }}"
                                min="1" max="20">
                            <small class="text-muted">Jumlah maksimum pelanggan yang dapat mengantri dalam satu jam.</small>
                            @error('maksimum_pelanggan_per_jam')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i> Simpan
                                Perubahan</button>
                        </div>
                    </div>
                    <p><span class="text-red">*</span> Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
