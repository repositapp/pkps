<?php

namespace App\Http\Controllers;

use App\Exports\PemasanganExport;
use App\Exports\PemutusanExport;
use App\Http\Controllers\Controller;
use App\Models\Pemasangan;
use App\Models\Pemutusan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function pemasanganIndex(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');

        $pemasangans = Pemasangan::with('pelanggan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                $query->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('laporan.pemasangan.index', compact('pemasangans', 'search', 'bulan', 'tahun', 'status'));
    }

    public function cetakPemasanganPdf(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');

        $pemasangans = Pemasangan::with('pelanggan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                $query->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();

        $data = [
            'pemasangans' => $pemasangans,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status,
        ];

        $pdf = Pdf::loadView('laporan.pemasangan.pdf', $data)->setPaper([0, 0, 612.0, 936.0], 'landscape');
        return $pdf->download('laporan_pemasangan_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function cetakPemasanganExcel(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');

        $pemasangans = Pemasangan::with('pelanggan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                $query->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();

        $data = [
            'pemasangans' => $pemasangans,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status,
        ];

        return Excel::download(new PemasanganExport($data), 'laporan_pemasangan_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function pemutusanIndex(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');

        $pemutusans = Pemutusan::with('pelanggan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                $query->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('laporan.pemutusan.index', compact('pemutusans', 'search', 'bulan', 'tahun', 'status'));
    }

    public function cetakPemutusanPdf(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');

        $pemutusans = Pemutusan::with('pelanggan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                $query->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();

        $data = [
            'pemutusans' => $pemutusans,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status,
        ];

        $pdf = Pdf::loadView('laporan.pemutusan.pdf', $data)->setPaper([0, 0, 612.0, 936.0], 'landscape');
        return $pdf->download('laporan_pemutusan_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function cetakPemutusanExcel(Request $request)
    {
        $search = $request->get('search');
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $status = $request->get('status');

        $pemutusans = Pemutusan::with('pelanggan')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pelanggan', function ($q) use ($search) {
                    $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                        ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%');
                });
            })
            ->when($bulan && $tahun, function ($query) use ($bulan, $tahun) {
                $query->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();

        $data = [
            'pemutusans' => $pemutusans,
            'search' => $search,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'status' => $status,
        ];

        return Excel::download(new PemutusanExport($data), 'laporan_pemutusan_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
}
