<!-- resources/views/mobile/guru/laporan/index.blade.php -->
@extends('mobile.layouts.mobile')
@section('title')
    Laporan Siswa
@endsection
@section('content')
    <h2 class="text-xl font-bold mb-6">Laporan Siswa</h2>

    @if (!isset($kelasIds) || $kelasIds->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">Anda belum ditugaskan mengajar kelas apapun.</p>
        </div>
    @elseif ($siswas->isEmpty())
        <div class="bg-gray-100 p-4 rounded-lg text-center">
            <p class="text-gray-600">Belum ada siswa di kelas Anda.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($siswas as $siswa)
                <a href="{{ route('mobile.guru.laporan.detail', $siswa->id) }}"
                    class="block bg-white rounded-lg shadow-md p-4 hover:bg-gray-50 transition">
                    <div class="font-bold">{{ $siswa->nama_lengkap }}</div>
                    <div class="text-gray-600 text-sm">NISN: {{ $siswa->nisn }}</div>
                    <div class="text-gray-500 text-xs">Kelas: {{ $siswa->kelasSiswas->first()?->kelas->nama_kelas ?? '-' }}
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
