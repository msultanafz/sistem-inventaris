@extends('layouts.app')

@section('title', 'Inventaris Barang - ' . config('app.name', 'Laravel'))

@section('content')
    <div x-data="{ showDeleteModal: false, deleteUrl: '', deleteName: '' }">
        <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Inventaris Barang</span>
                </h1>
                <a href="{{ route('inventory_items.create') }}" class="submit-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Barang</span>
                </a>
            </div>

            {{-- Search and Filter Form --}}
            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                <form action="{{ route('inventory_items.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    {{-- Search by Name --}}
                    <div>
                        <label for="search_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang:</label>
                        <input type="text" name="search_name" id="search_name" 
                               class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ request('search_name') }}" placeholder="Cari nama barang...">
                    </div>

                    {{-- Search by Code --}}
                    <div>
                        <label for="search_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Barang:</label>
                        <input type="text" name="search_code" id="search_code" 
                               class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ request('search_code') }}" placeholder="Cari kode barang...">
                    </div>

                    {{-- Filter by Category --}}
                    <div>
                        <label for="filter_category" class="block text-sm font-medium text-gray-700 mb-1">Kategori:</label>
                        <select name="filter_category" id="filter_category" 
                                class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('filter_category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter by Condition --}}
                    <div>
                        <label for="filter_condition" class="block text-sm font-medium text-gray-700 mb-1">Kondisi:</label>
                        <select name="filter_condition" id="filter_condition" 
                                class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Semua Kondisi</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ request('filter_condition') == $condition ? 'selected' : '' }}>{{ $condition }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search by Location --}}
                    <div>
                        <label for="search_location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi:</label>
                        <input type="text" name="search_location" id="search_location" 
                               class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ request('search_location') }}" placeholder="Cari lokasi...">
                    </div>

                    {{-- Submit and Reset Buttons --}}
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 flex items-end space-x-2 mt-2">
                        <button type="submit" class="cursor-pointer submit-button-gradient text-white font-semibold py-2 px-4 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari & Filter
                        </button>
                        <a href="{{ route('inventory_items.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-4 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            {{-- End Search and Filter Form --}}

            @if($items->isEmpty())
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-6 py-10 sm:px-8 sm:py-12 rounded-xl text-center card-shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 sm:h-16 sm:w-16 mx-auto mb-3 sm:mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-xl sm:text-2xl font-semibold mb-2">Belum Ada Barang Inventaris Terdaftar</h3>
                    <p class="text-base sm:text-lg">Silakan klik tombol "Tambah Barang" di atas untuk menambahkan yang pertama.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-xl card-shadow border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Nama Barang
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Kondisi
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($items as $item)
                            <tr class="group transition-all duration-200 ease-in-out hover:bg-gray-50">
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-sm sm:text-base font-medium text-gray-900">
                                    {{ $item->name }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-xs sm:text-sm text-gray-700">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $item->code ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-xs sm:text-sm text-gray-700">
                                    {{ $item->category }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-sm sm:text-base text-gray-700">
                                    {{ $item->quantity }} {{ $item->unit }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-sm sm:text-base">
                                    @php
                                        $conditionClass = '';
                                        switch($item->condition) {
                                            case 'Baik': $conditionClass = 'bg-green-100 text-green-800'; break;
                                            case 'Rusak Ringan': $conditionClass = 'bg-yellow-100 text-yellow-800'; break;
                                            case 'Rusak Berat': $conditionClass = 'bg-red-100 text-red-800'; break;
                                            case 'Perlu Perbaikan': $conditionClass = 'bg-orange-100 text-orange-800'; break;
                                            default: $conditionClass = 'bg-gray-100 text-gray-800'; break;
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $conditionClass }}">
                                        {{ $item->condition }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 text-xs sm:text-sm text-gray-700 max-w-xs truncate" title="{{ $item->location }}">
                                    {{ Str::limit($item->location, 30, '...') }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2 sm:space-x-3">
                                        <a href="{{ route('inventory_items.show', $item->id) }}" class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventory_items.edit', $item->id) }}" class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button
                                            type="button"
                                            @click="showDeleteModal = true; deleteUrl='{{ route('inventory_items.destroy', $item->id) }}'; deleteName='{{ $item->name }}'"
                                            class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out"
                                            title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $items->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Konfirmasi Hapus --}}
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
    </div>
@endsection
