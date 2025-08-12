<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileAuthController extends Controller
{
    public function login()
    {
        return view('mobile.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|min:5',
            'password' => 'required|min:8'
        ]);

        // Coba login dengan guard 'user'
        if (Auth::guard('user')->attempt($credentials)) {
            $user = Auth::guard('user')->user();

            if ($user->guru) {
                return redirect()->route('mobile.guru.dashboard')->with('success', 'Login berhasil!');
            } elseif ($user->ortu) {
                return redirect()->route('mobile.ortu.dashboard')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors(['username' => 'Login gagal. Periksa kembali.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('mobile.login')->with('success', 'Logout berhasil!');
    }
}
