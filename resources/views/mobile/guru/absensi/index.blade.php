@extends('mobile.layouts.mobile')
@section('title')
    Riwayat Absensi
@endsection
@section('content')
    <div class="space-y-4">

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('mobile.guru.absensi.index') }}" class="space-y-3 mb-4">
            <div class="grid grid-cols-2 gap-2">
                {{-- Pilih Mapel --}}
                <select name="pelajaran_id" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary w-full">
                    <option value="">Pilih Mapel</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" {{ $pelajaranId == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>

                {{-- Pilih Kelas --}}
                <select name="kelas_id" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary w-full">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Tanggal --}}
            <div>
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary w-full">
            </div>

            {{-- Cari Nama Siswa --}}
            <div class="relative">
                <i class="las la-search absolute left-3 top-2.5 text-gray-400 text-lg"></i>
                <input type="text" name="search" placeholder="Cari nama siswa..." value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg pl-10 pr-3 py-2 text-sm w-full focus:ring-1 focus:ring-primary">
            </div>
        </form>

        {{-- Daftar Kehadiran --}}
        <div class="bg-white rounded-lg shadow p-3">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h2 class="font-semibold text-gray-700">Daftar Kehadiran</h2>
                @if ($tanggal)
                    <span class="text-sm text-gray-500">
                        <i class="las la-calendar"></i> {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                    </span>
                @endif
            </div>

            @forelse($kehadiran as $item)
                <div class="flex justify-between items-center py-2 border-b last:border-b-0">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->siswa->nama_lengkap }}</p>
                        <p class="text-sm text-gray-500">NIS: {{ $item->siswa->nisn }}</p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold
                    @if ($item->status_kehadiran == 'hadir') bg-green-100 text-green-600
                    @elseif($item->status_kehadiran == 'izin') bg-blue-100 text-blue-600
                    @elseif($item->status_kehadiran == 'tidak_hadir') bg-red-100 text-red-600
                    @elseif($item->status_kehadiran == 'sakit') bg-yellow-100 text-yellow-600 @endif">
                        @if ($item->status_kehadiran == 'hadir')
                            Hadir
                        @elseif($item->status_kehadiran == 'izin')
                            Izin
                        @elseif($item->status_kehadiran == 'tidak_hadir')
                            Alpa
                        @elseif($item->status_kehadiran == 'sakit')
                            Sakit
                        @endif
                    </span>
                </div>
            @empty
                <div class="bg-red-50 text-red-700 text-center p-3 rounded-lg">
                    Belum ada data kehadiran.
                </div>
            @endforelse
        </div>

        {{-- Tombol Tambah --}}
        <a href="{{ route('mobile.guru.absensi.pilih-kelas') }}"
            class="fixed bottom-16 right-6 bg-primary text-white rounded-full p-4 shadow-lg">
            <i class="las la-plus text-2xl"></i>
        </a>

    </div>
@endsection
