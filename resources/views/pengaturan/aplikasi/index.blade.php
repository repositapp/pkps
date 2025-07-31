@extends('layouts.master')
@section('title')
    Pengaturan Aplikasi
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pengaturan
        @endslot
        @slot('li_2')
            Pengaturan Aplikasi
        @endslot
        @slot('title')
            Pengaturan Aplikasi
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('aplikasi.update', $aplikasi->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="nama_lembaga" class="col-sm-2 control-label">Nama Lembaga</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_lembaga') is-invalid @enderror"
                                id="nama_lembaga" name="nama_lembaga"
                                value="{{ old('nama_lembaga', $aplikasi->nama_lembaga) }}" placeholder="Nama Lembaga">
                            @error('nama_lembaga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telepon" class="col-sm-2 control-label">Telepon</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                                name="telepon" value="{{ old('telepon', $aplikasi->telepon) }}" placeholder="Nomor Telepon">
                            @error('telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fax" class="col-sm-2 control-label">Fax</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('fax') is-invalid @enderror" id="fax"
                                name="fax" value="{{ old('fax', $aplikasi->fax) }}" placeholder="Fax">
                            @error('fax')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>

                        <div class="col-sm-10">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $aplikasi->email) }}" placeholder="Alamat Email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat Kantor</label>

                        <div class="col-sm-10">
                            <textarea class="form-control  @error('alamat') is-invalid @enderror" rows="3" name="alamat" id="alamat"
                                placeholder="Alamat Kantor ...">{{ old('alamat', $aplikasi->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="maps" class="col-sm-2 control-label">Lokasi Kantor</label>

                        <div class="col-sm-10">
                            <textarea class="form-control  @error('maps') is-invalid @enderror" rows="3" name="maps" id="maps"
                                placeholder="Lokasi Kantor ...">{{ old('maps', $aplikasi->maps) }}</textarea>
                            @error('maps')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sidebar_lg" class="col-sm-2 control-label">Sidebar Long</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('sidebar_lg') is-invalid @enderror"
                                id="sidebar_lg" name="sidebar_lg" value="{{ old('sidebar_lg', $aplikasi->sidebar_lg) }}"
                                placeholder="Nama Sidebar Panjang">
                            <small class="text-danger">Maksimal 13 Karakter</small>
                            @error('sidebar_lg')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sidebar_mini" class="col-sm-2 control-label">Sidebar Mini</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('sidebar_mini') is-invalid @enderror"
                                id="sidebar_mini" name="sidebar_mini"
                                value="{{ old('sidebar_mini', $aplikasi->sidebar_mini) }}"
                                placeholder="Nama Sidebar Pendek">
                            <small class="text-danger">Maksimal 3 Karakter</small>
                            @error('sidebar_mini')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title_header" class="col-sm-2 control-label">Title Header</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title_header') is-invalid @enderror"
                                id="title_header" name="title_header"
                                value="{{ old('title_header', $aplikasi->title_header) }}" placeholder="Title Header">
                            @error('title_header')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo" class="col-sm-2 control-label">Logo Baznas</label>

                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                                name="logo" placeholder="Logo Baznas">
                            <small class="text-danger">Ukuran File Maksimal 2MB</small>
                            <p></p>
                            @error('logo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($aplikasi->logo)
                                <img src="{{ asset('storage/' . $aplikasi->logo) }}"
                                    class="img-thumbnail img-fluid mb-3 col-sm-2 d-block" alt="Logo Baznas">
                            @else
                                <img class="img-thumbnail img-fluid mb-3 col-sm-5">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
