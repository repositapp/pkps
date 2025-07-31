<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Barber;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalPemesanan = Pemesanan::where('user_id', $user->id)->count();
        $statistikPemesananAktif = Pemesanan::where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi', 'dalam_pengerjaan'])
            ->count();
        $statistikPemesananSelesai = Pemesanan::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        $barbers = Barber::where('is_active', true)
            ->where('is_verified', true)
            ->latest()
            ->take(6)
            ->get();

        $riwayatTerbaru = Pemesanan::with(['barber', 'layanan'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $pemesananAktif = Pemesanan::with(['barber', 'layanan'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->latest()
            ->first();

        $antrianAktif = null;
        if ($pemesananAktif) {
            $antrianAktif = Antrian::with('barber')
                ->where('pemesanan_id', $pemesananAktif->id)
                ->where('status', 'menunggu')
                ->first();
        }

        return view('mobile.dashboard', compact(
            'totalPemesanan',
            'statistikPemesananAktif',
            'statistikPemesananSelesai',
            'barbers',
            'riwayatTerbaru',
            'pemesananAktif',
            'antrianAktif',
        ));
    }
}
