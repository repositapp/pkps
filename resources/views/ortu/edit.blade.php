@extends('layouts.master')
@section('title')
    Ubah Orang Tua
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Orang Tua
        @endslot
        @slot('li_2')
            Data Orang Tua
        @endslot
        @slot('title')
            Ubah Orang Tua
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Edit</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('ortu.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('ortu.update', $ortu->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="siswa_id" class="col-sm-2 control-label">Siswa <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('siswa_id') is-invalid @enderror" id="siswa_id"
                                name="siswa_id">
                                <option value="" hidden>-- Pilih Siswa --</option>
                                @foreach ($siswas as $siswa)
                                    <option value="{{ $siswa->id }}"
                                        {{ old('siswa_id', $ortu->siswa_id) == $siswa->id ? 'selected' : '' }}>
                                        {{ $siswa->nama_lengkap }} ({{ $siswa->nisn }})
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_wali" class="col-sm-2 control-label">Nama Wali <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_wali') is-invalid @enderror"
                                id="nama_wali" name="nama_wali" value="{{ old('nama_wali', $ortu->nama_wali) }}"
                                placeholder="Nama Orang Tua / Wali">
                            @error('nama_wali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin" class="col-sm-2 control-label">Jenis Kelamin <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin">
                                <option value="" hidden>-- Pilih --</option>
                                <option value="L"
                                    {{ old('jenis_kelamin', $ortu->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $ortu->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_hp" class="col-sm-2 control-label">No HP <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                name="no_hp" value="{{ old('no_hp', $ortu->no_hp) }}" placeholder="081234567890">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $ortu->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                    <p>Catatan : (<span class="text-red">*</span>) Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
