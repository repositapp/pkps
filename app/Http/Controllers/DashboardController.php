<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin_komunitas') {
            $totalBarber = Barber::count();
            $barberAktif = Barber::where('is_active', true)->count();
            $barberTerverifikasi = Barber::where('is_verified', true)->count();
            $jumlahPemesananBulanIni = Pemesanan::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->count();

            $pemesananBulanan = Pemesanan::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $chartData = [];
            for ($i = 1; $i <= 12; $i++) {
                $chartData[] = $pemesananBulanan[$i] ?? 0;
            }

            $barbers = Barber::all();
            $barberChartData = [];

            foreach ($barbers as $barber) {
                // Hitung jumlah pemesanan per bulan untuk barber ini
                $pemesananPerBulan = Pemesanan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                    ->where('barber_id', $barber->id)
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('bulan')
                    ->pluck('total', 'bulan')
                    ->toArray();

                // Normalisasi data ke 12 bulan (Jan–Des)
                $data = [];
                for ($i = 1; $i <= 12; $i++) {
                    $data[] = $pemesananPerBulan[$i] ?? 0;
                }

                $barberChartData[] = [
                    'label' => $barber->nama, // atau $barber->user->name jika relasi
                    'data' => $data,
                    'backgroundColor' => sprintf('rgba(%d,%d,%d,0.5)', rand(0, 255), rand(0, 255), rand(0, 255)), // warna random
                    'borderColor' => 'rgba(0,0,0,0.1)',
                    'borderWidth' => 1
                ];
            }

            return view('dashboard.index', compact(
                'totalBarber',
                'barberAktif',
                'barberTerverifikasi',
                'jumlahPemesananBulanIni',
                'barberChartData'
            ));
        } elseif (Auth::user()->role == 'admin_barber') {
            $barber = auth()->user()->barber;

            $totalPemesanan = Pemesanan::where('barber_id', $barber->id)->count();
            $pemesananHariIni = Pemesanan::where('barber_id', $barber->id)
                ->where('tanggal_pemesanan', date('Y-m-d'))
                ->count();
            $pemesananPending = Pemesanan::where('barber_id', $barber->id)
                ->where('status', 'menunggu')
                ->count();

            $totalPendapatan = Transaksi::whereHas('pemesanan', function ($query) use ($barber) {
                $query->where('barber_id', $barber->id);
            })
                ->where('status_pembayaran', 'dibayar')
                ->sum('jumlah');

            // Pemesanan terbaru
            $pemesananTerbaru = Pemesanan::with(['user', 'layanan'])
                ->where('barber_id', $barber->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            return view('dashboard.index', compact(
                'totalPemesanan',
                'pemesananHariIni',
                'pemesananPending',
                'totalPendapatan',
                'pemesananTerbaru'
            ));
        }
    }
}
