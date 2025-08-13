<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\Perilaku;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileGuruController extends Controller
{
    public function dashboard()
    {
        // Ambil data guru yang login
        $guru = Guru::where('user_id', Auth::id())->with('user')->firstOrFail();

        // Tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        // Jika tidak ada tahun ajaran aktif, ambil yang terbaru
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        // Total siswa yang diajar oleh guru (dari relasi guru_mapels)
        $kelasIds = $guru->guruMapels->pluck('kelas_id')->unique();
        $pelajaranIds = $guru->guruMapels->pluck('pelajaran_id')->unique();

        $totalSiswa = Siswa::whereHas('kelasSiswas', function ($q) use ($kelasIds, $tahunAjaran) {
            $q->whereIn('kelas_id', $kelasIds)
                ->where('tahun_ajaran_id', $tahunAjaran?->id);
        })->count();

        // Kehadiran hari ini
        $today = now()->format('Y-m-d');
        $kehadiran = Kehadiran::where('tanggal', $today)
            ->whereIn('kelas_id', $kelasIds)
            ->whereIn('pelajaran_id', $pelajaranIds)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->get();

        $hadir = $kehadiran->where('status_kehadiran', 'hadir')->count();
        $izin = $kehadiran->where('status_kehadiran', 'izin')->count();
        $sakit = $kehadiran->where('status_kehadiran', 'sakit')->count();
        $alpa = $totalSiswa - $hadir - $izin - $sakit;

        // Catatan perilaku terbaik (3 terakhir)
        $perilakuTerbaik = Perilaku::where('kategori_perilaku', 'taat')
            ->orWhere('kategori_perilaku', 'disiplin')
            ->whereIn('kelas_id', $kelasIds)
            ->whereIn('pelajaran_id', $pelajaranIds)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with('siswa')
            ->latest()
            ->take(3)
            ->get();

        return view('mobile.guru.dashboard', compact(
            'guru',
            'totalSiswa',
            'hadir',
            'izin',
            'sakit',
            'alpa',
            'perilakuTerbaik'
        ));
    }

    public function jadwal()
    {
        // Ambil data guru yang login
        $guru = Guru::where('user_id', Auth::id())->with('user')->firstOrFail();

        // Ambil tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        // Ambil jadwal mengajar guru
        $jadwal = GuruMapel::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with(['kelas', 'pelajaran'])
            ->get()
            ->groupBy('hari'); // Jika ada kolom `hari` di guru_mapels

        // Jika tidak ada kolom `hari`, kita kelompokkan manual atau tampilkan semua
        if ($jadwal->isEmpty()) {
            $jadwal = collect([
                'Senin' => collect(),
                'Selasa' => collect(),
                'Rabu' => collect(),
                'Kamis' => collect(),
                'Jumat' => collect(),
                'Sabtu' => collect(),
            ]);
        }

        return view('mobile.guru.jadwal', compact('guru', 'jadwal', 'tahunAjaran'));
    }

    public function profil()
    {
        // Ambil data guru yang login
        $guru = Guru::where('user_id', Auth::id())->with('user')->firstOrFail();

        // Ambil tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        return view('mobile.guru.profil', compact('guru', 'tahunAjaran'));
    }

    // Absensi
    public function absensiIndex(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        // Filter mapel, kelas, tanggal, dan search
        $pelajaranId = $request->input('pelajaran_id');
        $kelasId = $request->input('kelas_id');
        $tanggal = $request->input('tanggal');
        $search = $request->input('search');

        // Ambil semua mapel yang diajar oleh guru
        $mapels = GuruMapel::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with('pelajaran')
            ->get()
            ->pluck('pelajaran');

        // Ambil semua kelas yang diajar oleh guru
        $kelasIds = GuruMapel::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->pluck('kelas_id');

        $kelasList = Kelas::whereIn('id', $kelasIds)->get();

        // Filter data kehadiran
        $kehadiran = Kehadiran::query()
            ->when($pelajaranId, function ($query) use ($pelajaranId) {
                return $query->where('pelajaran_id', $pelajaranId);
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                return $query->whereHas('siswa.kelasSiswas', function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            })
            ->when($tanggal, function ($query) use ($tanggal) {
                return $query->where('tanggal', $tanggal);
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                });
            })
            ->with(['siswa', 'kelas'])
            ->latest()
            ->paginate(10);

        return view('mobile.guru.absensi.index', compact(
            'guru',
            'mapels',
            'kelasList',
            'kehadiran',
            'pelajaranId',
            'kelasId',
            'tanggal',
            'search'
        ));
    }

    // 2. Pilih Kelas untuk Absen Baru
    public function absensiPilihKelas()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Ambil kelas yang diajar guru (dari guru_mapels)
        $kelasList = GuruMapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get()
            ->pluck('kelas')
            ->unique('id');

        return view('mobile.guru.absensi.pilih-kelas', compact('kelasList'));
    }

    // 3. Form Tambah Absensi (Daftar Siswa)
    public function absensiCreate($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        // Cek apakah guru mengajar kelas ini
        $allowed = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $kelas_id)
            ->exists();

        if (!$allowed) {
            return redirect()->route('mobile.guru.absensi.pilih-kelas')
                ->with('error', 'Anda tidak mengajar kelas ini.');
        }

        // Ambil mata pelajaran yang diajar guru di kelas ini
        $mapels = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $kelas_id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->with('pelajaran')
            ->get()
            ->pluck('pelajaran')
            ->unique('id')
            ->values();

        // Ambil siswa di kelas ini
        $siswas = Siswa::whereHas('kelasSiswas', function ($q) use ($kelas_id) {
            $q->where('kelas_id', $kelas_id);
        })->get();

        // Ambil pelajaran yang diajar guru di kelas ini
        $pelajaran = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $kelas_id)
            ->with('pelajaran')
            ->first()?->pelajaran;

        return view('mobile.guru.absensi.create', compact('kelas', 'siswas', 'pelajaran', 'mapels'));
    }

    // 4. Simpan Absensi
    public function absensiStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'data.*.status' => 'required|in:hadir,izin,sakit,tidak_hadir',
            'data.*.keterangan' => 'nullable|string|max:255',
        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        if (!$tahunAjaran) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $today = now()->format('Y-m-d');

        foreach ($request->data as $siswa_id => $data) {
            Kehadiran::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'tanggal' => $today,
                    'kelas_id' => $request->kelas_id,
                    'pelajaran_id' => $request->pelajaran_id,
                ],
                [
                    'status_kehadiran' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                ]
            );
        }

        return redirect()->route('mobile.guru.absensi.index')
            ->with('success', 'Absensi berhasil disimpan!');
    }

    public function laporanAbsensi(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Ambil tahun ajaran aktif (default)
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        // List kelas & mapel yang diajar guru
        $guruMapels = GuruMapel::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with(['kelas', 'pelajaran'])
            ->get();

        $kelasList = $guruMapels->pluck('kelas')->unique('id');

        // Filter input
        $filterKelas = $request->kelas_id;
        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($request->end_date)->format('Y-m-d');

        // Default tanggal: hari ini jika tidak dipilih
        if (!$startDate) $startDate = now()->startOfMonth()->format('Y-m-d');
        if (!$endDate) $endDate = now()->endOfMonth()->format('Y-m-d');

        $laporanAbsensi = [];

        foreach ($guruMapels as $mapel) {
            $kelas = $mapel->kelas;

            // Filter kelas
            if ($filterKelas && $kelas->id != $filterKelas) {
                continue;
            }

            // Filter pencarian nama kelas
            if ($filterKelas && stripos($kelas->nama_kelas, $filterKelas) === false) {
                continue;
            }

            // Total siswa di kelas ini
            $totalSiswa = Siswa::whereHas('kelasSiswas', function ($q) use ($kelas, $tahunAjaran) {
                $q->where('kelas_id', $kelas->id)
                    ->where('tahun_ajaran_id', $tahunAjaran?->id);
            })->count();

            // Hitung jumlah hadir pada periode
            $hadir = Kehadiran::where('kelas_id', $kelas->id)
                ->where('pelajaran_id', $mapel->pelajaran_id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->where('status_kehadiran', 'hadir')
                ->count();

            $persentase = $totalSiswa > 0 ? round(($hadir / ($totalSiswa)) * 100, 2) : 0;

            $laporanAbsensi[] = [
                'kelas' => $kelas,
                'pelajaran' => $mapel->pelajaran,
                'total_siswa' => $totalSiswa,
                'hadir' => $hadir,
                'persentase' => $persentase,
            ];
        }

        return view('mobile.guru.absensi.laporan', compact(
            'laporanAbsensi',
            'kelasList',
            'filterKelas',
            'startDate',
            'endDate',
            'tahunAjaran'
        ));
    }

    public function laporanAbsensiCetak($kelas_id)
    {
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        $kelas = Kelas::findOrFail($kelas_id);
        $siswas = Siswa::whereHas('kelasSiswas', function ($q) use ($kelas_id, $tahunAjaran) {
            $q->where('kelas_id', $kelas_id)
                ->where('tahun_ajaran_id', $tahunAjaran?->id);
        })->get();

        $laporan = [];
        foreach ($siswas as $siswa) {
            $hadir = Kehadiran::where('siswa_id', $siswa->id)
                ->where('status_kehadiran', 'hadir')
                ->count();
            $izin = Kehadiran::where('siswa_id', $siswa->id)
                ->where('status_kehadiran', 'izin')
                ->count();
            $sakit = Kehadiran::where('siswa_id', $siswa->id)
                ->where('status_kehadiran', 'sakit')
                ->count();
            $alpa = Kehadiran::where('siswa_id', $siswa->id)
                ->where('status_kehadiran', 'tidak_hadir')
                ->count();

            $laporan[] = [
                'siswa' => $siswa,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
            ];
        }

        $pdf = Pdf::loadView('mobile.guru.absensi.laporan-cetak', [
            'kelas' => $kelas,
            'laporan' => $laporan,
            'tahunAjaran' => $tahunAjaran
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan Absensi - ' . $kelas->nama_kelas . '.pdf');
    }


    // Perilaku
    public function perilakuIndex()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        // Ambil semua perilaku dari kelas yang diajar guru
        $kelasIds = GuruMapel::where('guru_id', $guru->id)->pluck('kelas_id');

        $perilakus = Perilaku::whereIn('kelas_id', $kelasIds)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with(['siswa', 'kelas', 'pelajaran'])
            ->latest()
            ->paginate(10);

        return view('mobile.guru.perilaku.index', compact('perilakus'));
    }

    // 2. Pilih Kelas untuk Catatan Perilaku Baru
    public function perilakuPilihKelas()
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $kelasList = GuruMapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        return view('mobile.guru.perilaku.pilih-kelas', compact('kelasList'));
    }

    // 3. Form Tambah Perilaku (Daftar Siswa)
    public function perilakuCreate($kelas_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Cek apakah guru mengajar kelas ini
        $allowed = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $kelas_id)
            ->exists();

        if (!$allowed) {
            return redirect()->route('mobile.guru.perilaku.pilih-kelas')
                ->with('error', 'Anda tidak mengajar kelas ini.');
        }

        // Ambil siswa di kelas ini
        $siswas = Siswa::whereHas('kelasSiswas', function ($q) use ($kelas_id) {
            $q->where('kelas_id', $kelas_id);
        })->get();

        // Ambil pelajaran yang diajar guru di kelas ini
        $pelajaran = GuruMapel::where('guru_id', $guru->id)
            ->where('kelas_id', $kelas_id)
            ->with('pelajaran')
            ->first()?->pelajaran;

        return view('mobile.guru.perilaku.create', compact('kelas', 'siswas', 'pelajaran'));
    }

    // 4. Simpan Catatan Perilaku
    public function perilakuStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'data.*.kategori' => 'required|in:taat,disiplin,melanggar',
            'data.*.catatan' => 'required|string|max:500',
        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();
        $tahunAjaran = TahunAjaran::where('status', true)->first();

        if (!$tahunAjaran) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $today = now()->format('Y-m-d');

        foreach ($request->data as $siswa_id => $data) {
            Perilaku::create([
                'siswa_id' => $siswa_id,
                'kelas_id' => $request->kelas_id,
                'pelajaran_id' => $request->pelajaran_id,
                'tanggal' => $today,
                'kategori_perilaku' => $data['kategori'],
                'catatan' => $data['catatan'],
                'tahun_ajaran_id' => $tahunAjaran->id,
            ]);
        }

        return redirect()->route('mobile.guru.perilaku.index')
            ->with('success', 'Catatan perilaku berhasil disimpan!');
    }

    public function laporanPerilaku(Request $request)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        // Tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        // Semua kelas+mapel yang diajar guru
        $guruMapels = GuruMapel::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->with(['kelas', 'pelajaran'])
            ->get();

        // Dropdown kelas (unik)
        $kelasList = $guruMapels->pluck('kelas')->unique('id');

        // Filter input
        $filterKelas = $request->kelas_id;
        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($request->end_date)->format('Y-m-d');

        // Default tanggal: hari ini jika tidak dipilih
        if (!$startDate) $startDate = now()->startOfMonth()->format('Y-m-d');
        if (!$endDate) $endDate = now()->endOfMonth()->format('Y-m-d');

        $laporanPerilaku = [];

        foreach ($guruMapels as $mapel) {
            $kelas = $mapel->kelas;

            // Filter kelas
            if ($filterKelas && $kelas->id != $filterKelas) {
                continue;
            }

            // Filter pencarian nama kelas
            if ($filterKelas && stripos($kelas->nama_kelas, $filterKelas) === false) {
                continue;
            }

            // Total siswa di kelas ini
            $totalSiswa = Siswa::whereHas('kelasSiswas', function ($q) use ($kelas, $tahunAjaran) {
                $q->where('kelas_id', $kelas->id)
                    ->where('tahun_ajaran_id', $tahunAjaran?->id);
            })->count();

            // Hitung perilaku dalam periode
            $totalCatatan = Perilaku::where('kelas_id', $kelas->id)
                ->where('pelajaran_id', $mapel->pelajaran_id)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->count();

            $laporanPerilaku[] = [
                'kelas' => $kelas,
                'pelajaran' => $mapel->pelajaran,
                'total_siswa' => $totalSiswa,
                'total_catatan' => $totalCatatan,
            ];
        }

        return view('mobile.guru.perilaku.laporan', compact(
            'laporanPerilaku',
            'kelasList',
            'filterKelas',
            'startDate',
            'endDate',
            'tahunAjaran'
        ));
    }

    public function laporanPerilakuCetak($kelas_id)
    {
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        if (!$tahunAjaran) {
            $tahunAjaran = TahunAjaran::latest()->first();
        }

        $kelas = Kelas::findOrFail($kelas_id);

        $siswas = Siswa::whereHas('kelasSiswas', function ($q) use ($kelas_id, $tahunAjaran) {
            $q->where('kelas_id', $kelas_id)
                ->where('tahun_ajaran_id', $tahunAjaran?->id);
        })->get();

        $laporan = [];
        foreach ($siswas as $siswa) {
            $taat = Perilaku::where('siswa_id', $siswa->id)->where('kategori_perilaku', 'taat')->count();
            $disiplin = Perilaku::where('siswa_id', $siswa->id)->where('kategori_perilaku', 'disiplin')->count();
            $melanggar = Perilaku::where('siswa_id', $siswa->id)->where('kategori_perilaku', 'melanggar')->count();

            $laporan[] = [
                'siswa' => $siswa,
                'taat' => $taat,
                'disiplin' => $disiplin,
                'melanggar' => $melanggar
            ];
        }

        $pdf = Pdf::loadView('mobile.guru.perilaku.laporan-cetak', [
            'kelas' => $kelas,
            'laporan' => $laporan,
            'tahunAjaran' => $tahunAjaran
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan Perilaku - ' . $kelas->nama_kelas . '.pdf');
    }
}
