@extends('layouts.app')

@section('title', 'Detail Barang Inventaris: ' . $inventoryItem->name . ' - ' . config('app.name', 'Laravel'))

@section('content')
    <div x-data="{ showDeleteModal: false, deleteUrl: '', deleteName: '' }"> {{-- Tambahkan x-data untuk modal --}}
        <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100 max-w-3xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Detail Barang: {{ $inventoryItem->name }}</span>
                </h1>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                    <a href="{{ route('inventory_items.edit', $inventoryItem->id) }}" class="submit-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Edit Barang</span>
                    </a>
                    
                    {{-- Tombol Hapus --}}
                    <button
                        type="button"
                        @click="showDeleteModal = true; deleteUrl='{{ route('inventory_items.destroy', $inventoryItem->id) }}'; deleteName='{{ $inventoryItem->name }}'"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-sm sm:text-base w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus Barang</span>
                    </button>

                    <a href="{{ route('inventory_items.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            <div class="space-y-4 sm:space-y-5 text-gray-700">
                <p class="text-base sm:text-lg"><span class="font-semibold">Organisasi:</span> {{ $inventoryItem->organization->name ?? '-' }} ({{ $inventoryItem->organization->code ?? '-' }})</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Nama Barang:</span> {{ $inventoryItem->name }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Kode Barang:</span> {{ $inventoryItem->code ?? '-' }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Kategori:</span> {{ $inventoryItem->category }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Deskripsi:</span> {{ $inventoryItem->description ?? '-' }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Kuantitas:</span> {{ $inventoryItem->quantity }} {{ $inventoryItem->unit }}</p>
                <p class="text-base sm:text-lg">
                    <span class="font-semibold">Kondisi:</span> 
                    @php
                        $conditionClass = '';
                        switch($inventoryItem->condition) {
                            case 'Baik': $conditionClass = 'bg-green-100 text-green-800'; break;
                            case 'Rusak Ringan': $conditionClass = 'bg-yellow-100 text-yellow-800'; break;
                            case 'Rusak Berat': $conditionClass = 'bg-red-100 text-red-800'; break;
                            case 'Perlu Perbaikan': $conditionClass = 'bg-orange-100 text-orange-800'; break;
                            default: $conditionClass = 'bg-gray-100 text-gray-800'; break;
                        }
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $conditionClass }}">
                        {{ $inventoryItem->condition }}
                    </span>
                </p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Lokasi:</span> {{ $inventoryItem->location }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Tanggal Pembelian:</span> {{ $inventoryItem->purchase_date ? $inventoryItem->purchase_date->format('d M Y') : '-' }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Catatan:</span> {{ $inventoryItem->notes ?? '-' }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Dibuat Oleh:</span> {{ $inventoryItem->creator->name ?? 'N/A' }} pada {{ $inventoryItem->created_at->format('d M Y H:i') }}</p>
                <p class="text-base sm:text-lg"><span class="font-semibold">Terakhir Diperbarui Oleh:</span> {{ $inventoryItem->updater->name ?? 'N/A' }} pada {{ $inventoryItem->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        {{-- Modal Konfirmasi Hapus (sama seperti di inventory_items/index.blade.php) --}}
        <div
            x-show="showDeleteModal"
            x-transition.opacity
            class="fixed inset-0 flex items-center justify-center z-50 p-4"
            style="display: none">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showDeleteModal=false"></div>

            <div
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="scale-90 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-90 opacity-0"
                class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto p-6 sm:p-8">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4">Konfirmasi Hapus Barang</h2>
                <p class="text-base sm:text-lg text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus barang
                    <span class="font-semibold text-red-600" x-text="deleteName"></span>?<br>
                    <span class="text-sm text-gray-500">Data ini akan hilang secara permanen.</span>
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal=false" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm sm:text-base">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-md bg-red-500 hover:bg-red-600 text-white text-sm sm:text-base">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div> {{-- Penutup div x-data --}}
@endsection
