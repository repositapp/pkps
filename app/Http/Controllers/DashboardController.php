<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();
        $tahunAjaran = $tahunAjaranAktif ?? TahunAjaran::latest()->first();

        // Statistik Umum
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalGuru = Guru::count();

        // Siswa per Jenis Kelamin
        $siswaLk = Siswa::where('jenis_kelamin', 'L')->count();
        $siswaPr = Siswa::where('jenis_kelamin', 'P')->count();

        // Kehadiran Hari Ini (jika ada data hari ini)
        $today = now()->format('Y-m-d');
        $kehadiranHariIni = Kehadiran::where('tanggal', $today)
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->select('status_kehadiran', DB::raw('count(*) as total'))
            ->groupBy('status_kehadiran')
            ->pluck('total', 'status_kehadiran');

        $hadir = $kehadiranHariIni['hadir'] ?? 0;
        $izin = $kehadiranHariIni['izin'] ?? 0;
        $sakit = $kehadiranHariIni['sakit'] ?? 0;
        $tidakHadir = $kehadiranHariIni['tidak_hadir'] ?? 0;

        $totalHadirHariIni = $hadir + $izin + $sakit + $tidakHadir;
        $persentaseHadir = $totalHadirHariIni > 0 ? round(($hadir / $totalHadirHariIni) * 100, 1) : 0;

        // Siswa tanpa absensi hari ini
        $siswaTanpaAbsensi = 0;
        if ($totalHadirHariIni > 0) {
            $siswaYangAbsen = Kehadiran::where('tanggal', $today)
                ->where('tahun_ajaran_id', $tahunAjaran?->id)
                ->distinct('siswa_id')
                ->count('siswa_id');
            $siswaTanpaAbsensi = max(0, $totalSiswa - $siswaYangAbsen);
        }

        // Data untuk grafik (Kehadiran 7 hari terakhir)
        $dataChart = Kehadiran::select(
            DB::raw('tanggal'),
            DB::raw('SUM(CASE WHEN status_kehadiran = "hadir" THEN 1 ELSE 0 END) as hadir'),
            DB::raw('SUM(CASE WHEN status_kehadiran = "izin" THEN 1 ELSE 0 END) as izin'),
            DB::raw('SUM(CASE WHEN status_kehadiran = "sakit" THEN 1 ELSE 0 END) as sakit'),
            DB::raw('SUM(CASE WHEN status_kehadiran = "tidak_hadir" THEN 1 ELSE 0 END) as alpa')
        )
            ->where('tanggal', '>=', now()->subDays(6))
            ->where('tahun_ajaran_id', $tahunAjaran?->id)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labels = $dataChart->pluck('tanggal')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'))->toArray();
        $chartHadir = $dataChart->pluck('hadir')->toArray();
        $chartIzin = $dataChart->pluck('izin')->toArray();
        $chartSakit = $dataChart->pluck('sakit')->toArray();
        $chartAlpa = $dataChart->pluck('alpa')->toArray();

        return view('dashboard.index', compact(
            'totalSiswa',
            'totalKelas',
            'totalGuru',
            'siswaLk',
            'siswaPr',
            'hadir',
            'izin',
            'sakit',
            'tidakHadir',
            'persentaseHadir',
            'siswaTanpaAbsensi',
            'labels',
            'chartHadir',
            'chartIzin',
            'chartSakit',
            'chartAlpa',
            'tahunAjaran'
        ));
    }
}
