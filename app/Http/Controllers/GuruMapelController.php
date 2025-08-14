<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\GuruMapelImport;
use App\Models\Guru;
use App\Models\GuruMapel;
use App\Models\Kelas;
use App\Models\Pelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruMapelController extends Controller
{
    public function index()
    {
        $search = request('search');
        $guruMapels = GuruMapel::with(['guru', 'pelajaran', 'kelas', 'tahunAjaran']);

        if ($search) {
            $guruMapels->whereHas('guru', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%');
            })
                ->orWhereHas('pelajaran', function ($q) use ($search) {
                    $q->where('nama_mapel', 'like', '%' . $search . '%');
                })
                ->orWhereHas('kelas', function ($q) use ($search) {
                    $q->where('nama_kelas', 'like', '%' . $search . '%');
                });
        }

        $guruMapels = $guruMapels->latest()->paginate(10)->appends(['search' => $search]);

        return view('relasi.mapel.index', compact('guruMapels', 'search'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $pelajarans = Pelajaran::all();
        $kelass = Kelas::all();
        // $tahunAjarans = TahunAjaran::all();

        return view('relasi.mapel.create', compact('gurus', 'pelajarans', 'kelass'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            // 'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        // Cek duplikat: guru yang sama mengajar pelajaran yang sama di kelas yang sama pada tahun ajaran yang sama
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        $validatedData['tahun_ajaran_id'] = $tahunAjaran->id;
        $exists = GuruMapel::where([
            'guru_id' => $request->guru_id,
            'pelajaran_id' => $request->pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ])->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with(['error' => 'Relasi ini sudah ada!']);
        }

        GuruMapel::create($validatedData);

        return redirect()->route('mapel.index')->with(['success' => 'Relasi Guru-Pelajaran-Kelas berhasil ditambahkan!']);
    }

    public function edit(string $id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $gurus = Guru::all();
        $pelajarans = Pelajaran::all();
        $kelass = Kelas::all();
        // $tahunAjarans = TahunAjaran::all();

        return view('relasi.mapel.edit', compact('guruMapel', 'gurus', 'pelajarans', 'kelass'));
    }

    public function update(Request $request, string $id)
    {
        $guruMapel = GuruMapel::findOrFail($id);

        $validatedData = $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'pelajaran_id' => 'required|exists:pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            // 'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ]);

        // Cek duplikat (kecuali untuk data yang sedang diupdate)
        $tahunAjaran = TahunAjaran::where('status', true)->first();
        $validatedData['tahun_ajaran_id'] = $tahunAjaran->id;
        $exists = GuruMapel::where([
            'guru_id' => $request->guru_id,
            'pelajaran_id' => $request->pelajaran_id,
            'kelas_id' => $request->kelas_id,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ])->where('id', '!=', $id)->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with(['error' => 'Relasi ini sudah ada!']);
        }

        $guruMapel->update($validatedData);

        return redirect()->route('mapel.index')->with(['success' => 'Relasi berhasil diperbarui!']);
    }

    public function destroy(string $id)
    {
        $guruMapel = GuruMapel::findOrFail($id);
        $guruMapel->delete();

        return redirect()->route('mapel.index')->with(['success' => 'Relasi berhasil dihapus!']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $import = new GuruMapelImport();
        Excel::import($import, $request->file('file'));

        return back()->with('success', 'Data relasi guru - mata pelajaran - kelas berhasil diimport!');
    }
}
