@extends('layouts.app')

@section('title', 'Catat Pengembalian Peminjaman - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Catat Pengembalian Barang</span>
            </h1>
            <a href="{{ route('borrowings.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar Peminjaman</span>
            </a>
        </div>

        <div class="p-6 border border-gray-300 rounded-xl bg-yellow-50" x-data="returnForm()">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Form Pengembalian</h2>
            <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Informasi Barang --}}
                <div class="p-4 border border-gray-300 rounded-md bg-white">
                    <p class="text-sm font-medium text-gray-700">Barang:</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $borrowing->inventoryItem->name }} ({{ $borrowing->inventoryItem->code ?? '-' }})</p>
                    <p class="text-sm text-gray-600">Peminjam: {{ $borrowing->borrower_name }}</p>
                    <p class="text-sm text-gray-600">Jumlah Dipinjam: {{ $borrowing->quantity }} {{ $borrowing->inventoryItem->unit }}</p>
                    <p class="text-sm text-gray-600">Tanggal Peminjaman: {{ $borrowing->borrow_date->format('d M Y') }}</p>
                    <p class="text-sm text-gray-600">Jatuh Tempo: {{ $borrowing->due_date ? $borrowing->due_date->format('d M Y') : '-' }}</p>
                </div>

                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                    <input type="date" name="return_date" id="return_date" value="{{ old('return_date', date('Y-m-d')) }}"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('return_date') border-red-500 @enderror" required>
                    @error('return_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="return_photo_input" class="block text-sm font-medium text-gray-700 mb-1">Foto Pengembalian <span class="text-red-500">*</span></label> {{-- DIUBAH: Menambahkan (*) --}}
                    <input type="file" id="return_photo_input" accept="image/*" @change="handlePhotoUpload($event, 'return_photo_preview', 'return_photo_data')"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <input type="hidden" name="return_photo" x-model="return_photo_data">
                    <div x-show="return_photo_data" class="mt-4 border border-gray-200 rounded-md p-2 flex items-center justify-center relative">
                        <img :src="return_photo_data" id="return_photo_preview" class="max-w-full h-auto rounded-md max-h-64 object-contain" alt="Preview Foto Pengembalian">
                        <button type="button" @click="return_photo_data = ''; document.getElementById('return_photo_input').value = '';" 
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @error('return_photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Pengembalian (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('notes') border-red-500 @enderror">{{ old('notes', $borrowing->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="submit" class="submit-button-gradient text-white font-semibold py-2.5 px-6 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Catat Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function returnForm() {
            return {
                return_photo_data: '{{ old('return_photo', $borrowing->return_photo) }}',

                handlePhotoUpload(event, previewId, dataProperty) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[dataProperty] = e.target.result; // Set Base64 string to data property
                        };
                        reader.readAsDataURL(file); // Read file as Base64
                    } else {
                        this[dataProperty] = ''; // Clear photo data if no file selected
                    }
                }
            }
        }
    </script>
@endsection