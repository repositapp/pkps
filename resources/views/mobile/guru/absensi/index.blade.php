<!-- resources/views/mobile/guru/absensi/index.blade.php -->
@extends('mobile.layouts.mobile')
@section('title')
    Riwayat Absensi
@endsection
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Riwayat Absensi</h2>
        <a href="{{ route('mobile.guru.absensi.pilih-kelas') }}"
            class="bg-primary text-white px-4 py-2 rounded-lg text-sm shadow">
            + Tambah Absen
        </a>
    </div>

    @if ($kehadirans->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">Belum ada data absensi.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($kehadirans as $absen)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between">
                        <div>
                            <div class="font-bold">{{ $absen->siswa->nama_lengkap }}</div>
                            <div class="text-gray-600 text-sm">NISN: {{ $absen->siswa->nisn }}</div>
                        </div>
                        <div class="text-right">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                                @if ($absen->status_kehadiran == 'hadir') bg-green-100 text-green-800
                                @elseif($absen->status_kehadiran == 'izin') bg-blue-100 text-blue-800
                                @elseif($absen->status_kehadiran == 'sakit') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($absen->status_kehadiran) }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <div>Kelas {{ $absen->kelas->nama_kelas }} • Mapel {{ $absen->pelajaran->nama_mapel }}</div>
                        <div>{{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->translatedFormat('l, d F Y') }},
                            {{ \Carbon\Carbon::parse($absen->created_at)->locale('id')->translatedFormat('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $kehadirans->links() }}
        </div>
    @endif
@endsection
