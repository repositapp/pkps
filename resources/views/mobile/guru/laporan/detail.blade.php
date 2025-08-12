<!-- resources/views/mobile/guru/laporan/detail.blade.php -->
@extends('mobile.layouts.mobile')
@section('title')
    Laporan Siswa
@endsection
@section('content')
    <!-- Profil Siswa -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
        <img src="{{ URL::asset('build/dist/img/avatar.png') }}" alt="Foto Siswa" class="w-16 h-16 rounded-full mx-auto mb-3">
        <h2 class="font-bold text-lg">{{ $siswa->nama_lengkap }}</h2>
        <p class="text-gray-600 text-sm">NISN: {{ $siswa->nisn }}</p>
        <p class="text-primary text-sm font-medium">
            Kelas: {{ $siswa->kelasSiswas->first()?->kelas->nama_kelas ?? '-' }}
        </p>
    </div>

    <!-- Tabs -->
    <div class="flex border-b mb-6">
        <button id="tab-absensi" class="tab-button px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600">
            Absensi
        </button>
        <button id="tab-perilaku" class="tab-button px-4 py-2 text-gray-600">
            Perilaku
        </button>
    </div>

    <!-- Konten Tab -->
    <div id="tab-content-absensi" class="tab-content">
        @if ($kehadirans->isEmpty())
            <p class="text-gray-500 text-sm text-center">Belum ada data absensi.</p>
        @else
            <div class="space-y-3">
                @foreach ($kehadirans as $absen)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between">
                            <div>
                                <div class="font-medium">{{ $absen->kelas->nama_kelas }}</div>
                                <div class="text-gray-600 text-sm">{{ $absen->pelajaran->nama_mapel }}</div>
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
                            {{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->translatedFormat('d F Y') }}
                            @if ($absen->keterangan)
                                <div class="mt-1">"{{ $absen->keterangan }}"</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div id="tab-content-perilaku" class="tab-content hidden">
        @if ($perilakus->isEmpty())
            <p class="text-gray-500 text-sm text-center">Belum ada catatan perilaku.</p>
        @else
            <div class="space-y-3">
                @foreach ($perilakus as $perilaku)
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between">
                            <div>
                                <div class="font-medium">{{ $perilaku->kelas->nama_kelas }}</div>
                                <div class="text-gray-600 text-sm">{{ $perilaku->pelajaran->nama_mapel }}</div>
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
                            {{ \Carbon\Carbon::parse($perilaku->tanggal)->locale('id')->translatedFormat('d F Y') }}
                            <div class="mt-1">"{{ $perilaku->catatan }}"</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- JavaScript untuk Tabs -->
    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Hapus aktif
                document.querySelectorAll('.tab-button').forEach(b =>
                    b.classList.remove('text-blue-600', 'border-blue-600')
                );
                document.querySelectorAll('.tab-button').forEach(b =>
                    b.classList.add('text-gray-600')
                );
                document.querySelectorAll('.tab-content').forEach(c =>
                    c.classList.add('hidden')
                );

                // Tambah aktif
                button.classList.remove('text-gray-600');
                button.classList.add('text-blue-600', 'border-blue-600');
                const tabName = button.id.replace('tab-', '');
                document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
            });
        });
    </script>
@endsection
