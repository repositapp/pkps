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
            Relasi Siswa
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
                    <a href="{{ route('siswakelas.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('siswakelas.update', $kelasSiswa->id) }}" method="POST">
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
                                        {{ old('siswa_id', $kelasSiswa->siswa_id) == $siswa->id ? 'selected' : '' }}>
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
                        <label for="kelas_id" class="col-sm-2 control-label">Kelas <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('kelas_id') is-invalid @enderror" id="kelas_id"
                                name="kelas_id">
                                <option value="" hidden>-- Pilih Kelas --</option>
                                @foreach ($kelass as $kelas)
                                    <option value="{{ $kelas->id }}"
                                        {{ old('kelas_id', $kelasSiswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
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
                                        {{ old('tahun_ajaran_id', $kelasSiswa->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
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
