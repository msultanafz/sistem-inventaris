<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tambah Organisasi - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc; /* Tailwind gray-50 - latar belakang sangat terang */
        }
        .nav-gradient {
            background: linear-gradient(to right, #4c51bf, #667eea); /* Indigo-700 to Indigo-500 */
        }
        .sidebar-bg {
            background-color: #1a202c; /* Tailwind gray-900 */
        }
        .card-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .submit-button-gradient {
            background: linear-gradient(to right, #059669, #10b981); /* Emerald-600 to Emerald-500 */
        }
        .cancel-button-gradient {
            background: linear-gradient(to right, #6b7280, #9ca3af); /* Gray-600 to Gray-400 */
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">
    {{-- Navbar --}}
    <nav class="nav-gradient text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold tracking-wide">
                <span class="text-indigo-200">Inventaris</span> <span class="text-white">Kampus</span>
            </a>
            <div class="flex items-center space-x-4">
                <span class="text-lg font-medium">Halo, Super Admin!</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-md transition duration-300 ease-in-out">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Content Wrapper --}}
    <div class="flex flex-1">
        {{-- Sidebar --}}
        <aside class="w-64 sidebar-bg text-gray-200 p-6 shadow-xl flex flex-col justify-between">
            <nav>
                <ul>
                    <li class="mb-3">
                        <a href="{{ route('dashboard') }}" class="block py-3 px-4 rounded-md hover:bg-gray-700 transition duration-200 ease-in-out flex items-center space-x-3 group">
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-white transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('organizations.index') }}" class="block py-3 px-4 rounded-md bg-indigo-700 text-white font-semibold shadow-sm flex items-center space-x-3 border border-indigo-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                            </svg>
                            <span>Manajemen Organisasi</span>
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="#" class="block py-3 px-4 rounded-md hover:bg-gray-700 transition duration-200 ease-in-out flex items-center space-x-3 group">
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-white transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2C3.518 15.363 8.368 12 14 12h3.356m7.138 0a.75.75 0 000 1.5H21a.75.75 0 000-1.5h-.862zm-.862-3.75h-.01M21 12v3.75h2.25V12h-2.25z" />
                            </svg>
                            <span class="font-medium">Manajemen Admin</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="mt-8 text-xs text-gray-500">
                <p>&copy; 2025 Inventaris Kampus</p>
                <p>Version 1.0.0</p>
            </div>
        </aside>

        {{-- Content Area --}}
        <main class="flex-1 p-8 bg-gray-50">
            <div class="bg-white rounded-xl card-shadow p-8 border border-gray-100">
                <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                    <h1 class="text-4xl font-extrabold text-gray-800 flex items-center space-x-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                        </svg>
                        <span>Tambah Organisasi Baru</span>
                    </h1>
                    <a href="{{ route('organizations.index') }}" class="cancel-button-gradient text-white font-semibold py-3 px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>

                {{-- Form Tambah Organisasi --}}
                <form action="{{ route('organizations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: Prodi Teknik Informatika" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Kode Organisasi <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="code" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: PTI" value="{{ old('code') }}" required>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Organisasi</label>
                        <textarea name="description" id="description" rows="5" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Deskripsi lengkap tentang organisasi ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('organizations.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Batal
                        </a>
                        <button type="submit" class="submit-button-gradient inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Simpan Organisasi
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>