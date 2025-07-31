@extends('layouts.master')
@section('title')
    Tambah Jadwal
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
            Tambah Jadwal
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Tambah Jadwal</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('jadwal.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('jadwal.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="hari_dalam_minggu" class="col-sm-2 control-label">Hari <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('hari_dalam_minggu') is-invalid @enderror"
                                id="hari_dalam_minggu" name="hari_dalam_minggu" required>
                                <option value="" hidden>-- Pilih Hari --</option>
                                @foreach ($hariTersedia as $value => $label)
                                    <option value="{{ $value }}" @if (old('hari_dalam_minggu') == $value) selected @endif>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari_dalam_minggu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="waktu_buka" class="col-sm-2 control-label">Waktu Buka <span
                                class="text-red">*</span></label>
                        <div class="col-sm-5">
                            <input type="time" class="form-control @error('waktu_buka') is-invalid @enderror"
                                id="waktu_buka" name="waktu_buka" value="{{ old('waktu_buka', '08:00') }}" required>
                            @error('waktu_buka')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="waktu_tutup" class="col-sm-1 control-label">Waktu Tutup <span
                                class="text-red">*</span></label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control @error('waktu_tutup') is-invalid @enderror"
                                id="waktu_tutup" name="waktu_tutup" value="{{ old('waktu_tutup', '17:00') }}" required>
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
                                value="{{ old('maksimum_pelanggan_per_jam', 5) }}" min="1" max="50" required>
                            <small class="text-muted">Jumlah maksimum pelanggan yang dapat dilayani per jam.</small>
                            @error('maksimum_pelanggan_per_jam')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hari_kerja" class="col-sm-2 control-label">Status Hari</label>

                        <div class="col-sm-10">
                            <select class="form-control @error('hari_kerja') is-invalid @enderror" id="hari_kerja"
                                name="hari_kerja">
                                <option value="0" @if (old('hari_kerja') == 0) selected="selected" @endif>
                                    Hari Libur</option>
                                <option value="1" @if (old('hari_kerja') == 1) selected="selected" @endif>Hari
                                    Kerja
                                </option>
                            </select>
                            @error('hari_kerja')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                    <p><span class="text-red">*</span> Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
