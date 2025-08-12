<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelajaran;
use Illuminate\Http\Request;

class PelajaranController extends Controller
{
    public function index()
    {
        $search = request('search');
        $pelajarans = Pelajaran::query();

        if (request('search')) {
            $pelajarans->where('nama_mapel', 'like', '%' . $search . '%');
        }

        $pelajarans = $pelajarans->latest()->paginate(10)->appends(['search' => $search]);

        return view('master.pelajaran.index', compact('pelajarans', 'search'));
    }

    public function create()
    {
        return view('master.pelajaran.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_mapel' => 'required|unique:pelajarans,nama_mapel|max:50',
        ]);

        Pelajaran::create($validatedData);

        return redirect()->route('pelajaran.index')->with(['success' => 'Data Pelajaran Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $pelajaran = Pelajaran::findOrFail($id);
        return view('master.pelajaran.edit', compact('pelajaran'));
    }

    public function update(Request $request, string $id)
    {
        $pelajaran = Pelajaran::findOrFail($id);

        $validatedData = $request->validate([
            'nama_mapel' => 'required|unique:pelajarans,nama_mapel,' . $id . '|max:50',
        ]);

        $pelajaran->update($validatedData);

        return redirect()->route('pelajaran.index')->with(['success' => 'Data Pelajaran Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $pelajaran = Pelajaran::findOrFail($id);
        $pelajaran->delete();

        return redirect()->route('pelajaran.index')->with(['success' => 'Data Pelajaran Berhasil Dihapus!']);
    }
}
