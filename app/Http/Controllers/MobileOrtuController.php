<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kehadiran;
use App\Models\KelasSiswa;
use App\Models\Ortu;
use App\Models\Perilaku;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileOrtuController extends Controller
{
    // Dashboard Utama
    public function dashboard()
    {
        // Ambil data ortu yang login
        $ortu = Ortu::where('user_id', Auth::id())->firstOrFail();

        // Ambil data siswa + kelas aktif
        $siswa = Siswa::findOrFail($ortu->siswa_id);

        $kelasAktif = KelasSiswa::with('kelas')
            ->where('siswa_id', $siswa->id)
            ->whereHas('tahunAjaran', function ($q) {
                $q->where('status', true);
            })
            ->first();

        // ==== Grafik Kehadiran Minggu Ini ====
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        $labelKehadiran = [];
        $dataKehadiran  = [];

        $tanggalLoop = $startOfWeek->copy();
        while ($tanggalLoop <= $endOfWeek) {
            $labelKehadiran[] = $tanggalLoop->translatedFormat('D'); // Sen, Sel, Rab...

            $kehadiranHariIni = Kehadiran::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', $tanggalLoop)
                ->where('status_kehadiran', 'hadir')
                ->count();

            $dataKehadiran[] = $kehadiranHariIni;
            $tanggalLoop->addDay();
        }

        // ==== Catatan Perilaku Terbaru ====
        $perilakuTerbaru = Perilaku::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        return view('mobile.ortu.dashboard', [
            'siswa'            => $siswa,
            'kelasAktif'       => $kelasAktif?->kelas,
            'labelKehadiran'   => $labelKehadiran,
            'dataKehadiran'    => $dataKehadiran,
            'perilakuTerbaru'  => $perilakuTerbaru
        ]);
    }

    // Riwayat Absensi Siswa
    public function absensi(Request $request)
    {
        $ortu  = Ortu::where('user_id', Auth::id())->firstOrFail();
        $siswa = Siswa::findOrFail($ortu->siswa_id);

        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        // Ambil dari GET jika ada, kalau tidak ambil default
        $bulanFilter = $request->get('bulan', now()->format('Y-m'));
        $tahunAjaranId = $request->get('tahun_ajaran_id', $tahunAjaranAktif?->id);

        $daftarTahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();

        $riwayat = Kehadiran::with('pelajaran')
            ->where('siswa_id', $siswa->id)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->whereMonth('tanggal', substr($bulanFilter, 5, 2))
            ->whereYear('tanggal', substr($bulanFilter, 0, 4))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('mobile.ortu.absensi', [
            'siswa'             => $siswa,
            'riwayat'           => $riwayat,
            'bulanFilter'       => $bulanFilter,
            'tahunAjaranId'     => $tahunAjaranId,
            'daftarTahunAjaran' => $daftarTahunAjaran
        ]);
    }

    // Riwayat Perilaku Siswa
    public function perilaku(Request $request)
    {
        // Ambil data ortu dan siswa
        $ortu  = Ortu::where('user_id', Auth::id())->firstOrFail();
        $siswa = Siswa::findOrFail($ortu->siswa_id);

        // Tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        // Filter bulan & tahun ajaran dari request
        $bulanFilter = $request->get('bulan', now()->format('Y-m'));
        $tahunAjaranId = $request->get('tahun_ajaran_id', $tahunAjaranAktif?->id);

        // Ambil daftar tahun ajaran
        $daftarTahunAjaran = TahunAjaran::orderBy('tahun_ajaran', 'desc')->get();

        // Ambil riwayat perilaku
        $riwayat = Perilaku::where('siswa_id', $siswa->id)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->whereMonth('tanggal', substr($bulanFilter, 5, 2))
            ->whereYear('tanggal', substr($bulanFilter, 0, 4))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('mobile.ortu.perilaku', [
            'siswa'             => $siswa,
            'riwayat'           => $riwayat,
            'bulanFilter'       => $bulanFilter,
            'tahunAjaranId'     => $tahunAjaranId,
            'daftarTahunAjaran' => $daftarTahunAjaran
        ]);
    }

    // Profil Orang Tua
    public function profil()
    {
        $ortu = Ortu::with('siswa.kelas')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $user = Auth::user();
        $siswa = $ortu->siswa;

        return view('mobile.ortu.profil', compact('user', 'ortu', 'siswa'));
    }
}
