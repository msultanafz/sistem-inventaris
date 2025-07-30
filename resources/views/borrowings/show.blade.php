@extends('layouts.app')

@section('title', 'Detail Peminjaman - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Detail Peminjaman</span>
            </h1>
            {{-- Mengubah href tombol kembali menjadi url()->previous() agar dinamis --}}
            <a href="{{ url()->previous() }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali</span> {{-- Teks tombol lebih umum --}}
            </a>
        </div>

        <div class="space-y-6">
            {{-- Detail Peminjaman --}}
            <div class="p-4 border border-gray-300 rounded-md bg-gray-50">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Informasi Peminjaman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 text-sm sm:text-base">
                    <div>
                        <p class="font-semibold">Barang Inventaris:</p>
                        <p><a href="{{ route('inventory_items.show', $borrowing->inventoryItem->id) }}" class="text-blue-600 hover:underline">{{ $borrowing->inventoryItem->name }} ({{ $borrowing->inventoryItem->code ?? '-' }})</a></p>
                    </div>
                    <div>
                        <p class="font-semibold">Jumlah Dipinjam:</p>
                        <p>{{ $borrowing->quantity }} {{ $borrowing->inventoryItem->unit }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Nama Peminjam:</p>
                        <p>{{ $borrowing->borrower_name }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Kontak Peminjam:</p>
                        <p>{{ $borrowing->borrower_contact ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">NIM / NIP Peminjam:</p>
                        <p>{{ $borrowing->borrower_nim_nip ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Tanggal Peminjaman:</p>
                        <p>{{ $borrowing->borrow_date->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Tanggal Jatuh Tempo:</p>
                        <p>{{ $borrowing->due_date ? $borrowing->due_date->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Status:</p>
                        @php
                            $statusClass = '';
                            switch($borrowing->status) {
                                case 'borrowed': $statusClass = 'bg-blue-100 text-blue-800'; break;
                                case 'returned': $statusClass = 'bg-green-100 text-green-800'; break;
                                case 'overdue': $statusClass = 'bg-red-100 text-red-800'; break;
                                case 'cancelled': $statusClass = 'bg-gray-100 text-gray-800'; break;
                                default: $statusClass = 'bg-gray-100 text-gray-800'; break;
                            }
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </div>
                    <div class="md:col-span-2">
                        <p class="font-semibold">Catatan Peminjaman:</p>
                        <p>{{ $borrowing->notes ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="font-semibold">Dicatat Oleh:</p>
                        <p>{{ $borrowing->borrowedBy->name ?? 'N/A' }} pada {{ $borrowing->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($borrowing->status === 'returned')
                    <div class="md:col-span-2">
                        <p class="font-semibold">Dikembalikan Oleh:</p>
                        <p>{{ $borrowing->returnedBy->name ?? 'N/A' }} pada {{ $borrowing->return_date->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Foto Peminjaman --}}
            @if($borrowing->borrow_photo)
            <div class="p-4 border border-gray-300 rounded-md">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Foto Peminjaman</h2>
                <div class="flex justify-center">
                    <img src="{{ $borrowing->borrow_photo }}" alt="Foto Peminjaman" class="max-w-full h-auto rounded-md shadow-lg max-h-96 object-contain">
                </div>
            </div>
            @endif

            {{-- Foto Pengembalian (jika sudah ada) --}}
            @if($borrowing->return_photo)
            <div class="p-4 border border-gray-300 rounded-md">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Foto Pengembalian</h2>
                <div class="flex justify-center">
                    <img src="{{ $borrowing->return_photo }}" alt="Foto Pengembalian" class="max-w-full h-auto rounded-md shadow-lg max-h-96 object-contain">
                </div>
            </div>
            @endif

            {{-- Tombol Catat Pengembalian (Hanya muncul jika statusnya 'borrowed' atau 'overdue') --}}
            @if(in_array($borrowing->status, ['borrowed', 'overdue']))
            <div class="flex justify-end mt-6">
                <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="submit-button-gradient text-white font-semibold py-2.5 px-6 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Catat Pengembalian</span>
                </a>
            </div>
            @endif
        </div>
    </div>
@endsection