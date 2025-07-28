<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use Illuminate\Validation\Rule;

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
        $organizations = Organization::all(); // Ambil semua organisasi
        return view('users.create', compact('organizations'));
    }

    /**
     * Store a newly created user (admin) in storage.
     */
    public function store(Request $request) // Jika Anda menggunakan Form Request, ganti Request dengan UserRequest
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // Validasi untuk organization_id
            // Rule::exists('organizations', 'id') memastikan ID organisasi ada di tabel organizations
            // nullable() berarti field ini boleh kosong (untuk Super Admin)
            'organization_id' => ['nullable', 'exists:organizations,id'],
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'organization_id' => $validatedData['organization_id'], // Simpan organization_id
        ]);

        return redirect()->route('users.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified user (admin).
     */
    public function edit(User $user) // Menerima instance User yang akan diedit
    {
        $organizations = Organization::all(); // Ambil semua organisasi
        // Kirim variabel $user dan $organizations ke view
        return view('users.edit', compact('user', 'organizations'));
    }

    /**
     * Update the specified user (admin) in storage.
     */
    public function update(Request $request, User $user) // Jika Anda menggunakan Form Request, ganti Request dengan UserRequest
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // Password boleh kosong jika tidak ingin diubah
            // Validasi untuk organization_id
            'organization_id' => ['nullable', 'exists:organizations,id'],
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->organization_id = $validatedData['organization_id']; // Perbarui organization_id

        if ($request->filled('password')) { // Hanya perbarui password jika diisi
            $user->password = Hash::make($validatedData['password']);
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

    /**
     * Allow Super Admin to impersonate an Organization Admin.
     */
    public function impersonate(User $user)
    {

        // Pastikan user yang login adalah Super Admin
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan user yang akan di-impersonate adalah Organization Admin
        if (!$user->isOrganizationAdmin()) {
            return redirect()->back()->with('error', 'Hanya dapat masuk sebagai Admin Organisasi.');
        }

        // Simpan ID Super Admin di session sebelum impersonasi
        session()->put('impersonator_id', Auth::id());

        // Login sebagai user Admin Organisasi
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Anda sekarang masuk sebagai Admin Organisasi ' . $user->organization->name . '.');
    }

    /**
     * Allow Super Admin to leave impersonation.
     */
    public function leaveImpersonation()
    {
        // Pastikan ada ID impersonator di session
        if (!session()->has('impersonator_id')) {
            return redirect()->route('dashboard')->with('error', 'Tidak dalam mode impersonasi.');
        }

        // Dapatkan ID Super Admin yang asli
        $impersonatorId = session()->pull('impersonator_id');
        $impersonator = User::find($impersonatorId);

        // Login kembali sebagai Super Admin
        Auth::login($impersonator);

        return redirect()->route('dashboard')->with('success', 'Anda telah kembali ke dashboard Super Admin.');
    }
}
