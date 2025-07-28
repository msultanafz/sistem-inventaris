@extends('layouts.app')

@section('title', 'Tambah Admin Baru - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 max-w-xl mx-auto"> {{-- Padding responsif, max-w sedikit dikecilkan --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200"> {{-- Tata letak responsif untuk header --}}
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0"> {{-- Ukuran H1 responsif --}}
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14v5h6v-5h-6z" />
                </svg>
                <span>Tambah Admin Baru</span>
            </h1>
            {{-- Tombol "Kembali" --}}
            <a href="{{ route('users.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-4 sm:mb-5"> {{-- Margin bottom responsif --}}
                <label for="name" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Nama:</label> {{-- Margin bottom label responsif --}}
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required autofocus> {{-- Padding input responsif --}}
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p> {{-- Margin top error responsif --}}
                @enderror
            </div>
            <div class="mb-4 sm:mb-5">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Email:</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- START: Tambahan Field Organisasi --}}
            <div class="mb-4 sm:mb-5">
                <label for="organization_id" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Organisasi:</label>
                <select name="organization_id" id="organization_id" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('organization_id') border-red-500 @enderror">
                    <option value="">-- Pilih Organisasi (Kosongkan untuk Super Admin) --</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                            {{ $org->name }} ({{ $org->code }})
                        </option>
                    @endforeach
                </select>
                @error('organization_id')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>
            {{-- END: Tambahan Field Organisasi --}}

            <div class="mb-4 sm:mb-5">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Password:</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5 sm:mb-6"> {{-- Margin bottom responsif --}}
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Konfirmasi Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500" required>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0"> {{-- Tata letak tombol responsif --}}
                <button type="submit" class="submit-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor"> {{-- Ukuran ikon responsif --}}
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Simpan Admin</span>
                </button>
                <a href="{{ route('users.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 text-sm sm:text-base w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection