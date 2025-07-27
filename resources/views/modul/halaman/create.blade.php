@extends('layouts.master')
@section('title')
    Tambah Halaman
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Modul
        @endslot
        @slot('li_2')
            Halaman
        @endslot
        @slot('title')
            Tambah Halaman
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('halaman.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('halaman.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="judul" class="col-sm-2 control-label">Judul <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                name="judul" value="{{ old('judul') }}" placeholder="Judul">
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="konten" class="col-sm-2 control-label">Redaksi <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <textarea class="tinymce @error('konten') is-invalid @enderror" rows="10" name="konten" id="konten">{{ old('konten') }}</textarea>
                            @error('konten')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status">
                                <option value="" hidden>-- Choose --</option>
                                <option value="0" @if (old('status') == 0) selected="selected" @endif> Private
                                </option>
                                <option value="1" @if (old('status') == 1) selected="selected" @endif> Publish
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
    <!-- tinymce -->
    <script src="{{ URL::asset('build/plugins/tinymce/tinymce.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/tinymce/form-editor-tiny.init.js') }}"></script>
@endpush
