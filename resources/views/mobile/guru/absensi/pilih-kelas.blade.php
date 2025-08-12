<!-- resources/views/mobile/guru/absensi/pilih-kelas.blade.php -->
@extends('mobile.layouts.mobile')
@section('title')
    Pilih Kelas
@endsection
@section('content')
    <h2 class="text-xl font-bold mb-6">Pilih Kelas</h2>

    @if ($kelasList->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">Anda belum ditugaskan mengajar kelas apapun.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($kelasList as $kelas)
                <a href="{{ route('mobile.guru.absensi.create', $kelas->id) }}"
                    class="block bg-white rounded-lg shadow-md p-4 hover:bg-gray-50 transition">
                    <div class="font-bold text-lg">{{ $kelas->nama_kelas }}</div>
                    <div class="text-gray-600 text-sm">Klik untuk isi absensi</div>
                </a>
            @endforeach
        </div>
    @endif
@endsection
