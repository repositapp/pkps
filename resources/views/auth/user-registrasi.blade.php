@extends('layouts.mobile')
@section('title')
    Registrasi
@endsection
@section('content')
    <div class="p-4">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.register.post') }}" id="registerForm">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label">Nama Lengkap:&nbsp;<span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-lg bg-light @error('name') is-invalid @enderror"
                    placeholder="Masukan Nama Lengkap" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <small class="mt-1" style="color: #ff0000;">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email:&nbsp;<span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-lg bg-light @error('email') is-invalid @enderror"
                    placeholder="Masukan Email Aktif" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <small class="mt-1" style="color: #ff0000;">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="telepon" class="form-label">Nomor Telepon:&nbsp;<span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-lg bg-light @error('telepon') is-invalid @enderror"
                    placeholder="Masukan No.HP/WA Aktif" id="telepon" name="telepon" value="{{ old('telepon') }}">
                @error('telepon')
                    <small class="mt-1" style="color: #ff0000;">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="form-label">Alamat:&nbsp;<span class="text-danger">*</span></label>
                <textarea class="form-control rounded-lg bg-light @error('alamat') is-invalid @enderror"
                    placeholder="Masukan Alamat...." id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <small class="mt-1" style="color: #ff0000;">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="username" class="form-label">Username:&nbsp;<span class="text-danger">*</span></label>
                <input type="text" class="form-control rounded-lg bg-light @error('username') is-invalid @enderror"
                    placeholder="Masukan Username" id="username" name="username" value="{{ old('username') }}">
                @error('username')
                    <small class="mt-1" style="color: #ff0000;">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password:&nbsp;<span class="text-danger">*</span></label>
                <input type="password" class="form-control rounded-lg bg-light" placeholder="Masukan Password"
                    id="password" name="password">
                @error('username')
                    <small class="mt-1" style="color: #ff0000;">{{ $message }}</small>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-danger btn-sm fw-bold py-3 px-4 w-100 rounded-4 shadow-sm">Daftar
                    Sekarang</button>
                <div class="d-grid">
                </div>
                <div class="d-flex align-items-center justify-content-between divide my-3">
                    <hr class="w-100">
                    <span class="text-muted small px-2">OR</span>
                    <hr class="w-100">
                </div>
                <div>Sudah punya akun?&nbsp;<a href="{{ route('user.login') }}"
                        class="text-decoration-none text-danger">Login</a>
                </div>
            </div>
        </form>
    </div>
@endsection
