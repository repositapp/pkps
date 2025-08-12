@extends('mobile.layouts.mobile-login')
@section('title', 'Login')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <!-- Logo dan Judul -->
                <div class="flex items-center justify-center mb-6">
                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo Sekolah" class="w-24 h-24">
                </div>

                <!-- Header -->
                <h2 class="text-2xl font-bold text-center mb-2">Selamat Datang</h2>
                <p class="text-gray-600 text-center mb-6">Silakan masuk ke akun Anda</p>

                <!-- Form Login -->
                <form action="{{ route('mobile.authenticate') }}" method="POST" class="w-full max-w-sm" id="loginForm">
                    @csrf
                    <!-- Username -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                        <input name="username"
                            class="border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('username') border-red-500 @enderror"
                            id="username" type="text" placeholder="Masukkan Username" value="{{ old('username') }}"
                            required>
                        @error('username')
                            <p class="text-red-500 text-xs mt-1"><i class="las la-exclamation-triangle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-1" for="password">Password</label>
                        <input name="password"
                            class="border border-gray-300 rounded-md w-full py-2 px-4 text-gray-700 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                            id="password" type="password" placeholder="Masukkan Password" required>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1"><i class="las la-exclamation-triangle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol Masuk -->
                    <button type="submit" id="loginBtn"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 mb-4 flex items-center justify-center gap-2">
                        <span id="btnText">Masuk</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
