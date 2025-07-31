<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    public function index(): View
    {
        return view('auth.user-login');
    }

    public function registrasi()
    {
        return view('auth.user-registrasi');
    }

    // Proses Login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

        // Coba login dengan guard 'user'
        if (Auth::guard('user')->attempt($credentials)) {
            $user = Auth::guard('user')->user();

            // Periksa role
            if ($user->role !== 'pelanggan') {
                Auth::guard('user')->logout();
                return back()->with('error', 'Anda tidak memiliki akses ke halaman pelanggan.');
            }

            $request->session()->regenerate();
            return redirect('mobile/dashboard');
        }

        return back()->with('loginError', 'Username atau password salah.');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required|min:8',
            'alamat' => 'required|min:8',
            'password' => 'required|min:8',
        ]);

        $validatedData['email_verified_at'] = now();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['avatar'] = 'users-images/1J7iwiUja9gMqtHL7eIzR6RbaH0rrzZ5buklDQLy.png';
        $validatedData['role'] = 'pelanggan';
        $validatedData['status'] = 1;

        $unique = User::where('username', $request->username)->exists();

        if (!empty($unique)) {
            return redirect()->route('user.register')->with('error', 'Data sudah ada.');
        } else {
            User::create($validatedData);

            return redirect()->route('user.login')->with('success', 'Registrasi berhasil! Silahkan login.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
