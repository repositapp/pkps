@extends('layouts.mobile')
@section('title')
    Login
@endsection
@section('content')
    <div class="p-4">
        {{-- @if (session('loginError'))
            <div class="alert alert-danger" role="alert">
                {{ session('loginError') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif --}}
        <form method="POST" action="{{ route('user.authentication') }}" id="userLoginForm">
            @csrf
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
                <div class="d-grid">
                    <button type="submit"
                        class="btn btn-danger btn-sm fw-bold py-3 px-4 w-100 rounded-4 shadow-sm">Login</button>
                </div>
                <div class="d-flex align-items-center justify-content-between divide my-3">
                    <hr class="w-100">
                    <span class="text-muted small px-2">OR</span>
                    <hr class="w-100">
                </div>
                <div>Belum punya akun?&nbsp;<a href="{{ route('user.register') }}"
                        class="text-decoration-none text-danger">Registrasi</a>
                </div>
            </div>
        </form>
    </div>
@endsection
