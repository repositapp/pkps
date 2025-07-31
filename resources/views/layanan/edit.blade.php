@extends('layouts.master')
@section('title')
    Ubah Layanan
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Layanan
        @endslot
        @slot('li_2')
            Daftar Layanan
        @endslot
        @slot('title')
            Ubah Layanan
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Ubah Layanan</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('layanan.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('layanan.update', $layanan->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="nama" class="col-sm-2 control-label">Nama Layanan <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama', $layanan->nama) }}" placeholder="Nama Layanan">
                            @error('nama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Deskripsi singkat layanan...">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="harga" class="col-sm-2 control-label">Harga (Rp) <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga"
                                name="harga" value="{{ old('harga', $layanan->harga) }}" placeholder="Harga layanan"
                                min="0" step="1000">
                            @error('harga')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="durasi" class="col-sm-2 control-label">Durasi (Menit) <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control @error('durasi') is-invalid @enderror" id="durasi"
                                name="durasi" value="{{ old('durasi', $layanan->durasi) }}"
                                placeholder="Durasi pengerjaan dalam menit" min="1">
                            @error('durasi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i> Simpan
                                Perubahan</button>
                        </div>
                    </div>
                    <p><span class="text-red">*</span> Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
