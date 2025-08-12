@extends('layouts.master')
@section('title')
    Tambah Tahun Ajaran
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Master Data
        @endslot
        @slot('li_2')
            Tahun Ajaran
        @endslot
        @slot('title')
            Tambah Tahun Ajaran
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('tahunajaran.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('tahunajaran.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tahun_ajaran" class="col-sm-2 control-label">Tahun Ajaran <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran') }}"
                                placeholder="2023/2024">
                            <small class="text-muted">Format: 2023/2024</small>
                            @error('tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="semester" class="col-sm-2 control-label">Semester <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control @error('semester') is-invalid @enderror" id="semester"
                                name="semester">
                                <option value="" hidden>-- Pilih --</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status Aktif</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="status" value="1"
                                        {{ old('status') ? 'checked' : '' }}>
                                    Jadikan tahun ajaran ini sebagai aktif
                                </label>
                            </div>
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
