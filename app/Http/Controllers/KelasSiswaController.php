<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasSiswaController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kelasSiswas = KelasSiswa::with(['siswa', 'kelas', 'tahunAjaran']);

        if ($search) {
            $kelasSiswas->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%');
            })
                ->orWhereHas('kelas', function ($q) use ($search) {
                    $q->where('nama_kelas', 'like', '%' . $search . '%');
                })
                ->orWhereHas('tahunAjaran', function ($q) use ($search) {
                    $q->where('tahun_ajaran', 'like', '%' . $search . '%');
                });
        }

        $kelasSiswas = $kelasSiswas->latest()->paginate(10)->appends(['search' => $search]);

        return view('relasi.kelas_siswa.index', compact('kelasSiswas', 'search'));
    }

    public function create()
    {
        $siswas = Siswa::all();
        $kelass = Kelas::all();
        // $tahunAjarans = TahunAjaran::all();

        return view('relasi.kelas_siswa.create', compact('siswas', 'kelass'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            // 'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        // Cek duplikat: siswa yang sama di kelas yang sama pada tahun ajaran yang sama
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        $validatedData['tahun_ajaran_id'] = $tahunAjaran->id;
        $exists = KelasSiswa::where([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ])->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with(['error' => 'Siswa ini sudah terdaftar di kelas ini pada tahun ajaran ini!']);
        }

        KelasSiswa::create($validatedData);

        return redirect()->route('siswakelas.index')->with(['success' => 'Relasi Siswa-Kelas berhasil ditambahkan!']);
    }

    public function edit(string $id)
    {
        $kelasSiswa = KelasSiswa::findOrFail($id);
        $siswas = Siswa::all();
        $kelass = Kelas::all();
        // $tahunAjarans = TahunAjaran::all();

        return view('relasi.kelas_siswa.edit', compact('kelasSiswa', 'siswas', 'kelass'));
    }

    public function update(Request $request, string $id)
    {
        $kelasSiswa = KelasSiswa::findOrFail($id);

        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            // 'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        // Cek duplikat (kecuali untuk data yang sedang diupdate)
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        $validatedData['tahun_ajaran_id'] = $tahunAjaran->id;
        $exists = KelasSiswa::where([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ])->where('id', '!=', $id)->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with(['error' => 'Relasi ini sudah ada!']);
        }

        $kelasSiswa->update($validatedData);

        return redirect()->route('siswakelas.index')->with(['success' => 'Relasi berhasil diperbarui!']);
    }

    public function destroy(string $id)
    {
        $kelasSiswa = KelasSiswa::findOrFail($id);
        $kelasSiswa->delete();

        return redirect()->route('siswakelas.index')->with(['success' => 'Relasi berhasil dihapus!']);
    }
}
