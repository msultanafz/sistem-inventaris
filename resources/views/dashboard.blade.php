@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 text-center"> {{-- Padding responsif --}}
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-800 mb-4 sm:mb-6">Selamat Datang di Dashboard!</h1> {{-- Ukuran H1 responsif --}}
        <p class="text-base sm:text-lg text-gray-600 mb-6 sm:mb-8"> {{-- Ukuran P responsif --}}
            Anda telah berhasil login. Gunakan menu di samping untuk mengelola inventaris kampus.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8"> {{-- Jarak antar card responsif --}}
            {{-- Card untuk Total Organisasi --}}
            <a href="{{ route('organizations.index') }}" class="block p-5 sm:p-6 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1"> {{-- Padding card responsif --}}
                <div class="flex items-center space-x-3 sm:space-x-4"> {{-- Jarak ikon/teks responsif --}}
                    <div class="p-2 sm:p-3 bg-indigo-200 rounded-full"> {{-- Padding ikon responsif --}}
                        <svg class="h-7 w-7 sm:h-8 sm:w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-medium text-indigo-700">Total Organisasi</p> {{-- Ukuran teks responsif --}}
                        <p class="text-2xl sm:text-3xl font-bold text-indigo-800">{{ \App\Models\Organization::count() }}</p> {{-- Ukuran angka responsif --}}
                    </div>
                </div>
            </a>

            {{-- Card untuk Total Admin --}}
            <a href="{{ route('users.index') }}" class="block p-5 sm:p-6 bg-emerald-50 border border-emerald-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1"> {{-- Padding card responsif --}}
                <div class="flex items-center space-x-3 sm:space-x-4"> {{-- Jarak ikon/teks responsif --}}
                    <div class="p-2 sm:p-3 bg-emerald-200 rounded-full"> {{-- Padding ikon responsif --}}
                        <svg class="h-7 w-7 sm:h-8 sm:w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2C3.518 15.363 8.368 12 14 12h3.356m7.138 0a.75.75 0 000 1.5H21a.75.75 0 000-1.5h-.862zm-.862-3.75h-.01M21 12v3.75h2.25V12h-2.25z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm sm:text-base font-medium text-emerald-700">Total Admin</p> {{-- Ukuran teks responsif --}}
                        <p class="text-2xl sm:text-3xl font-bold text-emerald-800">{{ \App\Models\User::count() }}</p> {{-- Ukuran angka responsif --}}
                    </div>
                </div>
            </a>

            {{-- Tambahkan kartu lain di sini nanti --}}
            <div class="block p-5 sm:p-6 bg-yellow-50 border border-yellow-200 rounded-lg shadow-sm"> {{-- Padding card responsif --}}
                <div class="flex items-center space-x-3 sm:space-x-4"> {{-- Jarak ikon/teks responsif --}}
                    <div class="p-2 sm:p-3 bg-yellow-200 rounded-full"> {{-- Padding ikon responsif --}}
                        <svg class="h-7 w-7 sm:h-8 sm:w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m7-8V3m0 0V2.25A2.25 2.25 0 009.75 0H7.5A2.25 2.25 0 005.25 2.25V3M12 21v-2m0 0v-2.25A2.25 2.25 0 0014.25 16H16.5A2.25 2.25 0 0018.75 18.25V21" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-yellow-700 mb-2 sm:mb-3">Manajemen Barang</h2> {{-- Ukuran H2 responsif --}}
                        <p class="text-sm sm:text-base text-gray-700">Segera hadir: Kelola detail semua aset inventaris.</p> {{-- Ukuran P responsif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection