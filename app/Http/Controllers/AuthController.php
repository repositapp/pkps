<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'pelanggan') {
                $query = Pelanggan::where('user_id', auth()->user()->id)->first();

                session([
                    'pelanggan_id' => $query->id,
                    'user_id' => $query->user_id,
                    'nama_pelanggan' => $query->nama_pelanggan,
                    'jenis_kelamin' => $query->jenis_kelamin,
                    'alamat' => $query->alamat,
                    'nomor_telepon' => $query->nomor_telepon,
                    'nomor_sambungan' => $query->nomor_sambungan,
                    'file_ktp' => $query->file_ktp,
                ]);
            }

            $request->session()->regenerate();

            return redirect('panel/dashboard');
        }

        return back()->with('loginError', 'Gagal! Kombinasi username dan kata sandi tidak sesuai. Silahkan coba lagi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function registrasi()
    {
        return view('auth.registrasi');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'nomor_telepon' => 'required|string|max:20|unique:pelanggans,nomor_telepon',
            'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB Max
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:5|max:255|unique:users',
            'password' => 'required|min:8',
        ], [
            // Pesan error kustom jika diperlukan
            'nomor_telepon.unique' => 'Nomor telepon ini sudah digunakan oleh pelanggan lain.',
            'file_ktp.mimes' => 'File KTP harus berupa gambar (jpg, jpeg, png) atau PDF.',
            'file_ktp.max' => 'Ukuran file KTP maksimal 2MB.',
        ]);

        $unique = User::where('username', $request->username)->exists();

        if (!empty($unique)) {
            return redirect()->route('register')->with('error', 'Data sudah ada.');
        } else {
            $user = User::create([
                'name' => $request->nama_pelanggan,
                'username' => $request->username,
                'email' => $request->email,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'avatar' => 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png',
                'role' => 'pelanggan',
                'status' => true,
            ]);

            if ($request->file('file_ktp')) {
                $file = $request->file('file_ktp');
                $fileName = time() . '-' . Str::slug($validatedData['nama_pelanggan']) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('dokumen-file', $fileName);
                $validatedData['file_ktp'] = 'dokumen-file/' . $fileName;
            }

            $validatedData['user_id'] = $user->id;

            Pelanggan::create($validatedData);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
        }
    }
}
