@extends('layouts.master')
@section('title')
    Ubah Siswa
@endsection
@push('css')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ URL::asset('build/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Siswa
        @endslot
        @slot('li_2')
            Data Siswa
        @endslot
        @slot('title')
            Ubah Siswa
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('siswa.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" placeholder="Nama Lengkap">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nisn" class="col-sm-2 control-label">NISN <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn"
                                name="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="NISN">
                            @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir" class="col-sm-2 control-label">Tempat Lahir <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Contoh: Buton">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir" class="col-sm-2 control-label">Tanggal Lahir <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text"
                                    class="form-control pull-right @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" placeholder="YYYY-MM-DD">
                            </div>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
                                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P"
                                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="agama" class="col-sm-2 control-label">Agama <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama"
                                name="agama" value="{{ old('agama', $siswa->agama) }}" placeholder="Contoh: Islam">
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="asal_sekolah" class="col-sm-2 control-label">Asal Sekolah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('asal_sekolah') is-invalid @enderror"
                                id="asal_sekolah" name="asal_sekolah"
                                value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}"
                                placeholder="Contoh: SD Negeri 1">
                            @error('asal_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tahun_lulus" class="col-sm-2 control-label">Tahun Lulus</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('tahun_lulus') is-invalid @enderror"
                                id="tahun_lulus" name="tahun_lulus"
                                value="{{ old('tahun_lulus', $siswa->tahun_lulus) }}" placeholder="Contoh: 2023">
                            @error('tahun_lulus')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah" class="col-sm-2 control-label">Nama Ayah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                                placeholder="Nama Ayah">
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_ibu" class="col-sm-2 control-label">Nama Ibu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                                placeholder="Nama Ibu">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan_ayah" class="col-sm-2 control-label">Pekerjaan Ayah</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                                id="pekerjaan_ayah" name="pekerjaan_ayah"
                                value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}" placeholder="Contoh: Guru">
                            @error('pekerjaan_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan_ibu" class="col-sm-2 control-label">Pekerjaan Ibu</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                                id="pekerjaan_ibu" name="pekerjaan_ibu"
                                value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}"
                                placeholder="Contoh: Ibu Rumah Tangga">
                            @error('pekerjaan_ibu')
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
@push('script')
    <!-- bootstrap datepicker -->
    <script src="{{ URL::asset('build/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script>
        $(function() {
            //Date picker
            $('#tanggal_lahir').datepicker({
                format: 'yyyy-mm-dd', // ini format Y-m-d
                autoclose: true,
                todayHighlight: true
            });
        })
    </script>
@endpush
