<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barber;
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

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('panel/dashboard');
        }

        return back()->with('loginError', 'Gagal! Kombinasi username dan kata sandi tidak sesuai. Silahkan coba lagi.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

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
            'name' => 'required|max:255',
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required|string|max:20|unique:users,telepon',
            'alamat' => 'required',
            'waktu_buka' => 'required|date_format:H:i',
            'waktu_tutup' => 'required|date_format:H:i|after:waktu_buka',
            'username' => 'required|min:5|max:255|unique:users',
            'password' => 'required|min:8',
            'gambar' => 'image|mimes:png,jpg,jpeg,webp|max:1024',
        ], [
            'waktu_tutup.after' => 'Waktu tutup harus setelah waktu buka.',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'telepon' => $validatedData['telepon'],
            'alamat' => $validatedData['alamat'],
            'role' => 'admin_barber',
            'status' => true,
        ]);

        if ($request->file('gambar')) {
            $file = $request->file('gambar');
            $fileName = Str::slug($validatedData['nama']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('barbers-images', $fileName);
            $validatedGambar = 'barbers-images/' . $fileName;
        }

        Barber::create([
            'user_id' => $user->id,
            'nama' => $validatedData['nama'],
            'nama_pemilik' => $validatedData['name'],
            'deskripsi' => $validatedData['deskripsi'],
            'alamat' => $validatedData['alamat'],
            'telepon' => $validatedData['telepon'],
            'email' => $validatedData['email'],
            'gambar' => $validatedGambar,
            'waktu_buka' => $validatedData['waktu_buka'],
            'waktu_tutup' => $validatedData['waktu_tutup'],
            'is_active' => false,
            'is_verified' => false,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
    }
}
