@extends('layouts.app')

@section('title', 'Edit Admin - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 max-w-xl mx-auto"> {{-- Padding responsif, max-w sedikit dikecilkan --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200"> {{-- Tata letak responsif untuk header --}}
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0"> {{-- Ukuran H1 responsif --}}
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Admin: {{ $user->name }}</span>
            </h1>
            {{-- Tombol "Kembali" bisa ditambahkan di sini jika diinginkan, seperti di create.blade.php --}}
            <a href="{{ route('users.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span>
            </a>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4 sm:mb-5"> {{-- Margin bottom responsif --}}
                <label for="name" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Nama:</label> {{-- Margin bottom label responsif --}}
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required autofocus> {{-- Padding input responsif --}}
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p> {{-- Margin top error responsif --}}
                @enderror
            </div>
            <div class="mb-4 sm:mb-5">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Email:</label>
                <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4 sm:mb-5">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Password (isi jika ingin mengubah):</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5 sm:mb-6"> {{-- Margin bottom responsif --}}
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Konfirmasi Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500">
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0"> {{-- Tata letak tombol responsif --}}
                <button type="submit" class="submit-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor"> {{-- Ukuran ikon responsif --}}
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                    <span>Perbarui Admin</span>
                </button>
                <a href="{{ route('users.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 text-sm sm:text-base w-full sm:w-auto"> {{-- Ukuran tombol dan teks responsif, lebar penuh di mobile --}}
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection