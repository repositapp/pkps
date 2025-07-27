<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HalamanController extends Controller
{
    public function index()
    {
        $halamans = Halaman::with(['author']);

        $search = request('search');
        if (request('search')) {
            $halamans->when($search, function ($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('kutipan', 'like', '%' . $search . '%')

                    // Relasi ke author
                    ->orWhereHas('author', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
                ->latest();
        }

        $halamans = $halamans->paginate(10)->appends(['search' => $search]);

        return view('modul.halaman.index', compact('halamans', 'search'));
    }

    public function create()
    {
        return view('modul.halaman.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'status' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($validatedData['judul']);

        Halaman::create($validatedData);

        return redirect()->route('halaman.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $halaman = Halaman::findOrFail($id);

        return view('modul.halaman.edit', compact('halaman'));
    }

    public function update(Request $request, string $id)
    {
        $kegiatan = Halaman::findOrFail($id);

        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'status' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($validatedData['judul']);

        $kegiatan->update($validatedData);

        return redirect()->route('halaman.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $kegiatan = Halaman::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('halaman.index')->with(['success' => 'Data berhasil dihapus!']);
    }
}
