@extends('mobile.layouts.mobile')
@section('title')
    Riwayat Perilaku
@endsection
@section('content')
    <div class="space-y-4">
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('mobile.guru.perilaku.index') }}" class="space-y-3 mb-4">
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

        {{-- Daftar Catatan Perilaku --}}
        <div class="bg-white rounded-lg shadow p-3">
            <div class="flex justify-between items-center border-b pb-2 mb-2">
                <h2 class="text-gray-800 font-semibold">Daftar Catatan Perilaku</h2>
                <span class="text-sm text-gray-500 flex items-center gap-1">
                    <i class="las la-calendar"></i>
                    {{ $tanggal ? \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                </span>
            </div>

            <div class="space-y-2">
                @forelse ($perilaku as $catatan)
                    <div class="bg-white rounded-lg shadow p-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">{{ $catatan->siswa->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($catatan->tanggal)->translatedFormat('l, d M Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                @if ($catatan->kategori_perilaku === 'taat' || $catatan->kategori_perilaku === 'disiplin')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-600">Positif</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-600">Negatif</span>
                                @endif
                            </div>
                        </div>
                        <p class="mt-2 text-gray-700 text-sm">{{ $catatan->catatan }}</p>
                    </div>
                @empty
                    <div class="bg-red-50 text-red-700 text-center p-3 rounded-lg">
                        Belum ada data catatan perilaku.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Tombol Tambah --}}
        <a href="{{ route('mobile.guru.perilaku.pilih-kelas') }}"
            class="fixed bottom-20 right-6 bg-primary text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg">
            <i class="las la-plus text-2xl"></i>
        </a>
    </div>
@endsection
