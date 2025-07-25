<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('organizations.create'); // Ini yang penting!
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:organizations,code', // 'unique:organizations,code' memastikan kode unik
            'description' => 'nullable|string', // 'nullable' berarti boleh kosong
        ], [
            'name.required' => 'Nama organisasi wajib diisi.',
            'name.string' => 'Nama organisasi harus berupa teks.',
            'name.max' => 'Nama organisasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode organisasi wajib diisi.',
            'code.string' => 'Kode organisasi harus berupa teks.',
            'code.max' => 'Kode organisasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode organisasi ini sudah digunakan. Harap gunakan kode lain.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        // 2. Buat instance Organization baru dan isi datanya
        $organization = new Organization();
        $organization->name = $validatedData['name'];
        $organization->code = Str::upper($validatedData['code']); // Ubah kode menjadi huruf kapital
        $organization->short_description = Str::limit($validatedData['description'] ?? '', 100); // Ambil 100 karakter pertama
        $organization->description = $validatedData['description'];

        // 3. Simpan ke database
        $organization->save();

        // 4. Redirect dengan pesan sukses
        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        // Laravel secara otomatis akan menginject instance Organization berdasarkan ID di route
        return view('organizations.show', compact('organization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
{
    return view('organizations.edit', compact('organization')); // Ini yang penting!
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        // 1. Validasi Data
        // Perhatikan aturan 'unique:organizations,code,' . $organization->id
        // Ini berarti kode harus unik, KECUALI untuk organisasi yang sedang diedit saat ini.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:organizations,code,' . $organization->id,
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama organisasi wajib diisi.',
            'name.string' => 'Nama organisasi harus berupa teks.',
            'name.max' => 'Nama organisasi tidak boleh lebih dari :max karakter.',
            'code.required' => 'Kode organisasi wajib diisi.',
            'code.string' => 'Kode organisasi harus berupa teks.',
            'code.max' => 'Kode organisasi tidak boleh lebih dari :max karakter.',
            'code.unique' => 'Kode organisasi ini sudah digunakan oleh organisasi lain. Harap gunakan kode lain.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ]);

        // 2. Perbarui instance Organization dengan data yang sudah divalidasi
        $organization->name = $validatedData['name'];
        $organization->code = Str::upper($validatedData['code']); // Ubah kode menjadi huruf kapital
        $organization->short_description = Str::limit($validatedData['description'] ?? '', 100); // Ambil 100 karakter pertama
        $organization->description = $validatedData['description'];

        // 3. Simpan perubahan ke database
        $organization->save();

        // 4. Redirect dengan pesan sukses
        return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
{
    // Hapus organisasi dari database
    $organization->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('organizations.index')->with('success', 'Organisasi berhasil dihapus!');
}
}