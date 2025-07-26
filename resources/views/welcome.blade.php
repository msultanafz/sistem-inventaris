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
    <body class="font-poppins antialiased min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8">
        {{-- Kontainer Login Super Admin di Pojok Kiri Atas --}}
        <div class="absolute top-4 left-4 sm:top-6 sm:left-6 z-10">
            <button id="superAdminLoginButton" class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <span>Super Admin Login</span>
            </button>
        </div>

        <div class="text-center mb-10 sm:mb-16 mt-14">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 mb-4 sm:mb-6 drop-shadow-lg leading-tight">Sistem Inventaris Kampus</h1>
            <p class="text-lg sm:text-xl md:text-2xl text-gray-700 font-medium">Pilih organisasi Anda untuk mengelola inventaris.</p>
        </div>

        {{-- Grid Kontainer Organisasi (Dinamis dari Database) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10 w-full max-w-7xl">
            @forelse ($organizations as $organization)
            <div class="bg-white rounded-2xl shadow-custom-light p-6 sm:p-8 transform transition duration-300 ease-in-out hover:scale-105 hover:shadow-custom-hover cursor-pointer border border-gray-200"
                 onclick="showLoginPopup('{{ $organization->name }}', '{{ $organization->code }}')">
                <div class="flex flex-col items-center justify-center h-full text-center">
                    <div class="text-4xl sm:text-5xl mb-3 sm:mb-4 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 sm:h-16 sm:w-16" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mb-2 sm:mb-3">{{ $organization->name }}</h2>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed">{{ Str::limit($organization->description, 100, '...') ?? 'Tidak ada deskripsi yang tersedia.' }}</p>
                    <span class="mt-3 sm:mt-4 inline-block bg-indigo-100 text-indigo-700 text-xs sm:text-sm font-semibold px-3 py-1 rounded-full">{{ $organization->code }}</span>
                </div>
            </div>
            @empty
            {{-- Pesan ini muncul jika tidak ada organisasi di database --}}
            <div class="col-span-full text-center text-gray-700 text-base sm:text-xl py-12 sm:py-20 bg-white rounded-2xl shadow-lg border border-gray-200">
                <p class="mb-3 sm:mb-4">Belum ada organisasi yang terdaftar.</p>
                <p>Silakan hubungi Super Admin untuk menambahkan organisasi.</p>
            </div>
            @endforelse
        </div>

        {{-- Popup Login (Disembunyikan secara default) --}}
        <div id="loginPopup" class="fixed inset-0 bg-indigo-100 bg-opacity-70 flex items-center justify-center z-20 transition-opacity duration-300 opacity-0 pointer-events-none p-4">
            <div class="bg-white rounded-2xl shadow-custom-hover p-6 sm:p-10 w-full max-w-md relative transform transition-transform duration-300 scale-95">
                <button class="absolute top-3 right-3 sm:top-4 sm:right-4 text-gray-500 hover:text-gray-700 text-2xl sm:text-3xl font-light"
                        onclick="hideLoginPopup()">&times;</button>
                <h2 id="popupOrgName" class="text-2xl sm:text-3xl font-bold text-center text-gray-800 mb-6 sm:mb-8">Login untuk [Nama Organisasi]</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input id="email" class="block w-full px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base sm:text-lg"
                               type="email" name="email" value="" required autofocus placeholder="email@contoh.com">
                    </div>

                    {{-- Password Input with Toggle Visibility for Popup --}}
                    <div class="mt-5 sm:mt-6" x-data="{ popupPasswordVisible: false }"> {{-- Alpine.js data untuk toggle di popup --}}
                        <label for="popup_password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input id="popup_password" 
                                   class="block w-full px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-base sm:text-lg pr-10" {{-- Tambah padding kanan --}}
                                   :type="popupPasswordVisible ? 'text' : 'password'" {{-- Tipe input dinamis --}}
                                   name="password" {{-- Name harus 'password' agar Laravel Auth bisa memprosesnya --}}
                                   required 
                                   placeholder="••••••••">
                            <button type="button" 
                                    @click="popupPasswordVisible = !popupPasswordVisible" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                                <template x-if="popupPasswordVisible">
                                    {{-- Icon for visible password (eye-slash) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7c.563-1.478 1.48-2.835 2.66-4.015m1.414-1.414L10 6.172M13 10a3 3 0 11-6 0 3 3 0 016 0zm6.571-5.757a1 1 0 00-1.414-1.414L3.293 17.293a1 1 0 001.414 1.414L19.571 6.571z" />
                                    </svg>
                                </template>
                                <template x-if="!popupPasswordVisible">
                                    {{-- Icon for hidden password (eye) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 sm:mt-8">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105 text-base sm:text-lg">
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
                
                // Tambahkan input hidden untuk kode organisasi di form login
                let form = document.querySelector('#loginPopup form');
                let existingOrgCodeInput = document.getElementById('orgCodeInput');
                if (existingOrgCodeInput) {
                    existingOrgCodeInput.value = orgCode;
                } else {
                    let hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'organization_code'); // Nama input yang akan dikirim ke backend
                    hiddenInput.setAttribute('value', orgCode);
                    hiddenInput.setAttribute('id', 'orgCodeInput'); // Beri ID agar bisa dicari saat update
                    form.appendChild(hiddenInput);
                }
                
                const loginPopup = document.getElementById('loginPopup');
                loginPopup.classList.remove('opacity-0', 'pointer-events-none');
                loginPopup.classList.add('opacity-100');
                
                setTimeout(() => {
                    const popupContent = loginPopup.querySelector('div.bg-white');
                    if(popupContent) {
                        popupContent.classList.remove('scale-95');
                        popupContent.classList.add('scale-100');
                    }
                }, 50);
                
                document.body.style.overflow = 'hidden';
            }

            function hideLoginPopup() {
                const loginPopup = document.getElementById('loginPopup');
                const popupContent = loginPopup.querySelector('div.bg-white');
                
                if(popupContent) {
                    popupContent.classList.remove('scale-100');
                    popupContent.classList.add('scale-95');
                }

                loginPopup.classList.remove('opacity-100');
                loginPopup.classList.add('opacity-0');
                
                setTimeout(() => {
                    loginPopup.classList.add('pointer-events-none');
                    document.body.style.overflow = '';
                    
                    // Hapus input hidden kode organisasi saat popup ditutup
                    const orgCodeInput = document.getElementById('orgCodeInput');
                    if (orgCodeInput) {
                        orgCodeInput.remove();
                    }
                    // Reset input password di popup
                    document.getElementById('popup_password').value = '';
                }, 300);
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