<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\OrtuImport;
use App\Models\Ortu;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OrtuController extends Controller
{
    public function index()
    {
        $search = request('search');
        $ortus = Ortu::with('siswa');

        if (request('search')) {
            $ortus->where('nama_wali', 'like', '%' . $search . '%')
                ->orWhere('no_hp', 'like', '%' . $search . '%')
                ->orWhereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', '%' . $search . '%');
                });
        }

        $ortus = $ortus->latest()->paginate(10)->appends(['search' => $search]);

        return view('ortu.index', compact('ortus', 'search'));
    }

    public function create()
    {
        // Hanya tampilkan siswa yang belum memiliki orang tua
        $siswas = Siswa::doesntHave('ortu')->get();

        return view('ortu.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id|unique:ortus,siswa_id',
            'nama_wali' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|max:15',
            'alamat' => 'required',
        ]);

        // Buat user untuk ortu (opsional, bisa login nanti)
        // $siswa = Siswa::findOrFail($request->siswa_id);
        $email = strtolower(str_replace(' ', '', $request->nama_wali)) . '@ortu.com';

        $user = User::create([
            'name' => $request->nama_wali,
            'username' => strtolower(str_replace(' ', '_', $request->nama_wali)) . random_int(10, 99),
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), // default password
            'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
            'role' => 'ortu',
            'status' => true,
            'remember_token' => Str::random(10),
        ]);

        $validatedData['user_id'] = $user->id;

        Ortu::create($validatedData);

        return redirect()->route('ortu.index')->with(['success' => 'Data Orang Tua berhasil ditambahkan!']);
    }

    public function edit(string $id)
    {
        $ortu = Ortu::with('siswa')->findOrFail($id);
        $siswas = Siswa::all(); // semua siswa, karena sedang edit

        return view('ortu.edit', compact('ortu', 'siswas'));
    }

    public function update(Request $request, string $id)
    {
        $ortu = Ortu::findOrFail($id);

        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswas,id|unique:ortus,siswa_id,' . $id,
            'nama_wali' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|max:15',
            'alamat' => 'required',
        ]);

        $user = User::findOrFail($ortu->user_id);
        $email = strtolower(str_replace(' ', '', $request->nama_wali)) . '@ortu.com';
        $user->update([
            'name' => $request->nama_wali,
            'username' => strtolower(str_replace(' ', '_', $request->nama_wali)) . random_int(10, 99),
            'email' => $email,
        ]);

        $ortu->update($validatedData);

        return redirect()->route('ortu.index')->with(['success' => 'Data Orang Tua berhasil diperbarui!']);
    }

    public function destroy(string $id)
    {
        $ortu = Ortu::findOrFail($id);

        // Hapus user terkait jika ada
        if ($ortu->user_id) {
            User::destroy($ortu->user_id);
        }

        $ortu->delete();

        return redirect()->route('ortu.index')->with(['success' => 'Data Orang Tua berhasil dihapus!']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new OrtuImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data orang tua siswa berhasil diimport.');
    }
}
