<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .nav-gradient {
            background: linear-gradient(to right, #4c51bf, #667eea);
        }

        .sidebar-bg {
            background-color: #1a202c;
        }

        .card-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .submit-button-gradient {
            background: linear-gradient(to right, #059669, #10b981);
        }

        .cancel-button-gradient {
            background: linear-gradient(to right, #6b7280, #9ca3af);
        }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col">

    {{-- Navbar --}}
    <nav class="nav-gradient text-white p-4 sm:p-5 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                {{-- Tombol Hamburger hanya muncul di mobile --}}
                <button id="hamburgerBtn" class="lg:hidden p-2 mr-3 rounded-md hover:bg-indigo-600 focus:outline-none">
                    <!-- Icon Open -->
                    <svg id="hamburgerOpen" class="h-6 w-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon Close -->
                    <svg id="hamburgerClose" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <a href="{{ route('dashboard') }}" class="text-xl sm:text-2xl font-bold tracking-wide">
                    <span class="text-indigo-200">Sistem</span> <span class="text-white">Inventaris</span>
                </a>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                {{-- Tampilkan tombol "Kembali ke Super Admin" jika sedang impersonasi --}}
                @if(session()->has('impersonator_id'))
                    <form method="POST" action="{{ route('users.leaveImpersonation') }}">
                        @csrf
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-semibold py-1.5 px-4 sm:py-2 sm:px-5 rounded-md transition duration-300 ease-in-out text-sm sm:text-base flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0M3 12l-3 3" />
                            </svg>
                            <span>Kembali ke Super Admin</span>
                        </button>
                    </form>
                @endif

                <span class="text-sm sm:text-lg font-medium">Halo, {{ Auth::user()->name ?? 'Pengguna' }}!</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1.5 px-4 sm:py-2 sm:px-5 rounded-md transition duration-300 ease-in-out text-sm sm:text-base">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="flex flex-1">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 sidebar-bg text-gray-200 p-4 sm:p-6 shadow-xl flex flex-col justify-between transform -translate-x-full lg:translate-x-0 lg:relative lg:flex lg:flex-col transition-transform duration-300 ease-in-out">
            <nav>
                <ul>
                    <li class="mb-3">
                        <a href="{{ route('dashboard') }}"
                            class="block py-2.5 px-3 sm:py-3 sm:px-4 rounded-md 
                            @if(Request::routeIs('dashboard')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 
                            @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-2.5 sm:space-x-3 group text-sm sm:text-base">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 
                                @if(Request::routeIs('dashboard')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2 2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    
                    {{-- Tampilkan menu untuk Super Admin --}}
                    @if(Auth::check() && Auth::user()->isSuperAdmin())
                        <li class="mb-3">
                            <a href="{{ route('organizations.index') }}"
                                class="block py-2.5 px-3 sm:py-3 sm:px-4 rounded-md 
                                @if(Request::routeIs('organizations.*')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 
                                @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-2.5 sm:space-x-3 group text-sm sm:text-base">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6 
                                    @if(Request::routeIs('organizations.*')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                                </svg>
                                <span>Manajemen Organisasi</span>
                            </a>
                        </li>
                        <li class="mb-3">
                            <a href="{{ route('users.index') }}"
                                class="block py-2.5 px-3 sm:py-3 sm:px-4 rounded-md 
                                @if(Request::routeIs('users.*')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 
                                @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-2.5 sm:space-x-3 group text-sm sm:text-base">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6 
                                    @if(Request::routeIs('users.*')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2C3.518 15.363 8.368 12 14 12h3.356m7.138 0a.75.75 0 000 1.5H21a.75.75 0 000-1.5h-.862zm-.862-3.75h-.01M21 12v3.75h2.25V12h-2.25z" />
                                </svg>
                                <span class="font-medium">Manajemen Admin</span>
                            </a>
                        </li>
                    @endif

                    {{-- Tampilkan menu untuk Admin Organisasi --}}
                    @if(Auth::check() && Auth::user()->isOrganizationAdmin())
                        <li class="mb-3">
                            <a href="{{ route('inventory_items.index') }}"
                                class="block py-2.5 px-3 sm:py-3 sm:px-4 rounded-md 
                                @if(Request::routeIs('inventory_items.index') || Request::routeIs('inventory_items.create') || Request::routeIs('inventory_items.edit') || Request::routeIs('inventory_items.show')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 
                                @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-2.5 sm:space-x-3 group text-sm sm:text-base">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6 
                                    @if(Request::routeIs('inventory_items.index') || Request::routeIs('inventory_items.create') || Request::routeIs('inventory_items.edit') || Request::routeIs('inventory_items.show')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="font-medium">Inventaris Barang</span>
                            </a>
                        </li>
                        {{-- Menu Barang Terbaru (dipindahkan ke sini, di luar blok if Request::routeIs('inventory_items.*')) --}}
                        <li class="mb-3">
                            <a href="{{ route('inventory_items.recent') }}"
                                class="block py-2.5 px-3 sm:py-3 sm:px-4 rounded-md 
                                @if(Request::routeIs('inventory_items.recent')) bg-indigo-700 text-white font-semibold shadow-sm border border-indigo-500 
                                @else hover:bg-gray-700 transition duration-200 ease-in-out @endif flex items-center space-x-2.5 sm:space-x-3 group text-sm sm:text-base">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6 
                                    @if(Request::routeIs('inventory_items.recent')) text-white @else text-gray-400 group-hover:text-white @endif transition duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Barang Terbaru</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <div class="mt-8 text-xs text-gray-500">
                <p>&copy; 2025 Inventaris Kampus</p>
                <p>Version 1.0.0</p>
            </div>
        </aside>

        {{-- Overlay hitam --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gray-50 overflow-y-auto relative">
            
            {{-- Notifikasi Error --}}
            @if (session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-5 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-300 transition"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-5 opacity-0"
                class="fixed bottom-4 left-4 sm:bottom-6 sm:left-6 bg-red-500 text-white px-4 py-2.5 sm:px-5 sm:py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 text-sm sm:text-base">
                <svg class="fill-current h-5 w-5 sm:h-6 sm:w-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M14.348 14.849a1.2 1.2 0 01-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 11-1.697-1.697l3.029-2.651-3.029-2.651a1.2 1.2 0 111.697-1.697l2.651 3.029 2.651-3.029a1.2 1.2 0 111.697 1.697l-3.029 2.651 3.029 2.651a1.2 1.2 0 010 1.697z" />
                </svg>
                <span class="font-bold">Error!</span>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            {{-- Notifikasi Success --}}
            @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 2000)"
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-5 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform ease-in duration-300 transition"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-5 opacity-0"
                class="fixed bottom-4 left-4 sm:bottom-6 sm:left-6 bg-green-500 text-white px-4 py-2.5 sm:px-5 sm:py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                <span class="font-bold">Sukses!</span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            {{-- Konten Halaman --}}
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const iconOpen = document.getElementById('hamburgerOpen');
        const iconClose = document.getElementById('hamburgerClose');

        function toggleSidebar(show) {
            if (show) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        }

        // Tombol hamburger toggle sidebar
        hamburgerBtn.addEventListener('click', () => {
            const isHidden = sidebar.classList.contains('-translate-x-full');
            toggleSidebar(isHidden);
        });

        // Klik overlay menutup sidebar
        sidebarOverlay.addEventListener('click', () => toggleSidebar(false));

        // Responsif otomatis: kalau layar lebar, sidebar selalu tampil
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

</body>
</html>