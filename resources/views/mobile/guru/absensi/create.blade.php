<!-- resources/views/mobile/guru/absensi/create.blade.php -->
@extends('mobile.layouts.mobile')
@section('title')
    Tambah Absensi
@endsection
@section('content')
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <h2 class="font-bold text-lg">Absensi - {{ $kelas->nama_kelas }}</h2>
        <p class="text-gray-600 text-sm">Pelajaran: {{ $pelajaran?->nama_mapel }}</p>
        <p class="text-gray-600 text-sm">Tanggal: {{ now()->format('d F Y') }}</p>
    </div>

    <form action="{{ route('mobile.guru.absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="pelajaran_id" value="{{ $pelajaran?->id }}">

        <div class="space-y-3">
            @foreach ($siswas as $siswa)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-medium">{{ $siswa->nama_lengkap }}</div>
                            <div class="text-gray-600 text-sm">NISN: {{ $siswa->nisn }}</div>
                        </div>
                        <div class="text-right">
                            <select name="data[{{ $siswa->id }}][status]"
                                class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="tidak_hadir">Alpa</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input type="text" name="data[{{ $siswa->id }}][keterangan]"
                            placeholder="Keterangan (opsional)"
                            class="w-full border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit"
            class="w-full bg-primary text-white font-bold py-3 px-4 rounded-lg shadow hover:bg-blue-600 mt-6">
            Simpan Absensi
        </button>
    </form>
@endsection
