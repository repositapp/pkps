<!-- resources/views/mobile/guru/perilaku/index.blade.php -->
@extends('mobile.layouts.mobile')
@section('title')
    Riwayat Perilaku
@endsection
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Riwayat Perilaku</h2>
        <a href="{{ route('mobile.guru.perilaku.pilih-kelas') }}"
            class="bg-primary text-white px-4 py-2 rounded-lg text-sm shadow">
            + Tambah Perilaku
        </a>
    </div>

    @if ($perilakus->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700">Belum ada catatan perilaku.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($perilakus as $perilaku)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between">
                        <div>
                            <div class="font-bold">{{ $perilaku->siswa->nama_lengkap }}</div>
                            <div class="text-gray-600 text-sm">NISN: {{ $perilaku->siswa->nisn }}</div>
                        </div>
                        <div class="text-right">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium
                                @if ($perilaku->kategori_perilaku == 'taat') bg-green-100 text-green-800
                                @elseif($perilaku->kategori_perilaku == 'disiplin') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($perilaku->kategori_perilaku) }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <div>Kelas {{ $perilaku->kelas->nama_kelas }} • Mapel {{ $perilaku->pelajaran->nama_mapel }}</div>
                        <div>{{ \Carbon\Carbon::parse($perilaku->tanggal)->locale('id')->translatedFormat('l, d F Y') }},
                            {{ \Carbon\Carbon::parse($perilaku->created_at)->locale('id')->translatedFormat('H:i') }}
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-700">
                        "{{ Str::limit($perilaku->catatan, 60) }}"
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $perilakus->links() }}
        </div>
    @endif
@endsection
