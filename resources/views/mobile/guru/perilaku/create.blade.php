@extends('mobile.layouts.mobile')
@section('title')
    Tambah Perilaku
@endsection
@section('content')
<div class="space-y-4">
    <div class="bg-white rounded-lg shadow-md p-4 mb-4">
        <h1 class="text-lg font-bold">Tambah Perilaku Siswa</h1>
        <p class="text-sm text-gray-500">Kelas {{ $kelas->nama_kelas }}</p>
        <p class="text-gray-600 text-sm">Tanggal: {{ now()->format('d F Y') }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('mobile.guru.perilaku.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
            <input type="hidden" name="pelajaran_id" value="{{ $pelajaran?->id }}">

            <!-- Siswa -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Siswa</label>
                <select name="siswa_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Pilih nama siswa</option>
                    @foreach ($siswas as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kategori Perilaku -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Perilaku</label>
                <select name="kategori_perilaku" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Pilih kategori perilaku</option>
                    <option value="taat">Taat</option>
                    <option value="disiplin">Disiplin</option>
                    <option value="melanggar">Melanggar</option>
                </select>
            </div>

            <!-- Deskripsi Perilaku -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Perilaku</label>
                <textarea name="catatan" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                          placeholder="Tuliskan detail perilaku siswa..."></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="window.history.back()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection