@extends('layouts.app')

@section('title', 'Histori Peminjaman - ' . config('app.name', 'Laravel'))

@section('content')
    <div x-data="{ showDeleteModal: false, deleteUrl: '', deleteItemName: '' }">
        <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Histori Peminjaman</span>
                </h1>
                <a href="{{ route('borrowings.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali ke Daftar Peminjaman</span>
                </a>
            </div>

            {{-- Search Form for History --}}
            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                <form action="{{ route('borrowings.history') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Search by Borrower Name or Item Name --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Peminjam / Barang:</label>
                        <input type="text" name="search" id="search" 
                               class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                               value="{{ request('search') }}" placeholder="Nama Peminjam atau Barang...">
                    </div>

                    {{-- Submit and Reset Buttons --}}
                    <div class="col-span-1 sm:col-span-2 lg:col-span-1 flex items-end space-x-2 mt-2">
                        <button type="submit" class="submit-button-gradient text-white font-semibold py-2.5 px-6 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                        <a href="{{ route('borrowings.history') }}" class="cancel-button-gradient text-white font-semibold py-2.5 px-6 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
            {{-- End Search Form --}}

            @if($borrowings->isEmpty())
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-6 py-10 sm:px-8 sm:py-12 rounded-xl text-center card-shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 sm:h-16 sm:w-16 mx-auto mb-3 sm:mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-xl sm:text-2xl font-semibold mb-2">Belum Ada Histori Peminjaman Barang</h3>
                    <p class="text-base sm:text-lg">Transaksi yang sudah dikembalikan akan muncul di sini.</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-xl card-shadow border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Barang Inventaris
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Peminjam
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Jumlah
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Tgl Peminjaman
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Tgl Pengembalian
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($borrowings as $borrowing)
                            <tr class="group transition-all duration-200 ease-in-out hover:bg-gray-50 bg-green-50"> {{-- Histori selalu hijau --}}
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-sm sm:text-base font-medium text-gray-900">
                                    <a href="{{ route('inventory_items.show', $borrowing->inventoryItem->id) }}" class="text-blue-600 hover:underline">
                                        {{ $borrowing->inventoryItem->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-xs sm:text-sm text-gray-700">
                                    {{ $borrowing->borrower_name }}
                                    @if($borrowing->borrower_nim_nip)
                                        <br><span class="text-gray-500 text-xs">{{ $borrowing->borrower_nim_nip }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-sm sm:text-base text-gray-700">
                                    {{ $borrowing->quantity }} {{ $borrowing->inventoryItem->unit }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-xs sm:text-sm text-gray-700">
                                    {{ $borrowing->borrow_date->format('d M Y') }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-xs sm:text-sm text-gray-700">
                                    {{ $borrowing->return_date ? $borrowing->return_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2 sm:space-x-3">
                                        <a href="{{ route('borrowings.show', $borrowing->id) }}" class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out" title="Lihat Detail Histori">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        {{-- Tidak ada tombol edit/hapus untuk histori --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $borrowings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection