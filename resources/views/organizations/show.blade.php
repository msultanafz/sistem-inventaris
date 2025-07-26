@extends('layouts.app')

@section('title', 'Detail Organisasi - ' . $organization->name . ' - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 max-w-4xl mx-auto"> {{-- Padding responsif, max-w disesuaikan --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200"> {{-- Tata letak responsif untuk header --}}
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0"> {{-- Ukuran H1 responsif --}}
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                </svg>
                <span>Detail Organisasi</span>
            </h1>
            <a href="{{ route('organizations.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base"> {{-- Ukuran tombol dan teks responsif --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-base sm:text-lg text-gray-800"> {{-- Grid dan teks responsif --}}
            <div class="p-3 sm:p-4 bg-gray-50 rounded-lg border border-gray-200"> {{-- Padding responsif --}}
                <p class="text-gray-500 text-xs sm:text-sm mb-1">Nama Organisasi:</p> {{-- Ukuran teks responsif --}}
                <p class="font-bold text-xl sm:text-2xl">{{ $organization->name }}</p> {{-- Ukuran teks responsif --}}
            </div>
            <div class="p-3 sm:p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500 text-xs sm:text-sm mb-1">Kode Organisasi:</p>
                <p class="font-bold text-xl sm:text-2xl">{{ $organization->code }}</p>
            </div>
            <div class="md:col-span-2 p-3 sm:p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500 text-xs sm:text-sm mb-1">Deskripsi Lengkap:</p>
                <p class="text-gray-700 text-sm sm:text-base leading-relaxed">{{ $organization->description ?? '-' }}</p> {{-- Ukuran teks responsif --}}
            </div>
            <div class="md:col-span-2 p-3 sm:p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500 text-xs sm:text-sm mb-1">Dibuat Pada:</p>
                <p class="text-gray-700 text-sm sm:text-base">{{ $organization->created_at->format('d F Y, H:i:s') }}</p>
            </div>
            <div class="md:col-span-2 p-3 sm:p-4 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500 text-xs sm:text-sm mb-1">Terakhir Diperbarui:</p>
                <p class="text-gray-700 text-sm sm:text-base">{{ $organization->updated_at->format('d F Y, H:i:s') }}</p>
            </div>
        </div>

        <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row justify-start space-y-3 sm:space-y-0 sm:space-x-4"> {{-- Tata letak tombol responsif --}}
            <a href="{{ route('organizations.edit', $organization->id) }}" class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 border border-transparent text-sm sm:text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Organisasi
            </a>
            <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus organisasi {{ $organization->name }}? Data ini akan hilang secara permanen.');" class="w-full sm:w-auto"> {{-- Lebar penuh di mobile --}}
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 border border-transparent text-sm sm:text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out w-full"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Organisasi
                </button>
            </form>
        </div>
    </div>
@endsection