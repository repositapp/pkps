@extends('mobile.layouts.mobile')
@section('title', 'Laporan Perilaku Siswa')

@section('content')
    <!-- Tabs -->
    <div class="flex border-b border-gray-200 mb-4">
        <a href="{{ route('mobile.guru.absensi.laporan') }}"
            class="w-1/2 text-center py-2 font-medium border-b-2 border-transparent text-gray-500">
            Absensi
        </a>
        <a href="{{ route('mobile.guru.perilaku.laporan') }}"
            class="w-1/2 text-center py-2 font-medium border-b-2 border-primary text-primary">
            Perilaku
        </a>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('mobile.guru.perilaku.laporan') }}" class="mb-4">
        <div class="grid grid-cols-1 gap-2 mb-2">
            <select name="kelas_id"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary">
                <option value="">Semua Kelas</option>
                @foreach ($kelasList as $k)
                    <option value="{{ $k->id }}" {{ $filterKelas == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <input type="date" name="start_date" value="{{ $startDate }}"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary">

            <input type="date" name="end_date" value="{{ $endDate }}"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary">
        </div>

        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            <i class="las la-search"></i> Cari
        </button>
    </form>

    <!-- List Kelas -->
    <div class="space-y-4">
        @forelse($laporanPerilaku as $laporan)
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-semibold">{{ $laporan['kelas']->nama_kelas }}</span>
                    <span class="text-green-600 font-semibold">{{ $laporan['total_catatan'] }} Catatan</span>
                </div>
                <p class="text-sm text-gray-600 mb-1">
                    Mata Pelajaran: {{ $laporan['pelajaran']->nama_mapel }}
                </p>
                <p class="text-sm text-gray-600 mb-2">
                    Total Siswa: {{ $laporan['total_siswa'] }}
                </p>
                <div class="flex gap-2">
                    <a href="{{ route('mobile.guru.perilaku.laporan.cetak', [$laporan['kelas']->id]) }}"
                        class="w-full flex items-center justify-center gap-1 w-1/2 bg-primary text-white px-3 py-2 rounded-lg text-sm font-medium">
                        <i class="las la-print text-lg"></i> Cetak Laporan
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-red-50 text-red-700 text-center p-3 rounded-lg">
                Tidak ada data laporan.
            </div>
        @endforelse
    </div>
@endsection
