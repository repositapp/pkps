@extends('mobile.layouts.mobile')
@section('title', 'Profil')

@section('content')
    <div class="space-y-4">

        <!-- Bagian Header -->
        <div class="bg-blue-500 rounded-b-3xl text-center text-white">
            <div class="flex justify-center">
                <i class="las la-user-circle text-6xl"></i>
            </div>
            <h2 class="mt-2 font-semibold">{{ $user->name }}</h2>
            <p class="text-sm">{{ $user->email }}</p>
        </div>

        <!-- Data Siswa -->
        <div class="bg-white shadow rounded-xl p-4 flex items-center space-x-3">
            <i class="las la-user text-4xl text-gray-400"></i>
            <div>
                <p class="font-medium">{{ $siswa->nama }}</p>
                <p class="text-xs text-gray-500">Kelas {{ $siswa->kelas->first()->nama_kelas ?? '-' }}</p>
                <p class="text-xs text-gray-500">NISN: {{ $siswa->nisn }}</p>
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <div class="bg-white shadow rounded-xl p-4 space-y-3">
            <h3 class="font-semibold text-sm">Informasi Pribadi</h3>

            <div class="flex items-center space-x-3">
                <i class="las la-id-card text-xl text-blue-500"></i>
                <p class="text-sm">{{ $ortu->nama_wali ?? '-' }}</p>
            </div>

            <div class="flex items-center space-x-3">
                <i class="las la-phone text-xl text-blue-500"></i>
                <p class="text-sm">{{ $ortu->no_hp ?? '-' }}</p>
            </div>

            <div class="flex items-center space-x-3">
                <i class="las la-map-marker text-xl text-blue-500"></i>
                <p class="text-sm">{{ $ortu->alamat ?? '-' }}</p>
            </div>
        </div>

        <!-- Tombol Keluar -->
        <form method="POST" action="{{ route('mobile.logout') }}">
            @csrf
            <button type="submit"
                class="w-full bg-red-50 text-red-500 py-2 rounded-xl flex items-center justify-center space-x-2">
                <i class="las la-sign-out-alt text-xl"></i>
                <span>Keluar</span>
            </button>
        </form>

    </div>
@endsection
