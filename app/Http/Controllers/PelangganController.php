<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pemasangan;
use App\Models\Pemutusan;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $pelanggans = Pelanggan::query();

        if ($search) {
            $pelanggans->where(function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_sambungan', 'like', '%' . $search . '%')
                    ->orWhere('nomor_telepon', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        $pelanggans = $pelanggans->latest()->paginate(10)->appends(['search' => $search]);

        return view('master.pelanggan.index', compact('pelanggans', 'search'));
    }

    public function create()
    {
        return view('master.pelanggan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'nomor_telepon' => 'required|string|max:20|unique:pelanggans,nomor_telepon',
            'nomor_sambungan' => 'nullable|string|max:50|unique:pelanggans,nomor_sambungan', // Bisa null saat create
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB Max
            'email' => 'required|email|unique:users,email',
        ], [
            // Pesan error kustom jika diperlukan
            'nomor_telepon.unique' => 'Nomor telepon ini sudah digunakan oleh pelanggan lain.',
            'nomor_sambungan.unique' => 'Nomor sambungan ini sudah digunakan oleh pelanggan lain.',
            'file_ktp.mimes' => 'File KTP harus berupa gambar (jpg, jpeg, png) atau PDF.',
            'file_ktp.max' => 'Ukuran file KTP maksimal 2MB.',
        ]);

        $user = User::create([
            'name' => $request->nama_pelanggan,
            'username' => strtolower(str_replace(' ', '_', $request->nama_pelanggan)) . random_int(10, 99),
            'email' => $request->email,
            'password' => Hash::make('12345678'), // default password
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'pelanggan',
            'status' => true,
        ]);

        if ($request->file('file_ktp')) {
            $file = $request->file('file_ktp');
            $fileName = time() . '-' . Str::slug($validatedData['nama_pelanggan']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen-file', $fileName);
            $validatedData['file_ktp'] = 'dokumen-file/' . $fileName;
        }

        $validatedData['user_id'] = $user->id;

        Pelanggan::create($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('master.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $rules = [
            'nama_pelanggan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'nomor_telepon' => 'required|string|max:20|unique:pelanggans,nomor_telepon,' . $pelanggan->id,
            'nomor_sambungan' => 'nullable|string|max:50|unique:pelanggans,nomor_sambungan,' . $pelanggan->id,
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'email' => 'required|email|unique:users,email,' . $pelanggan->user_id,
        ];

        $validatedData = $request->validate($rules, [
            'nomor_telepon.unique' => 'Nomor telepon ini sudah digunakan oleh pelanggan lain.',
            'nomor_sambungan.unique' => 'Nomor sambungan ini sudah digunakan oleh pelanggan lain.',
            'file_ktp.mimes' => 'File KTP harus berupa gambar (jpg, jpeg, png) atau PDF.',
            'file_ktp.max' => 'Ukuran file KTP maksimal 2MB.',
        ]);

        if ($request->file('file_ktp')) {
            if ($pelanggan->file_ktp != null) {
                Storage::delete($pelanggan->file_ktp);
            }
            $file = $request->file('file_ktp');
            $fileName = time() . '-' . Str::slug($validatedData['nama_pelanggan']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('dokumen-file', $fileName);
            $validatedData['file_ktp'] = 'dokumen-file/' . $fileName;
        }

        $user = User::findOrFail($pelanggan->user_id);
        $user->update([
            'name' => $request->nama_pelanggan,
            'username' => strtolower(str_replace(' ', '_', $request->nama_pelanggan)) . random_int(10, 99),
            'email' => $request->email,
        ]);

        $pelanggan->update($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pemasangan = Pemasangan::where('pelanggan_id', $pelanggan->id)->first();
        if ($pemasangan) {
            $pemasangan->delete();
        }

        $pengaduan = Pengaduan::where('pelanggan_id', $pelanggan->id)->first();
        if ($pengaduan) {
            $pengaduan->delete();
        }

        $pemutusan = Pemutusan::where('pelanggan_id', $pelanggan->id)->first();
        if ($pemutusan) {
            $pemutusan->delete();
        }

        $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)->first();
        if ($tagihan) {
            $tagihan->delete();
        }

        $akun = User::findOrFail($pelanggan->user_id);
        $akun->delete();

        if ($pelanggan->file_ktp) {
            Storage::delete($pelanggan->file_ktp);
        }
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
