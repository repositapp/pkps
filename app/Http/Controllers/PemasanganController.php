<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pemasangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PemasanganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $pemasangans = Pemasangan::with('pelanggan');

        // Filter berdasarkan pencarian
        if ($search) {
            $pemasangans->whereHas('pelanggan', function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $search . '%');
            })->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan status
        if ($status && in_array($status, ['pending', 'proses', 'disetujui', 'ditolak'])) {
            $pemasangans->where('status', $status);
        }

        $pemasangans = $pemasangans->latest()->paginate(10)->appends([
            'search' => $search,
            'status' => $status
        ]);

        return view('pemasangan.index', compact('pemasangans', 'search', 'status'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all(); // Ambil semua pelanggan untuk dropdown
        return view('pemasangan.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string', // Bisa null saat create
            'tanggal_permohonan' => 'required|date',
        ]);

        // Tambahkan data default
        $validatedData['status'] = 'pending';
        $validatedData['status_pembayaran'] = false;

        Pemasangan::create($validatedData);

        if (Auth::user()->role == 'admin') {
            return redirect()->route('pemasangan.index')->with('success', 'Data permohonan pemasangan berhasil ditambahkan.');
        } else {
            return redirect()->route('pemasangan.show', session('pelanggan_id'))->with('success', 'Data permohonan pemasangan berhasil ditambahkan.');
        }
    }

    public function show(Request $request)
    {
        $pemasangan = Pemasangan::where('pelanggan_id', session('pelanggan_id'))->first();

        return view('pemasangan.show', compact('pemasangan'));
    }

    public function edit(Pemasangan $pemasangan)
    {
        // Jika status sudah disetujui, tidak boleh diedit
        if ($pemasangan->status === 'disetujui') {
            return redirect()->route('pemasangan.index')->with('error', 'Data yang sudah disetujui tidak dapat diubah.');
        }

        $pelanggans = Pelanggan::all();
        // Generate nomor urut otomatis jika status akan diubah ke 'disetujui'
        $nomorUrut = null;
        if (old('status', $pemasangan->status) != 'disetujui' || old('status') != 'disetujui') {
            // Hitung jumlah pemasangan yang sudah disetujui + 1
            $nomorUrut = str_pad(Pemasangan::where('status', 'disetujui')->count() + 1, 5, '0', STR_PAD_LEFT);
        }

        return view('pemasangan.edit', compact('pemasangan', 'pelanggans', 'nomorUrut'));
    }

    public function getNomorUrut(Request $request)
    {
        // Hitung jumlah pemasangan yang sudah disetujui + 1
        $jumlahDisetujui = Pemasangan::where('status', 'disetujui')->count() + 1;
        $nomorUrut = str_pad($jumlahDisetujui, 5, '0', STR_PAD_LEFT);

        return response()->json(['nomor_urut' => $nomorUrut]);
        // try {
        // } catch (\Exception $e) {
        //     // Log the error for debugging
        //     Log::error('Error generating auto-number: ' . $e->getMessage());

        //     return response()->json(['error' => 'Gagal mengambil nomor urut otomatis'], 500);
        // }
    }

    public function update(Request $request, Pemasangan $pemasangan)
    {
        // dd($request->all());

        // Jika status sudah disetujui, tidak boleh diedit
        if ($pemasangan->status === 'disetujui') {
            return redirect()->route('pemasangan.index')->with('error', 'Data yang sudah disetujui tidak dapat diubah.');
        }

        $rules = [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'deskripsi' => 'required|string',
            'lokasi' => 'nullable|string',
            'tanggal_permohonan' => 'required|date',
            'tanggal_penelitian' => 'nullable|date',
            'tanggal_bayar' => 'nullable|date',
            'spk_tanggal' => 'nullable|date',
            'spk_nomor' => 'nullable|string|max:100',
            'ba_tanggal' => 'nullable|date',
            'ba_nomor' => 'nullable|string|max:100',
            'merek_meteran' => 'nullable|string|max:100',
            'kedudukan' => 'nullable|boolean',
            'status_pembayaran' => 'nullable|boolean',
            'status' => 'required|in:pending,proses,disetujui,ditolak',
            'alasan_ditolak' => 'nullable|string|required_if:status,ditolak',
        ];

        $validatedData = $request->validate($rules, [
            'alasan_ditolak.required_if' => 'Alasan penolakan wajib diisi jika status ditolak.',
        ]);

        // Jika status berubah menjadi 'disetujui', buat nomor sambungan
        if ($validatedData['status'] === 'disetujui' && $pemasangan->status !== 'disetujui') {
            // Validasi input nomor sambungan jika status disetujui
            $request->validate([
                'kode_wilayah' => 'required|string|size:2',
                'kode_bagian' => 'required|string|size:2',
                'nomor_urut' => 'required|string|size:5',
            ], [
                'kode_wilayah.required' => 'Kode wilayah wajib diisi.',
                'kode_wilayah.size' => 'Kode wilayah harus 2 digit.',
                'kode_bagian.required' => 'Kode bagian wajib diisi.',
                'kode_bagian.size' => 'Kode bagian harus 2 digit.',
                'nomor_urut.required' => 'Nomor urut wajib diisi.',
                'nomor_urut.size' => 'Nomor urut harus 5 digit.',
            ]);

            $kodeSambungan =  $request->input('kode_wilayah') . '.' .
                $request->input('kode_bagian') . '.' .
                $request->input('nomor_urut');

            // Mulai transaksi database
            DB::beginTransaction();
            try {
                // Update data pemasangan
                $pemasangan->update($validatedData);

                // Update nomor sambungan di tabel pelanggan
                $pelanggan = $pemasangan->pelanggan;
                $pelanggan->nomor_sambungan = $kodeSambungan;
                $pelanggan->save();

                DB::commit();
                return redirect()->route('pemasangan.index')->with('success', 'Data permohonan pemasangan berhasil diperbarui dan nomor sambungan telah dibuat.');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')->withInput();
            }
        } else {
            // Jika status tidak disetujui atau tidak berubah, update biasa
            $pemasangan->update($validatedData);
            return redirect()->route('pemasangan.index')->with('success', 'Data permohonan pemasangan berhasil diperbarui.');
        }
    }

    public function destroy(Pemasangan $pemasangan)
    {
        // Jika status sudah disetujui, tidak boleh dihapus
        if ($pemasangan->status === 'disetujui') {
            return redirect()->route('pemasangan.index')->with('error', 'Data yang sudah disetujui tidak dapat dihapus.');
        }

        $pemasangan->delete();
        return redirect()->route('pemasangan.index')->with('success', 'Data permohonan pemasangan berhasil dihapus.');
    }
}
