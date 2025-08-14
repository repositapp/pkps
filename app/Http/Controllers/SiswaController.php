<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index()
    {
        $search = request('search');
        $siswas = Siswa::with('ortu');

        if (request('search')) {
            $siswas->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nisn', 'like', '%' . $search . '%')
                ->orWhereHas('ortu', function ($q) use ($search) {
                    $q->where('nama_wali', 'like', '%' . $search . '%');
                });
        }

        $siswas = $siswas->latest()->paginate(10)->appends(['search' => $search]);

        return view('siswa.index', compact('siswas', 'search'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'nisn' => 'required|unique:siswas,nisn|max:20',
            'tempat_lahir' => 'required|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|max:20',
            'alamat' => 'required',
            'asal_sekolah' => 'nullable|max:100',
            'tahun_lulus' => 'nullable|digits:4',
            'nama_ayah' => 'nullable|max:100',
            'nama_ibu' => 'nullable|max:100',
            'pekerjaan_ayah' => 'nullable|max:50',
            'pekerjaan_ibu' => 'nullable|max:50',
        ]);

        Siswa::create($validatedData);

        return redirect()->route('siswa.index')->with(['success' => 'Data Siswa Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'nisn' => 'required|unique:siswas,nisn,' . $id . '|max:20',
            'tempat_lahir' => 'required|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|max:20',
            'alamat' => 'required',
            'asal_sekolah' => 'nullable|max:100',
            'tahun_lulus' => 'nullable|digits:4',
            'nama_ayah' => 'nullable|max:100',
            'nama_ibu' => 'nullable|max:100',
            'pekerjaan_ayah' => 'nullable|max:50',
            'pekerjaan_ibu' => 'nullable|max:50',
        ]);

        $siswa->update($validatedData);

        return redirect()->route('siswa.index')->with(['success' => 'Data Siswa Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with(['success' => 'Data Siswa Berhasil Dihapus!']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return back()->with('success', 'Data siswa berhasil diimport!');
    }
}
