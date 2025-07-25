@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-8 border border-gray-100 text-center">
        <h1 class="text-5xl font-extrabold text-gray-800 mb-6">Selamat Datang di Dashboard!</h1>
        <p class="text-lg text-gray-600 mb-8">
            Anda telah berhasil login. Gunakan menu di samping untuk mengelola inventaris kampus.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('organizations.index') }}" class="block p-6 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <h2 class="text-2xl font-bold text-indigo-700 mb-3">Manajemen Organisasi</h2>
                <p class="text-gray-700">Kelola semua organisasi, departemen, atau unit di kampus.</p>
            </a>
            <a href="{{ route('users.index') }}" class="block p-6 bg-emerald-50 border border-emerald-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                <h2 class="text-2xl font-bold text-emerald-700 mb-3">Manajemen Admin</h2>
                <p class="text-gray-700">Tambahkan, edit, atau hapus akun admin sistem.</p>
            </a>
            {{-- Tambahkan kartu lain di sini nanti --}}
            <div class="block p-6 bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold text-yellow-700 mb-3">Manajemen Barang</h2>
                <p class="text-gray-700">Segera hadir: Kelola detail semua aset inventaris.</p>
            </div>
        </div>
    </div>
@endsection