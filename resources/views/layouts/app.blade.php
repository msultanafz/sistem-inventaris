<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title> {{-- Judul halaman dinamis --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            /* Tailwind gray-50 - latar belakang sangat terang */
        }

        .nav-gradient {
            background: linear-gradient(to right, #4c51bf, #667eea);
            /* Indigo-700 to Indigo-500 */
        }

        .sidebar-bg {
            background-color: #1a202c;
            /* Tailwind gray-900 */
        }

        .card-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .submit-button-gradient {
            background: linear-gradient(to right, #059669, #10b981);
            /* Emerald-600 to Emerald-500 */
        }

        .cancel-button-gradient {
            background: linear-gradient(to right, #6b7280, #9ca3af);
            /* Gray-600 to Gray-400 */
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
                <span class="text-lg font-medium">Halo, {{ Auth::user()->name ?? 'Pengguna' }}!</span> {{-- Sekarang dinamis --}}
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
                        <a href="{{ route('dashboard') }}" class="block py-3 px-4 rounded-md @if(Request::routeIs('dashboard')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-3 group">
                            <svg class="h-6 w-6 @if(Request::routeIs('dashboard')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="{{ route('organizations.index') }}" class="block py-3 px-4 rounded-md @if(Request::routeIs('organizations.*')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-3 group">
                            <svg class="h-6 w-6 @if(Request::routeIs('organizations.*')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                            </svg>
                            <span>Manajemen Organisasi</span>
                        </a>
                    </li>
                    <li class="mb-3">
                        {{-- Menu baru untuk Manajemen Admin --}}
                        <a href="{{ route('users.index') }}" class="block py-3 px-4 rounded-md @if(Request::routeIs('users.*')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-3 group">
                            <svg class="h-6 w-6 @if(Request::routeIs('users.*')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
            @yield('content') {{-- Konten unik setiap halaman akan disisipkan di sini --}}

            @if (session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 5000)" {{-- Tampilkan 5 detik --}}
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-5 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-300 transition"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-5 opacity-0"
                class="fixed bottom-6 left-6 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2">
                <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 11-1.697-1.697l3.029-2.651-3.029-2.651a1.2 1.2 0 111.697-1.697l2.651 3.029 2.651-3.029a1.2 1.2 0 111.697 1.697l-3.029 2.651 3.029 2.651a1.2 1.2 0 010 1.697z" />
                </svg>
                <span class="font-bold">Error!</span>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 5000)" {{-- Tampilkan 5 detik --}}
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-5 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-300 transition"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-5 opacity-0"
                class="fixed bottom-6 left-6 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                <span class="font-bold">Sukses!</span>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

        </main>
    </div>
</body>

</html>