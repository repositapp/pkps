<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    public function index()
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->back()->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $layanans = Layanan::where('barber_id', $barberId)->latest();

        $search = request('search');

        if ($search) {
            $layanans->where('nama', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        $layanans = $layanans->paginate(10)->appends(['search' => $search]);

        return view('layanan.index', compact('layanans', 'search'));
    }

    public function create()
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->route('layanan.index')->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $barberId = Auth::user()->barber->id ?? null;

        if (!$barberId) {
            return redirect()->route('layanan.index')->with(['error' => 'Anda tidak memiliki akses ke barber.']);
        }

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
        ]);

        $validatedData['barber_id'] = $barberId;
        $validatedData['is_active'] = true;

        Layanan::create($validatedData);

        return redirect()->route('layanan.index')->with(['success' => 'Data Layanan berhasil ditambahkan!']);
    }

    public function edit(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $layanan = Layanan::findOrFail($id);

        if ($layanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $layanan = Layanan::findOrFail($id);

        if ($layanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
        ]);

        $layanan->update($validatedData);

        return redirect()->route('layanan.index')->with(['success' => 'Data Layanan berhasil diubah!']);
    }

    public function destroy(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $layanan = Layanan::findOrFail($id);

        if ($layanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        $layanan->delete();

        return redirect()->route('layanan.index')->with(['success' => 'Data Layanan berhasil dihapus!']);
    }

    public function toggleStatus(string $id)
    {
        $barberId = Auth::user()->barber->id ?? null;
        $layanan = Layanan::findOrFail($id);

        if ($layanan->barber_id != $barberId) {
            abort(403, 'Unauthorized action.');
        }

        $layanan->is_active = !$layanan->is_active;
        $layanan->save();

        $statusText = $layanan->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with(['success' => "Layanan berhasil {$statusText}!"]);
    }
}
