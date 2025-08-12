@extends('mobile.layouts.mobile')
@section('title')
    Jadwal
@endsection
@section('content')
    <!-- Header Profil -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6 text-center">
        <h2 class="font-bold text-lg">{{ $guru->nama_lengkap }}</h2>
        <p class="text-gray-600 text-sm">NIP. {{ $guru->nip }}</p>
        <p class="text-primary text-sm font-medium">Guru {{ $guru->user->name }}</p>
    </div>

    <!-- Info Tahun Ajaran -->
    @if (isset($tahunAjaran))
        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 mb-6 rounded">
            <p class="text-sm text-blue-800">
                <i class="las la-calendar mr-1"></i>
                Tahun Ajaran: <strong>{{ $tahunAjaran->tahun_ajaran }} ({{ $tahunAjaran->semester }})</strong>
            </p>
        </div>
    @endif

    <!-- Jadwal Mengajar -->
    <div class="space-y-4 mb-6">
        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
            @php
                $jadwalHari = $jadwal->get($hari, collect());
            @endphp
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="font-bold text-lg text-primary mb-3">{{ $hari }}</h3>
                @if ($jadwalHari->count() > 0)
                    <ul class="space-y-2">
                        @foreach ($jadwalHari as $item)
                            <li class="text-sm border-b pb-2">
                                <div class="font-medium">Mata Pelajaran {{ $item->pelajaran->nama_mapel }}</div>
                                <div class="text-gray-600">Kelas: {{ $item->kelas->nama_kelas }}</div>
                                <div class="text-gray-500 text-xs">Jam: 07.00 - 09.00</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Tidak ada jadwal mengajar.</p>
                @endif
            </div>
        @endforeach
    </div>
@endsection
