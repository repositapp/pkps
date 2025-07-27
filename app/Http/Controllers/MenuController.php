<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Halaman;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Menu;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with(['children', 'parent']);

        $search = $request->search;

        $menus->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                // relasi ke parent menu
                ->orWhereHas('parent', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        })->latest();

        $menus = $menus->paginate(10)->appends(['search' => $search]);

        return view('modul.menu.index', compact('menus'));
    }

    public function create()
    {
        $menus = Menu::whereNull('parent_id')->get();
        return view('modul.menu.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'target_id' => 'nullable',
            'parent_id' => 'nullable',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        Menu::create($validatedData);

        return redirect()->route('menu.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Menu $menu)
    {
        $menus = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->get();
        return view('modul.menu.edit', compact('menu', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'target_id' => 'nullable',
            'parent_id' => 'nullable',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name']);

        $menu->update($validatedData);

        return redirect()->route('menu.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with(['success' => 'Data berhasil dihapus!']);
    }

    // AJAX: Ambil data berdasarkan tipe
    public function loadTargets(Request $request)
    {
        $type = $request->query('type');
        $data = match ($type) {
            'halaman' => Halaman::select('id', 'judul as name')->get(),
            'pengumuman' => Pengumuman::select('id', 'judul as name')->get(),
            default => collect()
        };

        return response()->json($data);
    }

    public function show(Request $request, $slug)
    {
        $menu = Menu::where('slug', $slug)->firstOrFail();

        $search = $request->search;
        $kategori_id = $request->kategori;

        switch ($menu->type) {
            case 'pengumuman':
                $query = Pengumuman::with('kategori')->where('status', 1);

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('judul', 'like', "%$search%")
                            ->orWhere('kutipan', 'like', "%$search%");
                    });
                }

                if ($kategori_id) {
                    $query->where('kategori_id', $kategori_id);
                }

                $pengumumans = $query->latest()->paginate(12)->appends($request->only(['search', 'kategori']));
                $kategoris = Kategori::all();

                return view('pengumuman.list', compact('pengumumans', 'menu', 'search', 'kategoris', 'kategori_id'));

            case 'halaman':
            default:
                $halaman = Halaman::findOrFail($menu->target_id);
                return view('modul.halaman.show', compact('halaman', 'menu'));
        }
    }
}
