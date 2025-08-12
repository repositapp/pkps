@extends('mobile.layouts.mobile')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4 mb-4">
        <img src="@if (Auth::user()->avatar != '') {{ asset('storage/' . Auth::user()->avatar) }}@else{{ URL::asset('build/dist/img/user2-160x160.jpg') }} @endif"
            alt="Foto Guru" class="w-16 h-16 rounded-full object-cover">
        <div>
            <h2 class="font-semibold text-lg">{{ $guru->nama_lengkap }}</h2>
            <p class="text-sm text-gray-500">NIP. {{ $guru->nip }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <i class="las la-user-graduate text-blue-500 text-3xl"></i>
            <p class="text-gray-500 text-sm mt-1">Total Siswa</p>
            <p class="font-bold text-xl">{{ $totalSiswa }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <i class="las la-user-check text-green-500 text-3xl"></i>
            <p class="text-gray-500 text-sm mt-1">Hadir Hari Ini</p>
            <p class="font-bold text-xl">{{ $hadir }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <i class="las la-user-times text-orange-500 text-3xl"></i>
            <p class="text-gray-500 text-sm mt-1">Izin/Sakit</p>
            <p class="font-bold text-xl">{{ $izin + $sakit }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
            <i class="las la-book text-purple-500 text-3xl"></i>
            <p class="text-gray-500 text-sm mt-1">Catatan Perilaku</p>
            <p class="font-bold text-xl">{{ $alpa }}</p>
        </div>
    </div>

    <!-- Menu -->
    <div class="mt-4 grid grid-cols-3 gap-4">
        <a href="{{ route('mobile.guru.absensi.index') }}">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                <i class="las la-calendar-check text-blue-500 text-3xl"></i>
                <p class="text-sm mt-1 text-gray-700 text-center">Absensi Kelas</p>
            </div>
        </a>
        <a href="{{ route('mobile.guru.perilaku.index') }}">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                <i class="las la-book text-green-500 text-3xl"></i>
                <p class="text-sm mt-1 text-gray-700 text-center">Catatan Perilaku</p>
            </div>
        </a>
        <a href="{{ route('mobile.guru.absensi.laporan') }}">
            <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center">
                <i class="las la-chart-bar text-orange-500 text-3xl"></i>
                <p class="text-sm mt-1 text-gray-700 text-center">Laporan Siswa</p>
            </div>
        </a>
    </div>
@endsection
