<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kelas = Kelas::query();

        if (request('search')) {
            $kelas->where('nama_kelas', 'like', '%' . $search . '%');
        }

        $kelas = $kelas->latest()->paginate(10)->appends(['search' => $search]);

        return view('master.kelas.index', compact('kelas', 'search'));
    }

    public function create()
    {
        return view('master.kelas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas|max:20',
        ]);

        Kelas::create($validatedData);

        return redirect()->route('kelas.index')->with(['success' => 'Data Kelas Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('master.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, string $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validatedData = $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $id . '|max:20',
        ]);

        $kelas->update($validatedData);

        return redirect()->route('kelas.index')->with(['success' => 'Data Kelas Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with(['success' => 'Data Kelas Berhasil Dihapus!']);
    }
}
