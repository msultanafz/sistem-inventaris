<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource (users/admins).
     */
    public function index()
    {
        $users = User::all(); // Mengambil semua user dari database
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user (admin).
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user (admin) in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan mencari password_confirmation
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true, // Default: buat user ini sebagai admin
        ]);

        return redirect()->route('users.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified user (admin).
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user (admin) in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        // Hanya validasi password jika ada input dan tidak kosong
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified user (admin) from storage.
     */
    public function destroy(User $user)
    {
        // Jangan izinkan admin menghapus dirinya sendiri jika itu satu-satunya admin,
        // atau tambahkan validasi lain sesuai kebutuhan bisnis.
        if (Auth::id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Admin berhasil dihapus!');
    }
}