<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    protected $hariIndonesia = [
        'senin' => 'Senin',
        'selasa' => 'Selasa',
        'rabu' => 'Rabu',
        'kamis' => 'Kamis',
        'jumat' => 'Jumat',
        'sabtu' => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    public function index()
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        // Ambil semua jadwal untuk barber ini
        $jadwals = Jadwal::where('barber_id', $barberId)->orderBy('hari_dalam_minggu')->get();

        // Daftar hari lengkap untuk memeriksa apakah semua sudah ada
        $daftarHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        $hariSudahAda = $jadwals->pluck('hari_dalam_minggu')->toArray();
        $semuaHariTerisi = count(array_diff($daftarHari, $hariSudahAda)) === 0;

        return view('jadwal.index',  compact('jadwals', 'semuaHariTerisi'));
    }

    public function create()
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        // Ambil jadwal yang sudah ada untuk barber ini
        $jadwals = Jadwal::where('barber_id', $barberId)->get();
        $hariSudahAda = $jadwals->pluck('hari_dalam_minggu')->toArray();

        // Daftar hari lengkap
        $daftarHari = [
            'senin' => 'Senin',
            'selasa' => 'Selasa',
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu',
        ];

        // Filter hari yang belum ada
        $hariTersedia = array_diff_key($daftarHari, array_flip($hariSudahAda));

        // Jika semua hari sudah terisi, redirect
        if (empty($hariTersedia)) {
            return redirect()->route('admin-barber.jadwal.index')->with(['info' => 'Semua hari dalam minggu sudah memiliki jadwal.']);
        }

        return view('jadwal.create', compact('hariTersedia'));
    }

    public function store(Request $request)
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $validatedData = $request->validate([
            'hari_dalam_minggu' => [
                'required',
                Rule::in(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']),
                // Validasi unik untuk kombinasi barber_id dan hari_dalam_minggu
                Rule::unique('jadwals')->where(function ($query) use ($barberId) {
                    return $query->where('barber_id', $barberId);
                }),
            ],
            'waktu_buka' => 'required|date_format:H:i',
            'waktu_tutup' => 'required|date_format:H:i|after:waktu_buka',
            'maksimum_pelanggan_per_jam' => 'required|integer|min:1|max:50',
            'hari_kerja' => 'required|boolean',
        ], [
            'hari_dalam_minggu.unique' => 'Jadwal untuk hari ini sudah ada.',
            'waktu_tutup.after' => 'Waktu tutup harus setelah waktu buka.',
            'maksimum_pelanggan_per_jam.min' => 'Maksimum pelanggan per jam minimal 1.',
            'maksimum_pelanggan_per_jam.max' => 'Maksimum pelanggan per jam maksimal 50.',
        ]);

        $validatedData['barber_id'] = $barberId;

        Jadwal::create($validatedData);

        return redirect()->route('jadwal.index')->with(['success' => 'Data Jadwal berhasil ditambahkan!']);
    }

    public function edit(string $hari)
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->route('jadwal.index')->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        if (!array_key_exists($hari, $this->hariIndonesia)) {
            return redirect()->route('jadwal.index')->with(['error' => 'Hari tidak valid.']);
        }

        $jadwal = Jadwal::firstOrCreate(
            ['barber_id' => $barberId, 'hari_dalam_minggu' => $hari],
            [
                'waktu_buka' => '08:00:00',
                'waktu_tutup' => '17:00:00',
                'maksimum_pelanggan_per_jam' => 5,
                'hari_kerja' => $hari !== 'minggu',
            ]
        );

        $namaHari = $this->hariIndonesia[$hari];

        return view('jadwal.edit', compact('jadwal', 'namaHari'));
    }

    public function update(Request $request, string $hari)
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->route('jadwal.index')->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        if (!array_key_exists($hari, $this->hariIndonesia)) {
            return redirect()->route('jadwal.index')->with(['error' => 'Hari tidak valid.']);
        }

        $validatedData = $request->validate([
            'waktu_buka' => 'required',
            'waktu_tutup' => 'required|after:waktu_buka',
            'maksimum_pelanggan_per_jam' => 'required|integer|min:1|max:20',
        ], [
            'waktu_tutup.after' => 'Waktu tutup harus setelah waktu buka.',
            'maksimum_pelanggan_per_jam.min' => 'Maksimum pelanggan per jam minimal 1.',
            'maksimum_pelanggan_per_jam.max' => 'Maksimum pelanggan per jam maksimal 20.',
        ]);

        $jadwal = Jadwal::firstOrCreate(
            ['barber_id' => $barberId, 'hari_dalam_minggu' => $hari],
            [
                'waktu_buka' => 'required|date_format:H:i',
                'waktu_tutup' => 'required|date_format:H:i|after:waktu_buka',
                'maksimum_pelanggan_per_jam' => 'required|integer|min:1|max:50',
            ]
        );

        $jadwal->update($validatedData);

        $namaHari = $this->hariIndonesia[$hari];
        return redirect()->route('jadwal.index')->with(['success' => "Jadwal untuk hari {$namaHari} berhasil diperbarui!"]);
    }

    public function toggleStatus(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $jadwal = Jadwal::findOrFail($id);

        if ($jadwal->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        $jadwal->hari_kerja = !$jadwal->hari_kerja;
        $jadwal->save();

        $statusText = $jadwal->hari_kerja ? 'diaktifkan (Hari Kerja)' : 'dinonaktifkan (Hari Libur)';
        $namaHari = $this->hariIndonesia[$jadwal->hari_dalam_minggu] ?? $jadwal->hari_dalam_minggu;
        return redirect()->back()->with(['success' => "Jadwal hari {$namaHari} berhasil {$statusText}!"]);
    }
}
