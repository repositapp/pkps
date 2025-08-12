<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $search = request('search');
        $tahunAjarans = TahunAjaran::query();

        if (request('search')) {
            $tahunAjarans->where('tahun_ajaran', 'like', '%' . $search . '%')
                ->orWhere('semester', 'like', '%' . $search . '%');
        }

        $tahunAjarans = $tahunAjarans->latest()->paginate(10)->appends(['search' => $search]);

        return view('master.tahunajaran.index', compact('tahunAjarans', 'search'));
    }

    public function create()
    {
        return view('master.tahunajaran.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tahun_ajaran' => 'required|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'nullable|boolean',
        ]);

        // Jika status diatur aktif, pastikan yang lain non-aktif
        if ($request->status) {
            TahunAjaran::where('status', true)->update(['status' => false]);
        }

        TahunAjaran::create($validatedData);

        return redirect()->route('tahunajaran.index')->with(['success' => 'Tahun Ajaran berhasil ditambahkan!']);
    }

    public function edit(string $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('master.tahunajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, string $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $validatedData = $request->validate([
            'tahun_ajaran' => 'required|max:20',
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'nullable|boolean',
        ]);

        // Jika status diatur aktif, non-aktifkan semua yang lain
        if ($request->status) {
            TahunAjaran::where('status', true)->where('id', '!=', $id)->update(['status' => false]);
        }

        $tahunAjaran->update($validatedData);

        return redirect()->route('tahunajaran.index')->with(['success' => 'Tahun Ajaran berhasil diperbarui!']);
    }

    public function destroy(string $id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        // Cegah penghapusan jika sedang aktif
        if ($tahunAjaran->status) {
            return redirect()->route('tahunajaran.index')->with(['error' => 'Tahun ajaran yang aktif tidak bisa dihapus!']);
        }

        $tahunAjaran->delete();

        return redirect()->route('tahunajaran.index')->with(['success' => 'Tahun Ajaran berhasil dihapus!']);
    }
}
