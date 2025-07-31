<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananController extends Controller
{
    public function index()
    {
        // Pastikan admin barber hanya melihat pemesanan untuk barber mereka
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            // Jika pengguna admin_barber tidak memiliki barber terkait
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $pemesanans = Pemesanan::with(['user', 'layanan'])
            ->where('barber_id', $barberId)
            ->latest();

        $search = request('search');
        $statusFilter = request('status');

        if ($search) {
            $pemesanans->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('layanan', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($statusFilter && $statusFilter != 'semua') {
            $pemesanans->where('status', $statusFilter);
        } else {
            // Default filter untuk tidak menampilkan yang dibatalkan
            $pemesanans->where('status', '!=', 'dibatalkan');
        }

        $pemesanans = $pemesanans->paginate(10)->appends(['search' => $search, 'status' => $statusFilter]);

        return view('pemesanan.index', compact('pemesanans', 'search', 'statusFilter'));
    }

    public function show(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $pemesanan = Pemesanan::with(['user', 'layanan', 'barber', 'transaksi'])->findOrFail($id);

        // Pastikan pemesanan milik barber yang bersangkutan
        if ($pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        return view('pemesanan.show', compact('pemesanan'));
    }

    public function konfirmasi(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        if ($pemesanan->status != 'menunggu') {
            return redirect()->back()->with(['error' => 'Pemesanan tidak dalam status menunggu.']);
        }

        $pemesanan->update(['status' => 'dikonfirmasi']);

        // Buat transaksi jika belum ada
        if (!$pemesanan->transaksi) {
            Transaksi::create([
                'pemesanan_id' => $pemesanan->id,
                'user_id' => $pemesanan->user_id,
                'jumlah' => $pemesanan->layanan->harga ?? 0,
                'status_pembayaran' => 'menunggu', // Bisa disesuaikan
            ]);
        }

        return redirect()->back()->with(['success' => 'Pemesanan berhasil dikonfirmasi!']);
    }

    public function batalkan(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi jika sudah selesai, tidak bisa dibatalkan
        if ($pemesanan->status == 'selesai') {
            return redirect()->back()->with(['error' => 'Pemesanan sudah selesai, tidak bisa dibatalkan.']);
        }

        $pemesanan->update(['status' => 'dibatalkan']);

        // Update status transaksi jika ada
        if ($pemesanan->transaksi) {
            $pemesanan->transaksi->update(['status_pembayaran' => 'gagal']);
        }

        return redirect()->back()->with(['success' => 'Pemesanan berhasil dibatalkan!']);
    }

    public function proses(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        if ($pemesanan->status != 'dikonfirmasi') {
            return redirect()->back()->with(['error' => 'Pemesanan harus dikonfirmasi terlebih dahulu.']);
        }

        $pemesanan->update(['status' => 'dalam_pengerjaan']);

        return redirect()->back()->with(['success' => 'Pemesanan mulai diproses!']);
    }

    public function selesai(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        if ($pemesanan->status != 'dalam_pengerjaan') {
            return redirect()->back()->with(['error' => 'Pemesanan harus dalam pengerjaan terlebih dahulu.']);
        }

        $pemesanan->update(['status' => 'selesai']);

        // Update status transaksi jika ada
        // if ($pemesanan->transaksi) {
        //     $pemesanan->transaksi->update(['status_pembayaran' => 'dibayar', 'tanggal_pembayaran' => now()]);
        // }

        return redirect()->back()->with(['success' => 'Pemesanan selesai!']);
    }
}
