<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Pastikan admin barber hanya melihat transaksi untuk barber mereka
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $transaksis = Transaksi::with(['user', 'pemesanan.layanan', 'pemesanan.barber'])
            ->whereHas('pemesanan', function ($query) use ($barberId) {
                $query->where('barber_id', $barberId);
            })
            ->latest();

        $search = request('search');
        $statusFilter = request('status');

        if ($search) {
            $transaksis->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('referensi_pembayaran', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('pemesanan', function ($q) use ($search) {
                        $q->where('id', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($statusFilter && $statusFilter != 'semua') {
            $transaksis->where('status_pembayaran', $statusFilter);
        }

        $transaksis = $transaksis->paginate(10)->appends(['search' => $search, 'status' => $statusFilter]);

        return view('transaksi.index', compact('transaksis', 'search', 'statusFilter'));
    }

    public function show(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;

        // Eager load relasi yang dibutuhkan
        $transaksi = Transaksi::with([
            'user',
            'pemesanan.layanan',
            'pemesanan.barber',
            'pemesanan.user' // Pelanggan yang memesan
        ])->findOrFail($id);

        // Pastikan transaksi milik pemesanan yang barber-nya dimiliki admin ini
        if ($transaksi->pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        return view('transaksi.show', compact('transaksi'));
    }

    public function konfirmasi(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $transaksi = Transaksi::findOrFail($id);

        // Pastikan transaksi milik pemesanan yang barber-nya dimiliki admin ini
        if ($transaksi->pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        if ($transaksi->status_pembayaran == 'dibayar') {
            return redirect()->back()->with(['info' => 'Transaksi sudah dikonfirmasi sebelumnya.']);
        }

        // Update status transaksi
        $transaksi->update([
            'status_pembayaran' => 'dibayar',
            'tanggal_pembayaran' => now(),
            // Metode pembayaran bisa diisi dari form jika diperlukan
        ]);

        // Opsional: Update status pemesanan jika perlu
        // Misalnya, jika pemesanan masih 'menunggu' karena menunggu pembayaran
        if ($transaksi->pemesanan && $transaksi->pemesanan->status == 'menunggu') {
            $transaksi->pemesanan->update(['status' => 'dikonfirmasi']);
        }

        return redirect()->back()->with(['success' => 'Transaksi berhasil dikonfirmasi!']);
    }

    public function edit(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $transaksi = Transaksi::with(['pemesanan.barber'])->findOrFail($id);

        if ($transaksi->pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->pemesanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'metode_pembayaran' => 'required|in:tunai,transfer,dompet_elektronik',
        ]);

        $validatedData['status_pembayaran'] = 'dibayar';
        $validatedData['tanggal_pembayaran'] = now();

        $transaksi->update($validatedData);

        return redirect()->route('transaksi.index')->with(['success' => 'Data transaksi berhasil diperbarui!']);
    }

    public function indexTransaksi()
    {
        $user = Auth::user();

        $riwayatTerbaru = Pemesanan::with(['barber', 'layanan'])
            ->where('user_id', $user->id)
            ->latest()
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

        return view('mobile.transaksi', compact(
            'riwayatTerbaru',
            'pemesananAktif',
            'antrianAktif',
        ));
    }

    public function detail(string $id)
    {
        $user = Auth::user();

        // Eager load relasi yang dibutuhkan
        $transaksi = Transaksi::with([
            'user',
            'pemesanan.layanan',
            'pemesanan.barber',
            'pemesanan.user'
        ])->findOrFail($id);

        return view('mobile.transaksi-detail', compact('transaksi'));
    }
}
