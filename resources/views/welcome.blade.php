<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Inventory Kampus</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom CSS untuk gradasi latar belakang dan efek */
            body {
                background: linear-gradient(to bottom right, #f0f4f8, #c6d9ee); /* Gradasi biru muda */
            }
            /* Efek bayangan yang lebih halus */
            .shadow-custom-light {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1);
            }
            .shadow-custom-hover {
                box-shadow: 0 8px 10px rgba(0, 0, 0, 0.1), 0 20px 25px rgba(0, 0, 0, 0.2);
            }
        </style>
    </head>
    <body class="font-poppins antialiased min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        {{-- Kontainer Login Super Admin di Pojok Kiri Atas --}}
        <div class="absolute top-6 left-6 z-10">
            <button id="superAdminLoginButton" class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white font-semibold py-3 px-7 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <span>Super Admin Login</span>
            </button>
        </div>

        <div class="text-center mb-16">
            <h1 class="text-6xl font-extrabold text-gray-900 mb-6 drop-shadow-lg leading-tight">Sistem Inventaris Kampus</h1>
            <p class="text-2xl text-gray-700 font-medium">Pilih organisasi Anda untuk mengelola inventaris.</p>
        </div>

        {{-- Grid Kontainer Organisasi (Dinamis dari Database) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 w-full max-w-7xl">
            @forelse ($organizations as $organization)
            <div class="bg-white rounded-2xl shadow-custom-light p-8 transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-custom-hover cursor-pointer border border-gray-200"
                 onclick="showLoginPopup('{{ $organization->name }}', '{{ $organization->code }}')">
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="text-5xl mb-4 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ $organization->name }}</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">{{ $organization->description ?? 'Tidak ada deskripsi yang tersedia untuk organisasi ini.' }}</p>
                    <span class="mt-4 inline-block bg-indigo-100 text-indigo-700 text-sm font-semibold px-4 py-1 rounded-full">{{ $organization->code }}</span>
                </div>
            </div>
            @empty
            {{-- Pesan ini muncul jika tidak ada organisasi di database --}}
            <div class="col-span-full text-center text-gray-700 text-xl py-20 bg-white rounded-2xl shadow-lg border border-gray-200">
                <p class="mb-4">Belum ada organisasi yang terdaftar.</p>
                <p>Silakan hubungi Super Admin untuk menambahkan organisasi.</p>
            </div>
            @endforelse
        </div>

        {{-- Popup Login (Disembunyikan secara default) --}}
        <div id="loginPopup" class="fixed inset-0 bg-indigo-100 bg-opacity-70 flex items-center justify-center z-20 transition-opacity duration-300 opacity-0 pointer-events-none">
            <div class="bg-white rounded-2xl shadow-custom-hover p-10 w-full max-w-md relative transform transition-transform duration-300 scale-95">
                <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl font-light"
                        onclick="hideLoginPopup()">&times;</button>
                <h2 id="popupOrgName" class="text-3xl font-bold text-center text-gray-800 mb-8">Login untuk [Nama Organisasi]</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input id="email" class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                               type="email" name="email" value="" required autofocus placeholder="email@contoh.com">
                    </div>

                    <div class="mt-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <input id="password" class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                               type="password" name="password" required placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105 text-lg">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Script JavaScript untuk kontrol Popup dan tombol Super Admin --}}
        <script>
            function showLoginPopup(orgName, orgCode) {
                document.getElementById('popupOrgName').innerText = 'Login untuk ' + orgName;
                // Anda mungkin ingin menambahkan input hidden untuk kode organisasi di form login
                // document.getElementById('orgCodeInput').value = orgCode; // Jika ada input dengan id='orgCodeInput'
                
                const loginPopup = document.getElementById('loginPopup');
                loginPopup.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
                loginPopup.classList.add('flex', 'opacity-100');
                document.body.style.overflow = 'hidden';

                const popupContent = loginPopup.querySelector('div');
                popupContent.classList.remove('scale-95');
                popupContent.classList.add('scale-100');
            }

            function hideLoginPopup() {
                const loginPopup = document.getElementById('loginPopup');
                const popupContent = loginPopup.querySelector('div');
                
                popupContent.classList.remove('scale-100');
                popupContent.classList.add('scale-95');

                loginPopup.classList.remove('opacity-100');
                loginPopup.classList.add('opacity-0');
                
                setTimeout(() => {
                    loginPopup.classList.add('hidden', 'pointer-events-none');
                    document.body.style.overflow = '';
                }, 300); // Sesuaikan dengan durasi transisi
            }

            // Script untuk tombol Super Admin Login
            document.addEventListener('DOMContentLoaded', function() {
                const superAdminButton = document.getElementById('superAdminLoginButton');
                if (superAdminButton) {
                    superAdminButton.addEventListener('click', function() {
                        window.location.href = "{{ route('login') }}";
                    });
                }
            });
        </script>
    </body>
</html>