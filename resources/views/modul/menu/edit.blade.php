@extends('layouts.master')
@section('title')
    Ubah Menu
@endsection
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ URL::asset('build/bower_components/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Modul
        @endslot
        @slot('li_2')
            Menu
        @endslot
        @slot('title')
            Ubah Menu
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('menu.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('menu.update', $menu->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama Menu <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $menu->name) }}" placeholder="Nama Menu">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-2 control-label">Tipe Menu <span
                                class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="" hidden>-- Choose --</option>
                                @foreach (['halaman', 'pengumuman'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('type', $menu->type) === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="target_id" class="col-sm-2 control-label">Target </label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('target_id') is-invalid @enderror" id="target_id"
                                name="target_id">
                                <option value="">-- Choose --</option>
                            </select>
                            @error('target_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parent_id" class="col-sm-2 control-label">Parent Menu </label>

                        <div class="col-sm-10">
                            <select class="form-control select2 @error('parent_id') is-invalid @enderror" id="parent_id"
                                name="parent_id">
                                <option value="">-- Choose --</option>
                                @foreach ($menus as $m)
                                    <option value="{{ $m->id }}"
                                        @if (old('parent_id', $menu->parent_id) == $m->id) selected="selected" @endif> {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="order" class="col-sm-2 control-label">Urutan <span class="text-red">*</span></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('order') is-invalid @enderror" id="order"
                                name="order" value="{{ old('order', $menu->order) }}" placeholder="Urutan">
                            @error('order')
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
                                <option value="0" @if (old('status', $menu->status) == 0) selected="selected" @endif>
                                    Private
                                </option>
                                <option value="1" @if (old('status', $menu->status) == 1) selected="selected" @endif>
                                    Publish
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
            $('#target_id').select2();
            $('#parent_id').select2();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const targetSelect = document.getElementById('target_id');

            typeSelect.addEventListener('change', function() {
                const type = this.value;
                if (!type) return;

                fetch(`/panel/menu/load-targets?type=${type}`)
                    .then(res => res.json())
                    .then(data => {
                        targetSelect.innerHTML = '<option value="">-- Choose --</option>';
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name || item.title;
                            targetSelect.appendChild(option);
                        });
                    });
            });
        });
    </script>
@endpush
