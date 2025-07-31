<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $search = request('search');
        $dariTanggal = request('dari_tanggal');
        $sampaiTanggal = request('sampai_tanggal');
        $jenisLaporan = request('jenis_laporan', 'pemesanan'); // Default 'pemesanan'

        // Inisialisasi query
        $queryPemesanan = null;
        $queryKeuangan = null;
        $totalPendapatan = 0;
        $jumlahPemesanan = 0;

        if ($dariTanggal && $sampaiTanggal) {
            if ($jenisLaporan == 'pemesanan') {
                $queryPemesanan = Pemesanan::with(['user', 'layanan'])
                    ->where('barber_id', $barberId)
                    ->where('status', 'selesai')
                    ->whereDate('created_at', '>=', $dariTanggal)
                    ->whereDate('created_at', '<=', $sampaiTanggal)
                    ->latest();

                if ($search) {
                    $queryPemesanan->where(function ($q) use ($search) {
                        $q->where('id', 'like', '%' . $search . '%')
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('nama', 'like', '%' . $search . '%');
                            })
                            ->orWhereHas('layanan', function ($layananQuery) use ($search) {
                                $layananQuery->where('nama', 'like', '%' . $search . '%');
                            });
                    });
                }

                $queryPemesanan = $queryPemesanan->paginate(10)->appends([
                    'search' => $search,
                    'dari_tanggal' => $dariTanggal,
                    'sampai_tanggal' => $sampaiTanggal,
                    'jenis_laporan' => $jenisLaporan
                ]);
            } elseif ($jenisLaporan == 'keuangan') {
                // Query untuk laporan keuangan (agregasi)
                $queryKeuangan = Transaksi::with(['pemesanan.layanan', 'user'])
                    ->whereHas('pemesanan', function ($q) use ($barberId) {
                        $q->where('barber_id', $barberId)
                            ->where('status', 'selesai');
                    })
                    ->where('status_pembayaran', 'dibayar')
                    ->whereDate('created_at', '>=', $dariTanggal)
                    ->whereDate('created_at', '<=', $sampaiTanggal)
                    ->latest();

                if ($search) {
                    $queryKeuangan->where(function ($q) use ($search) {
                        $q->where('id', 'like', '%' . $search . '%')
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('nama', 'like', '%' . $search . '%');
                            })
                            ->orWhereHas('pemesanan', function ($pemesananQuery) use ($search) {
                                $pemesananQuery->where('id', 'like', '%' . $search . '%');
                            });
                    });
                }

                $queryKeuangan = $queryKeuangan->paginate(10)->appends([
                    'search' => $search,
                    'dari_tanggal' => $dariTanggal,
                    'sampai_tanggal' => $sampaiTanggal,
                    'jenis_laporan' => $jenisLaporan
                ]);

                // Hitung total pendapatan dan jumlah pemesanan untuk ditampilkan di summary
                $totalPendapatan = Transaksi::join('pemesanans', 'transaksis.pemesanan_id', '=', 'pemesanans.id')
                    ->where('pemesanans.barber_id', $barberId)
                    ->where('pemesanans.status', 'selesai')
                    ->where('transaksis.status_pembayaran', 'dibayar')
                    ->whereDate('transaksis.created_at', '>=', $dariTanggal)
                    ->whereDate('transaksis.created_at', '<=', $sampaiTanggal)
                    ->sum('transaksis.jumlah');

                $jumlahPemesanan = Pemesanan::where('barber_id', $barberId)
                    ->where('status', 'selesai')
                    ->whereDate('created_at', '>=', $dariTanggal)
                    ->whereDate('created_at', '<=', $sampaiTanggal)
                    ->count();
            }
        }

        return view('laporan.index', compact(
            'search',
            'dariTanggal',
            'sampaiTanggal',
            'jenisLaporan',
            'queryPemesanan',
            'queryKeuangan',
            'totalPendapatan',
            'jumlahPemesanan'
        ));
    }

    public function cetak(Request $request)
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $dariTanggal = $request->get('dari_tanggal_cetak');
        $sampaiTanggal = $request->get('sampai_tanggal_cetak');
        $jenisLaporan = $request->get('jenis_laporan_cetak', 'pemesanan');

        if (!$dariTanggal || !$sampaiTanggal) {
            return redirect()->back()->with(['error' => 'Tanggal harus diisi untuk mencetak laporan.']);
        }

        $data = [];
        $judulLaporan = '';

        if ($jenisLaporan == 'pemesanan') {
            $judulLaporan = 'Laporan Data Pemesanan Selesai';
            $data = Pemesanan::with(['user', 'layanan'])
                ->where('barber_id', $barberId)
                ->where('status', 'selesai')
                ->whereDate('created_at', '>=', $dariTanggal)
                ->whereDate('created_at', '<=', $sampaiTanggal)
                ->orderBy('created_at', 'ASC')
                ->get();
        } elseif ($jenisLaporan == 'keuangan') {
            $judulLaporan = 'Laporan Keuangan (Pendapatan)';
            $data = Transaksi::with(['pemesanan.layanan', 'user', 'pemesanan.user'])
                ->whereHas('pemesanan', function ($q) use ($barberId) {
                    $q->where('barber_id', $barberId)
                        ->where('status', 'selesai');
                })
                ->where('status_pembayaran', 'dibayar')
                ->whereDate('created_at', '>=', $dariTanggal)
                ->whereDate('created_at', '<=', $sampaiTanggal)
                ->orderBy('created_at', 'ASC')
                ->get();
        }

        $barber = Auth::user()->barber;

        $pdf = Pdf::loadView('laporan.cetak', compact(
            'data',
            'dariTanggal',
            'sampaiTanggal',
            'judulLaporan',
            'barber',
            'jenisLaporan'
        ))->setPaper('a4', 'landscape'); // Landscape untuk tabel yang lebar

        return $pdf->stream('Laporan_' . $jenisLaporan . '_' . $dariTanggal . '_sd_' . $sampaiTanggal . '.pdf');
        // Gunakan ->download() jika ingin langsung download
        // return $pdf->download('Laporan_' . $jenisLaporan . '_' . $dariTanggal . '_sd_' . $sampaiTanggal . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $dariTanggal = $request->get('dari_tanggal_cetak');
        $sampaiTanggal = $request->get('sampai_tanggal_cetak');
        $jenisLaporan = $request->get('jenis_laporan_cetak', 'pemesanan');

        if (!$dariTanggal || !$sampaiTanggal) {
            return redirect()->back()->with(['error' => 'Tanggal harus diisi untuk export laporan.']);
        }

        $fileName = 'Laporan_' . $jenisLaporan . '_' . $dariTanggal . '_sd_' . $sampaiTanggal . '.xlsx';

        return Excel::download(new LaporanExport($dariTanggal, $sampaiTanggal, $jenisLaporan, $barberId), $fileName);
    }
}
