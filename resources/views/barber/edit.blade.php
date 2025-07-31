@extends('layouts.master')
@section('title')
    Ubah Barber
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Manajemen Barber
        @endslot
        @slot('li_2')
            Daftar Barber
        @endslot
        @slot('title')
            Ubah Barber
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Ubah Barber</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('barber.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('barber.update', $barber->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="nama" class="col-sm-2 control-label">Nama Barber <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama', $barber->nama) }}" placeholder="Nama Barber Shop">
                            @error('nama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_pemilik" class="col-sm-2 control-label">Nama Pemilik <span
                                class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror"
                                id="nama_pemilik" name="nama_pemilik"
                                value="{{ old('nama_pemilik', $barber->nama_pemilik) }}" placeholder="Nama Pemilik Barber">
                            @error('nama_pemilik')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Deskripsi singkat barber...">{{ old('deskripsi', $barber->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2"
                                placeholder="Alamat lengkap barber...">{{ old('alamat', $barber->alamat) }}</textarea>
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telepon" class="col-sm-2 control-label">Telepon <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon"
                                name="telepon" value="{{ old('telepon', $barber->telepon) }}"
                                placeholder="Nomor telepon barber">
                            @error('telepon')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email <span class="text-red">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $barber->user->email ?? '') }}"
                                placeholder="Email untuk akun admin barber">
                            <small class="text-muted">Email ini akan digunakan untuk login admin barber.</small>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="waktu_buka" class="col-sm-2 control-label">Waktu Buka <span
                                class="text-red">*</span></label>
                        <div class="col-sm-5">
                            <input type="time" class="form-control @error('waktu_buka') is-invalid @enderror"
                                id="waktu_buka" name="waktu_buka" value="{{ old('waktu_buka', $barber->waktu_buka) }}">
                            @error('waktu_buka')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="waktu_tutup" class="col-sm-1 control-label">Waktu Tutup <span
                                class="text-red">*</span></label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control @error('waktu_tutup') is-invalid @enderror"
                                id="waktu_tutup" name="waktu_tutup"
                                value="{{ old('waktu_tutup', $barber->waktu_tutup) }}">
                            @error('waktu_tutup')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10 text-right">
                            <button type="submit" class="btn btn-social btn-info btn-sm"><i class="fa fa-save"></i>
                                Simpan Perubahan</button>
                        </div>
                    </div>
                    <p><span class="text-red">*</span> Wajib diisi.</p>
                </form>
            </div>
        </div>
    </section>
@endsection
