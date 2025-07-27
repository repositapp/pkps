<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::with(['author', 'kategori']);

        $search = request('search');
        if (request('search')) {
            $pengumumans->when($search, function ($query, $search) {
                $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('kutipan', 'like', '%' . $search . '%')

                    // Relasi ke author
                    ->orWhereHas('author', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })

                    // Relasi ke kategori
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            })
                ->latest();
        }

        $pengumumans = $pengumumans->paginate(10)->appends(['search' => $search]);

        return view('pengumuman.index', compact('pengumumans', 'search'));
    }

    public function create()
    {
        $kategoris = Kategori::all();

        return view('pengumuman.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|max:255',
            'body' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required',
        ]);

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $fileName = Str::slug($validatedData['judul']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pengumuman-images', $fileName);
            $validatedData['gambar'] = 'pengumuman-images/' . $fileName;
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($validatedData['judul']);

        Pengumuman::create($validatedData);

        return redirect()->route('pengumuman.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $kategoris = Kategori::all();

        return view('pengumuman.edit', compact('pengumuman', 'kategoris'));
    }

    public function update(Request $request, string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'judul' => 'required|max:255',
            'body' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required',
        ]);

        if ($request->file('gambar')) {
            if ($pengumuman->gambar != null) {
                Storage::delete($pengumuman->gambar);
            }
            $file = $request->file('gambar');
            $fileName = Str::slug($validatedData['judul']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pengumuman-images', $fileName);
            $validatedData['gambar'] = 'pengumuman-images/' . $fileName;
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($validatedData['judul']);

        $pengumuman->update($validatedData);

        return redirect()->route('pengumuman.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        if ($pengumuman->gambar) {
            Storage::delete($pengumuman->gambar);
        }
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with(['success' => 'Data berhasil dihapus!']);
    }

    public function show($slug)
    {
        $pengumuman = Pengumuman::with('kategori', 'author')->where('slug', $slug)->firstOrFail();
        $pengumumans = Pengumuman::latest()->take(5)
            ->where('status', 1)
            ->get();

        // Tambahkan +1 setiap kali dibuka
        if (!session()->has('viewed_pengumuman_' . $pengumuman->id)) {
            $pengumuman->increment('views');
            session(['viewed_pengumuman_' . $pengumuman->id => true]);
        }

        return view('pengumuman.show', compact('pengumuman', 'pengumumans'));
    }
}
