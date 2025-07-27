<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        if (Auth::user()->role == 'admin') {
            $pengaduans = Pengaduan::with('pelanggan');
        } else {
            $pengaduans = Pengaduan::with('pelanggan')->where('pelanggan_id', session('pelanggan_id'));
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $pengaduans->whereHas('pelanggan', function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $search . '%');
            })->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan status
        if ($status && in_array($status, ['pending', 'proses', 'selesai'])) {
            $pengaduans->where('status', $status);
        }

        $pengaduans = $pengaduans->latest()->paginate(10)->appends([
            'search' => $search,
            'status' => $status
        ]);

        return view('pengaduan.index', compact('pengaduans', 'search', 'status'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('pengaduan.create', compact('pelanggans'));
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

        Pengaduan::create($validatedData);

        return redirect()->route('pengaduan.index')->with('success', 'Data pengaduan berhasil ditambahkan.');
    }

    public function edit(Pengaduan $pengaduan)
    {
        $pelanggans = Pelanggan::all();
        return view('pengaduan.edit', compact('pengaduan', 'pelanggans'));
    }

    public function update(Request $request, Pengaduan $pengaduan)
    {
        $rules = [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string',
            'status' => 'required|in:pending,proses,selesai',
            'alasan_penyelesaian' => 'nullable|string|required_if:status,selesai',
        ];

        $validatedData = $request->validate($rules, [
            'alasan_penyelesaian.required_if' => 'Alasan penyelesaian wajib diisi jika status selesai.',
        ]);

        $pengaduan->update($validatedData);

        return redirect()->route('pengaduan.index')->with('success', 'Data pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
