@extends('layouts.master')
@section('title')
    Tambah Pengumuman
@endsection
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pengumuman
        @endslot
        @slot('li_2')
            Pengumuman
        @endslot
        @slot('title')
            Tambah Pengumuman
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('pengumuman.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="kategori_id" class="col-sm-2 control-label">Kategori <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id">
                                <option value="" hidden>-- Choose --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        @if (old('kategori_id') == $kategori->id) selected="selected" @endif> {{ $kategori->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
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
                        <label for="body" class="col-sm-2 control-label">Redaksi <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <textarea class="tinymce @error('body') is-invalid @enderror" rows="10" name="body" id="body">{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar" class="col-sm-2 control-label">Gambar <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar"
                                name="gambar" placeholder="Gambar" accept="image/*">
                            <small class="text-danger">Ukuran File Maksimal 2MB</small>
                            @error('gambar')
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
    <!-- Select2 -->
    <script src="{{ URL::asset('build/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- tinymce -->
    <script src="{{ URL::asset('build/plugins/tinymce/tinymce.js') }}"></script>
    <script src="{{ URL::asset('build/plugins/tinymce/form-editor-tiny.init.js') }}"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('#kategori_id').select2();
        });
    </script>
@endpush
