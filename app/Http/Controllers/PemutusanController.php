<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pemutusan;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemutusanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $pemutusans = Pemutusan::with('pelanggan');

        // Filter berdasarkan pencarian
        if ($search) {
            $pemutusans->whereHas('pelanggan', function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $search . '%');
            })->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan status
        if ($status && in_array($status, ['pending', 'proses', 'disetujui', 'ditolak'])) {
            $pemutusans->where('status', $status);
        }

        $pemutusans = $pemutusans->latest()->paginate(10)->appends([
            'search' => $search,
            'status' => $status
        ]);

        return view('pemutusan.index', compact('pemutusans', 'search', 'status'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::with('pemasangan')
            ->whereHas('pemasangan', function ($query) {
                $query->where('status', 'disetujui');
            })
            ->get();

        return view('pemutusan.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string', // Bisa null saat create
        ]);

        // Tambahkan data default
        $validatedData['status'] = 'pending';

        // Hitung jumlah tunggakan otomatis dari tagihan yang belum dibayar
        $jumlahTunggakan = Tagihan::where('pelanggan_id', $validatedData['pelanggan_id'])
            ->where('status_pembayaran', false)
            ->sum('total_tagihan');
        $validatedData['jumlah_tunggakan'] = $jumlahTunggakan;

        Pemutusan::create($validatedData);

        if (Auth::user()->role == 'admin') {
            return redirect()->route('pemutusan.index')->with('success', 'Data permohonan pemutusan berhasil ditambahkan.');
        } else {
            return redirect()->route('pemutusan.show', session('pelanggan_id'))->with('success', 'Data permohonan pemutusan berhasil ditambahkan.');
        }
    }

    public function show(Request $request)
    {
        $pemutusan = Pemutusan::where('pelanggan_id', session('pelanggan_id'))->first();

        return view('pemutusan.show', compact('pemutusan'));
    }

    public function edit(Pemutusan $pemutusan)
    {
        $pelanggans = Pelanggan::with('pemasangan')
            ->whereHas('pemasangan', function ($query) {
                $query->where('status', 'disetujui');
            })
            ->get();

        return view('pemutusan.edit', compact('pemutusan', 'pelanggans'));
    }

    public function update(Request $request, Pemutusan $pemutusan)
    {
        $rules = [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string',
            'status' => 'required|in:pending,proses,disetujui,ditolak',
            'alasan_ditolak' => 'nullable|string|required_if:status,ditolak',
        ];

        $validatedData = $request->validate($rules, [
            'alasan_ditolak.required_if' => 'Alasan penolakan wajib diisi jika status ditolak.',
        ]);

        // Jika status berubah, update jumlah tunggakan
        if ($validatedData['status'] !== $pemutusan->status) {
            // Hitung ulang jumlah tunggakan
            $jumlahTunggakan = Tagihan::where('pelanggan_id', $validatedData['pelanggan_id'])
                ->where('status_pembayaran', false)
                ->sum('total_tagihan');
            $validatedData['jumlah_tunggakan'] = $jumlahTunggakan;
        }

        $pemutusan->update($validatedData);

        return redirect()->route('pemutusan.index')->with('success', 'Data permohonan pemutusan berhasil diperbarui.');
    }

    public function destroy(Pemutusan $pemutusan)
    {
        $pemutusan->delete();
        return redirect()->route('pemutusan.index')->with('success', 'Data permohonan pemutusan berhasil dihapus.');
    }
}
