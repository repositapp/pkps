@extends('layouts.master')
@section('title')
    Ubah Relasi
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Relasi
        @endslot
        @slot('li_2')
            Relasi Guru - Mata Pelajaran - Kelas
        @endslot
        @slot('title')
            Ubah Relasi
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Edit</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('mapel.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('mapel.update', $guruMapel->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="guru_id" class="col-sm-2 control-label">Guru <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('guru_id') is-invalid @enderror" id="guru_id"
                                name="guru_id">
                                <option value="" hidden>-- Pilih Guru --</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}"
                                        {{ old('guru_id', $guruMapel->guru_id) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_lengkap }} ({{ $guru->nip }})
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pelajaran_id" class="col-sm-2 control-label">Mata Pelajaran <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('pelajaran_id') is-invalid @enderror" id="pelajaran_id"
                                name="pelajaran_id">
                                <option value="" hidden>-- Pilih Pelajaran --</option>
                                @foreach ($pelajarans as $pelajaran)
                                    <option value="{{ $pelajaran->id }}"
                                        {{ old('pelajaran_id', $guruMapel->pelajaran_id) == $pelajaran->id ? 'selected' : '' }}>
                                        {{ $pelajaran->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pelajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id" class="col-sm-2 control-label">Kelas <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id"
                                name="kelas_id">
                                <option value="" hidden>-- Pilih Kelas --</option>
                                @foreach ($kelass as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ old('kelas_id', $guruMapel->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="tahun_ajaran_id" class="col-sm-2 control-label">Tahun Ajaran <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('tahun_ajaran_id') is-invalid @enderror" id="tahun_ajaran_id"
                                name="tahun_ajaran_id">
                                <option value="" hidden>-- Pilih Tahun Ajaran --</option>
                                @foreach ($tahunAjarans as $ta)
                                    <option value="{{ $ta->id }}"
                                        {{ old('tahun_ajaran_id', $guruMapel->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun_ajaran }} ({{ $ta->semester }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tahun_ajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
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
