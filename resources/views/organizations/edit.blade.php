@extends('layouts.app')

@section('title', 'Edit Organisasi - ' . $organization->name . ' - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 max-w-xl mx-auto"> {{-- Padding responsif, max-w disesuaikan --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200"> {{-- Tata letak responsif untuk header --}}
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0"> {{-- Ukuran H1 responsif --}}
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Organisasi: {{ $organization->name }}</span>
            </h1>
            <a href="{{ route('organizations.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base"> {{-- Ukuran tombol dan teks responsif --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        {{-- Form Edit Organisasi --}}
        <form action="{{ route('organizations.update', $organization->id) }}" method="POST" class="space-y-4 sm:space-y-6"> {{-- Jarak antar field responsif --}}
            @csrf
            @method('PUT') {{-- Penting: Laravel menggunakan PUT/PATCH untuk update --}}

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Nama Organisasi <span class="text-red-500">*</span></label> {{-- Margin bottom label responsif --}}
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" placeholder="Contoh: Himpunan Mahasiswa Teknik Informatika" value="{{ old('name', $organization->name) }}" required> {{-- Padding dan teks input responsif --}}
                @error('name')
                    <p class="mt-1 text-xs text-red-600 sm:mt-2 sm:text-sm">{{ $message }}</p> {{-- Margin top dan teks error responsif --}}
                @enderror
            </div>

            <div>
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Kode Organisasi <span class="text-red-500">*</span></label>
                <input type="text" name="code" id="code" class="mt-1 block w-full px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" placeholder="Contoh: HMTI" value="{{ old('code', $organization->code) }}" required>
                @error('code')
                    <p class="mt-1 text-xs text-red-600 sm:mt-2 sm:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Deskripsi Organisasi</label>
                <textarea name="description" id="description" rows="5" class="mt-1 block w-full px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base" placeholder="Deskripsi lengkap tentang organisasi ini...">{{ old('description', $organization->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-600 sm:mt-2 sm:text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-2 sm:pt-0"> {{-- Tata letak tombol responsif, padding top untuk mobile --}}
                <a href="{{ route('organizations.index') }}" class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 border border-gray-300 shadow-sm text-sm sm:text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    Batal
                </a>
                <button type="submit" class="submit-button-gradient inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 border border-transparent text-sm sm:text-base font-medium rounded-md shadow-sm text-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v8a2 2 0 01-2 2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h4v4H8V6z" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection