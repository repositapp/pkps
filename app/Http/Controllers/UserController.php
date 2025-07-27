<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        $users = User::latest();
        if (request('search')) {
            $users->where('name', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('role', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%');
        }

        $users = $users->paginate(10)->appends(['search' => $search]);

        return view('pengaturan.pengguna.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('pengaturan.pengguna.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8',
            'avatar' => 'image|file|mimes:png,jpg,jpeg,webp|max:500',
            'role' => 'required',
            'status' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['email_verified_at'] = now();

        if ($request->file('avatar')) {
            $validatedData['avatar'] = $request->file('avatar')->store('users-images');
        }

        $unique = User::where('username', $request->username)->exists();

        if (!empty($unique)) {
            return redirect()->route('users.create')->with(['error' => 'Data Sudah Ada!']);
        } else {
            User::create($validatedData);

            return redirect()->route('users.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('pengaturan.pengguna.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {;
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:5|max:255',
            'email' => 'required|email',
            'role' => 'required',
            'status' => 'required',
        ]);

        if ($request->file('avatar')) {
            $validatedData['avatar'] = $request->validate(['avatar' => 'image|file|mimes:png,jpg,jpeg,webp|max:500']);

            if ($user->avatar != null) {
                Storage::delete($user->avatar);
            }
            $validatedData['avatar'] = $request->file('avatar')->store('users-images');
        }

        if ($request->password) {
            $validatedData['password'] = $request->validate(['password' => 'min:8']);
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }
        $user->delete();

        return redirect()->route('users.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
