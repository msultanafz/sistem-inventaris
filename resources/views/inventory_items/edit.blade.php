@extends('layouts.app')

@section('title', 'Edit Barang Inventaris: ' . $inventoryItem->name . ' - ' . config('app.name', 'Laravel'))

@section('content')
<div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 max-w-2xl mx-auto">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
            <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Edit Barang: {{ $inventoryItem->name }}</span>
        </h1>
        {{-- Tombol "Kembali" --}}
        <a href="{{ route('inventory_items.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-sm sm:text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <form action="{{ route('inventory_items.update', $inventoryItem->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Gunakan metode PUT/PATCH untuk update --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            {{-- Nama Barang --}}
            <div class="mb-4 md:mb-0">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Nama Barang:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('name') border-red-500 @enderror" value="{{ old('name', $inventoryItem->name) }}" required autofocus>
                @error('name')
                <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kode Barang --}}
            <div class="mb-4 md:mb-0">
                <label for="code" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Kode Barang (Opsional):</label>
                <input type="text" name="code" id="code" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('code') border-red-500 @enderror" value="{{ old('code', $inventoryItem->code) }}">
                @error('code')
                <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Kategori (Dropdown) --}}
        <div class="mb-4 sm:mb-5 mt-4">
            <label for="category" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Kategori:</label>
            <select name="category" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('category') border-red-500 @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{ old('category', $inventoryItem->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            @error('category')
            <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4 sm:mb-5">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Deskripsi (Opsional):</label>
            <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $inventoryItem->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
            {{-- Kuantitas --}}
            <div class="mb-4 md:mb-0">
                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Kuantitas:</label>
                <input type="number" name="quantity" id="quantity" min="1" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('quantity') border-red-500 @enderror" value="{{ old('quantity', $inventoryItem->quantity) }}" required>
                @error('quantity')
                <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Satuan (Dropdown) --}}
            <div class="mb-4 md:mb-0">
                <label for="unit" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Satuan:</label>
                <select name="unit" id="unit" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('unit') border-red-500 @enderror" required>
                    <option value="">Pilih Satuan</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit }}" {{ old('unit', $inventoryItem->unit) == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                    @endforeach
                </select>
                @error('unit')
                <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Kondisi --}}
        <div class="mb-4 sm:mb-5 mt-4">
            <label for="condition" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Kondisi:</label>
            <select name="condition" id="condition" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('condition') border-red-500 @enderror" required>
                <option value="Baik" {{ old('condition', $inventoryItem->condition) == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Rusak Ringan" {{ old('condition', $inventoryItem->condition) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ old('condition', $inventoryItem->condition) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                <option value="Perlu Perbaikan" {{ old('condition', $inventoryItem->condition) == 'Perlu Perbaikan' ? 'selected' : '' }}>Perlu Perbaikan</option>
            </select>
            @error('condition')
            <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lokasi --}}
        <div class="mb-4 sm:mb-5">
            <label for="location" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Lokasi:</label>
            <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('location') border-red-500 @enderror" value="{{ old('location', $inventoryItem->location) }}" required>
            @error('location')
            <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal Pembelian --}}
        <div class="mb-4 sm:mb-5">
            <label for="purchase_date" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Tanggal Pembelian (Opsional):</label>
            <input type="date" name="purchase_date" id="purchase_date" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('purchase_date') border-red-500 @enderror" value="{{ old('purchase_date', $inventoryItem->purchase_date ? $inventoryItem->purchase_date->format('Y-m-d') : '') }}">
            @error('purchase_date')
            <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="mb-5 sm:mb-6">
            <label for="notes" class="block text-gray-700 text-sm font-bold mb-1 sm:mb-2">Catatan (Opsional):</label>
            <textarea name="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 sm:py-3 sm:px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes', $inventoryItem->notes) }}</textarea>
            @error('notes')
            <p class="text-red-500 text-xs italic mt-1 sm:mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between space-y-3 sm:space-y-0">
            <button type="submit" class="submit-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Perbarui Barang</span>
            </button>
            <a href="{{ route('inventory_items.show', $inventoryItem->id) }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 text-sm sm:text-base w-full sm:w-auto">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection