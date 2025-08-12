@extends('mobile.layouts.mobile')
@section('title', 'Dashboard Orang Tua')

@section('content')
    <div class="space-y-4">

        <!-- Profil Siswa -->
        <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
            <div>
                <h2 class="text-lg font-semibold">{{ $siswa->nama_lengkap }}</h2>
                <p class="text-sm text-gray-600">Kelas {{ $kelasAktif?->nama_kelas ?? '-' }}</p>
                <p class="text-sm text-gray-500">NISN: {{ $siswa->nisn }}</p>
            </div>
        </div>

        <!-- Menu Card -->
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('mobile.ortu.absensi') }}"
                class="bg-white rounded-xl shadow p-4 flex flex-col items-center justify-center text-center hover:shadow-md transition">
                <i class="las la-calendar-check text-blue-500 text-3xl mb-2"></i>
                <span class="text-sm font-medium">Absensi Siswa</span>
            </a>
            <a href="{{ route('mobile.ortu.perilaku') }}"
                class="bg-white rounded-xl shadow p-4 flex flex-col items-center justify-center text-center hover:shadow-md transition">
                <i class="las la-file-alt text-green-500 text-3xl mb-2"></i>
                <span class="text-sm font-medium">Catatan Perilaku</span>
            </a>
        </div>

        <!-- Grafik Kehadiran -->
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-sm font-semibold mb-3">Kehadiran Minggu Ini</h3>
            <canvas id="chartKehadiran" height="140"></canvas>
        </div>

        <!-- Catatan Perilaku Terbaru -->
        <div class="bg-white rounded-xl shadow p-4">
            <h3 class="text-sm font-semibold mb-3">Catatan Perilaku Terbaru</h3>
            <div class="space-y-3">
                @forelse($perilakuTerbaru as $catatan)
                    <div class="flex items-center gap-3">
                        @if ($catatan->kategori_perilaku == 'taat' || $catatan->kategori_perilaku == 'disiplin')
                            <i class="las la-check-circle text-green-500 text-xl"></i>
                        @else
                            <i class="las la-times-circle text-red-500 text-xl"></i>
                        @endif
                        <div>
                            <p class="text-sm">{{ $catatan->catatan }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($catatan->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Tidak ada catatan perilaku terbaru.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartKehadiran').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelKehadiran) !!},
                datasets: [{
                    label: 'Hadir',
                    data: {!! json_encode($dataKehadiran) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
