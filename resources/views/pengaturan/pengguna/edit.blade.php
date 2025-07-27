@extends('layouts.master')
@section('title')
    Ubah Akun
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pengaturan
        @endslot
        @slot('li_2')
            Akun Pengguna
        @endslot
        @slot('title')
            Ubah Akun
        @endslot
    @endcomponent

    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Form Input</h3>
                <div class="pull-right box-tools">
                    <a href="{{ route('users.index') }}" class="btn btn-social btn-sm btn-default">
                        <i class="fa fa-reply"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" action="{{ route('users.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Nama</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->name) }}" placeholder="Nama Lengkap">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $user->email) }}" placeholder="Alamat Email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">Username</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username', $user->username) }}"
                                placeholder="Username">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-9">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-sm-3 control-label">Role</label>

                        <div class="col-sm-9">
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="" hidden>-- Choose --</option>
                                <option value="admin" @if (old('role', $user->role) == 'admin') selected="selected" @endif>Admin
                                </option>
                                <option value="petugas_baznas" @if (old('role', $user->role) == 'petugas_baznas') selected="selected" @endif>
                                    Petugas Baznas</option>
                                <option value="petugas_upz" @if (old('role', $user->role) == 'petugas_upz') selected="selected" @endif>
                                    Petugas UPZ</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-sm-3 control-label">Foto Profil</label>

                        <div class="col-sm-9">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="image"
                                name="avatar" placeholder="Foto">
                            <small class="text-danger">Ukuran Gambar Rekomendasi 250x250 piksel dan Ukuran File Maksimal
                                500KB</small>
                            <p></p>
                            @error('avatar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($user->avatar)
                                {{-- <img class="img-responsive" src="{{ asset('storage/' . $user->avatar) }}" alt="Photo"> --}}
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                    class="img-thumbnail img-fluid mb-3 col-sm-3 d-block" alt="User Image">
                            @else
                                <img class="img-thumbnail img-fluid mb-3 col-sm-5">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Status</label>

                        <div class="col-sm-9">
                            <select class="form-control @error('status') is-invalid @enderror" id="status"
                                name="status">
                                <option value="" hidden>-- Choose --</option>
                                <option value="1" @if (old('status', $user->status) == '1') selected="selected" @endif>
                                    Active
                                </option>
                                <option value="0" @if (old('status', $user->status) == '0') selected="selected" @endif>
                                    Not Active
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
                </form>
            </div>
        </div>
    </section>
@endsection
