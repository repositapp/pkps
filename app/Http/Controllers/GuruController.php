<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index()
    {
        $search = request('search');
        $gurus = Guru::with('user');

        if (request('search')) {
            $gurus->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nip', 'like', '%' . $search . '%');
        }

        $gurus = $gurus->latest()->paginate(10)->appends(['search' => $search]);

        return view('guru.index', compact('gurus', 'search'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'nip' => 'nullable|unique:gurus,nip|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|max:15',
            'alamat' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'username' => strtolower(str_replace(' ', '_', $request->nama_lengkap)) . random_int(10, 99),
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // default password
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'guru',
            'status' => true,
            'remember_token' => Str::random(10),
        ]);

        $validatedData['user_id'] = $user->id;

        Guru::create($validatedData);

        return redirect()->route('guru.index')->with(['success' => 'Data Guru Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);

        $validatedData = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'nip' => 'nullable|unique:gurus,nip,' . $id . '|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|max:15',
            'alamat' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::findOrFail($guru->user_id);
        $user->update([
            'name' => $request->nama_lengkap,
            'username' => strtolower(str_replace(' ', '_', $request->nama_lengkap)) . random_int(10, 99),
            'email' => $request->email,
        ]);

        $guru->update($validatedData);

        return redirect()->route('guru.index')->with(['success' => 'Data Guru Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $akun = User::findOrFail($guru->user_id);

        $akun->delete();
        $guru->delete();

        return redirect()->route('guru.index')->with(['success' => 'Data Guru Berhasil Dihapus!']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $import = new GuruImport();
        Excel::import($import, $request->file('file'));

        return redirect()->back()->with(
            'success',
            "{$import->successCount} data guru berhasil diimport, {$import->skippedCount} data dilewati."
        );
    }
}
