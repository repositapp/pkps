<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kategoris = Kategori::latest();
        if (request('search')) {
            $kategoris->where('name', 'like', '%' . $search . '%');
        }

        $kategoris = $kategoris->paginate(10)->appends(['search' => $search]);

        return view('master.kategori.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('master.kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        $unique = Kategori::where('name', $request->name)->exists();

        if (!empty($unique)) {
            return redirect()->route('kategori.create')->with(['error' => 'Data Sudah Ada!']);
        } else {
            Kategori::create($validatedData);

            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('master.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:5|max:255'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        $unique = Kategori::where('name', $request->name)->exists();

        if (!empty($unique)) {
            return redirect()->route('kategori.edit', $id)->with(['error' => 'Data Sudah Ada!']);
        } else {
            $kategori = Kategori::findOrFail($id);

            $kategori->update($validatedData);

            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);
        }
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
