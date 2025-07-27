<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AplikasiController extends Controller
{
    public function index()
    {
        $aplikasi = Aplikasi::firstOrCreate([]);

        return view('pengaturan.aplikasi.index', compact('aplikasi'));
    }

    public function update(Request $request, string $id)
    {;
        $aplikasi = Aplikasi::findOrFail($id);

        $validatedData = $request->validate([
            'nama_lembaga' => 'required',
            'telepon' => 'nullable',
            'fax' => 'nullable',
            'email' => 'nullable|email',
            'alamat' => 'nullable',
            'maps' => 'nullable',
            'nama_ketua' => 'nullable',
            'sidebar_lg' => 'required|max:13',
            'sidebar_mini' => 'required|max:3',
            'title_header' => 'required',
            'logo' => 'nullable|image|file|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        if ($request->file('logo')) {
            if ($aplikasi->logo != null) {
                Storage::delete($aplikasi->logo);
            }
            $file = $request->file('logo');
            $fileName = 'baznas' . '.' . $file->getClientOriginalExtension();
            $file->storeAs('aplikasi-images', $fileName);
            $validatedData['logo'] = 'aplikasi-images/' . $fileName;
        }

        $aplikasi->update($validatedData);

        return redirect()->route('aplikasi.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
}
