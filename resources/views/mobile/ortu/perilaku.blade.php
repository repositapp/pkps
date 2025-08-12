@extends('mobile.layouts.mobile')
@section('title', 'Catatan Perilaku Siswa')

@section('content')
    <div class="space-y-4">

        <!-- Filter -->
        <form method="GET" action="{{ route('mobile.ortu.perilaku') }}" class="mb-4">
            <div class="grid grid-cols-1 gap-2 mb-2">
                <!-- Bulan -->
                <select name="bulan" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary">
                    @foreach (range(0, 11) as $i)
                        @php
                            $bulanOption = now()->subMonths($i)->format('Y-m');
                            $labelBulan = now()->subMonths($i)->translatedFormat('F Y');
                        @endphp
                        <option value="{{ $bulanOption }}" {{ $bulanFilter == $bulanOption ? 'selected' : '' }}>
                            {{ $labelBulan }}
                        </option>
                    @endforeach
                </select>

                <!-- Tahun Ajaran -->
                <select name="tahun_ajaran_id" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-1 focus:ring-primary">
                    @foreach ($daftarTahunAjaran as $ta)
                        <option value="{{ $ta->id }}" {{ $tahunAjaranId == $ta->id ? 'selected' : '' }}>
                            Semester {{ $ta->semester }} - {{ $ta->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Riwayat -->
        <div>
            <h3 class="font-semibold mb-3">Riwayat Catatan Perilaku Siswa</h3>
            @forelse($riwayat as $item)
                <div class="bg-white rounded-xl shadow p-3 mb-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                            </p>
                            <div class="flex items-center text-gray-500 text-xs mt-1">
                                <i class="las la-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                            </div>
                            <p class="text-xs mt-2 text-gray-700">
                                {{ $item->catatan }}
                            </p>
                        </div>
                        <div>
                            @php
                                $warna =
                                    $item->kategori_perilaku == 'disiplin'
                                        ? 'bg-green-100 text-green-600'
                                        : 'bg-red-100 text-red-600';
                                $label = ucfirst($item->kategori_perilaku);
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $warna }}">
                                {{ $label }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-red-50 text-red-700 text-center p-3 rounded-lg">
                    Tidak ada catatan perilaku untuk periode ini.
                </div>
            @endforelse
        </div>

    </div>
@endsection
