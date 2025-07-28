@extends('layouts.app')

@section('title', $dashboardTitle . ' - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 text-center">
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-800 mb-4 sm:mb-6">
            Selamat Datang di {{ $dashboardTitle }}!
        </h1>
        <p class="text-base sm:text-lg text-gray-600 mb-6 sm:mb-8">
            Anda telah berhasil login. Gunakan menu di samping untuk mengelola inventaris kampus.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            {{-- Konten untuk Super Admin --}}
            @if(Auth::user()->isSuperAdmin())
                {{-- Card untuk Total Organisasi --}}
                <a href="{{ route('organizations.index') }}" class="block p-5 sm:p-6 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-2 sm:p-3 bg-indigo-200 rounded-full">
                            <svg class="h-7 w-7 sm:h-8 sm:w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-indigo-700">Total Organisasi</p>
                            <p class="text-2xl sm:text-3xl font-bold text-indigo-800">{{ $dashboardData['totalOrganizations'] ?? 0 }}</p>
                        </div>
                    </div>
                </a>

                {{-- Card untuk Total Admin --}}
                <a href="{{ route('users.index') }}" class="block p-5 sm:p-6 bg-emerald-50 border border-emerald-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-2 sm:p-3 bg-emerald-200 rounded-full">
                            <svg class="h-7 w-7 sm:h-8 sm:w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2C3.518 15.363 8.368 12 14 12h3.356m7.138 0a.75.75 0 000 1.5H21a.75.75 0 000-1.5h-.862zm-.862-3.75h-.01M21 12v3.75h2.25V12h-2.25z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-emerald-700">Total Admin</p>
                            <p class="text-2xl sm:text-3xl font-bold text-emerald-800">{{ $dashboardData['totalAdmins'] ?? 0 }}</p>
                        </div>
                    </div>
                </a>
            @endif

            {{-- Konten untuk Admin Organisasi --}}
            @if(Auth::user()->isOrganizationAdmin())
                {{-- Card untuk Total Barang Inventaris --}}
                <a href="{{ route('inventory_items.index') }}" class="block p-5 sm:p-6 bg-blue-50 border border-blue-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-2 sm:p-3 bg-blue-200 rounded-full">
                            <svg class="h-7 w-7 sm:h-8 sm:w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-blue-700">Total Barang Inventaris</p>
                            <p class="text-2xl sm:text-3xl font-bold text-blue-800">{{ $dashboardData['totalItems'] ?? 0 }}</p>
                        </div>
                    </div>
                    <p class="text-sm sm:text-base text-gray-600 mt-3">Kelola inventaris barang.</p>
                </a>

                {{-- Card untuk Barang Dipinjam (Hanya Jumlah) --}}
                <a href="#" class="block p-5 sm:p-6 bg-orange-50 border border-orange-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        <div class="p-2 sm:p-3 bg-orange-200 rounded-full">
                            <svg class="h-7 w-7 sm:h-8 sm:w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-orange-700">Total Barang Dipinjam</p>
                            <p class="text-2xl sm:text-3xl font-bold text-orange-800">{{ $dashboardData['borrowedItemsCount'] ?? 0 }}</p>
                        </div>
                    </div>
                    <p class="text-sm sm:text-base text-gray-600 mt-3">Kelola transaksi peminjaman barang.</p>
                </a>

                {{-- Card untuk Barang Terbaru (Hanya Tautan) --}}
                <a href="{{ route('inventory_items.recent') }}" class="block p-5 sm:p-6 bg-teal-50 border border-teal-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 flex flex-col items-center justify-center">
                    <div class="p-2 sm:p-3 bg-teal-200 rounded-full mb-3">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-lg sm:text-xl font-semibold text-teal-700 mb-2">Barang Terbaru</p>
                    <p class="text-sm sm:text-base text-gray-600">Lihat daftar barang yang baru ditambahkan.</p>
                </a>

                
            @endif
        </div>
    </div>
@endsection