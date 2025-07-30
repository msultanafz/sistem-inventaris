@extends('layouts.app')

@section('title', 'Catat Peminjaman Baru - ' . config('app.name', 'Laravel'))

@section('content')
    <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0">
                <svg class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Catat Peminjaman Baru</span>
            </h1>
            <a href="{{ route('borrowings.index') }}" class="cancel-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar Peminjaman</span>
            </a>
        </div>

        <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6" x-data="borrowingForm()">
            @csrf

            {{-- Inventory Item Selection --}}
            <div class="p-4 border border-gray-300 rounded-md">
                <label for="inventory_item_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Barang Inventaris <span class="text-red-500">*</span></label>
                <select name="inventory_item_id" id="inventory_item_id" x-model="selectedItem" @change="updateItemDetails"
                        class="form-select w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('inventory_item_id') border-red-500 @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($inventoryItems as $item)
                        <option value="{{ $item->id }}" data-quantity="{{ $item->quantity }}" data-unit="{{ $item->unit }}" data-is-borrowed="{{ $item->isBorrowed() ? 'true' : 'false' }}"
                            {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} (Kode: {{ $item->code ?? '-' }}) - Stok: {{ $item->quantity }} {{ $item->unit }}
                            @if($item->isBorrowed()) (Sedang Dipinjam) @endif
                        </option>
                    @endforeach
                </select>
                @error('inventory_item_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p x-show="itemIsBorrowed" class="text-red-600 text-sm mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.3 2.647-1.3 3.412 0l5.464 9.27c.765 1.3-.149 2.93-1.706 2.93H4.493c-1.557 0-2.472-1.63-1.706-2.93l5.464-9.27zM10 11a1 1 0 100-2 1 1 0 000 2zm1-4a1 1 0 10-2 0v4a1 1 0 102 0V7z" clip-rule="evenodd" />
                    </svg>
                    Perhatian: Barang ini sedang dipinjam. Jika kuantitasnya 1, tidak dapat dipinjam lagi.
                </p>
            </div>

            {{-- Item Details Display (for user information) --}}
            <div x-show="selectedItem" class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800 flex items-center">
                <p><strong>Stok Tersedia:</strong> <span x-text="itemQuantity"></span> <span x-text="itemUnit"></span></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Borrower Details --}}
                <div class="p-4 border border-gray-300 rounded-md">
                    <label for="borrower_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Peminjam <span class="text-red-500">*</span></label>
                    <input type="text" name="borrower_name" id="borrower_name" value="{{ old('borrower_name') }}"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('borrower_name') border-red-500 @enderror" required>
                    @error('borrower_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 border border-gray-300 rounded-md">
                    <label for="borrower_contact" class="block text-sm font-medium text-gray-700 mb-1">Kontak Peminjam (Email/No. HP)</label>
                    <input type="text" name="borrower_contact" id="borrower_contact" value="{{ old('borrower_contact') }}"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('borrower_contact') border-red-500 @enderror">
                    @error('borrower_contact')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 border border-gray-300 rounded-md">
                    <label for="borrower_nim_nip" class="block text-sm font-medium text-gray-700 mb-1">NIM / NIP Peminjam</label>
                    <input type="text" name="borrower_nim_nip" id="borrower_nim_nip" value="{{ old('borrower_nim_nip') }}"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('borrower_nim_nip') border-red-500 @enderror">
                    @error('borrower_nim_nip')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div class="p-4 border border-gray-300 rounded-md">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Dipinjam <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" id="quantity" x-model.number="borrowQuantity" min="1" :max="itemQuantity"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('quantity') border-red-500 @enderror" required>
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p x-show="borrowQuantity > itemQuantity" class="text-red-600 text-xs mt-1">Jumlah pinjam tidak boleh melebihi stok tersedia.</p>
                </div>

                {{-- Borrow Date --}}
                <div class="p-4 border border-gray-300 rounded-md">
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Peminjaman <span class="text-red-500">*</span></label>
                    <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('borrow_date') border-red-500 @enderror" required>
                    @error('borrow_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Due Date --}}
                <div class="p-4 border border-gray-300 rounded-md">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo (Opsional)</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                           class="form-input w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div> {{-- End of grid --}}

            {{-- Borrow Photo (Full Width) --}}
            <div class="p-4 border border-gray-300 rounded-md">
                <label for="borrow_photo_input" class="block text-sm font-medium text-gray-700 mb-1">Foto Peminjaman <span class="text-red-500">*</span></label> {{-- DIUBAH: Menambahkan (*) --}}
                <input type="file" id="borrow_photo_input" accept="image/*" @change="handlePhotoUpload($event, 'borrow_photo_preview', 'borrow_photo_data')"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <input type="hidden" name="borrow_photo" x-model="borrow_photo_data">
                <div x-show="borrow_photo_data" class="mt-4 border border-gray-200 rounded-md p-2 flex items-center justify-center relative">
                    <img :src="borrow_photo_data" id="borrow_photo_preview" class="max-w-full h-auto rounded-md max-h-64 object-contain" alt="Preview Foto Peminjaman">
                    <button type="button" @click="borrow_photo_data = ''; document.getElementById('borrow_photo_input').value = '';" 
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @error('borrow_photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Notes (Full Width) --}}
            <div class="p-4 border border-gray-300 rounded-md">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                          class="form-textarea w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button type="submit" class="submit-button-gradient text-white font-semibold py-2.5 px-6 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Catat Peminjaman
                </button>
            </div>
        </form>
    </div>

    <script>
        function borrowingForm() {
            return {
                selectedItem: '{{ old('inventory_item_id') }}', // Keep old value on validation error
                itemQuantity: 0,
                itemUnit: '',
                itemIsBorrowed: false,
                borrowQuantity: {{ old('quantity', 1) }}, // Default quantity to 1
                borrow_photo_data: '{{ old('borrow_photo') }}',

                init() {
                    // Initialize item details if an item was previously selected (e.g., on validation error)
                    this.updateItemDetails();
                },

                updateItemDetails() {
                    const selectElement = document.getElementById('inventory_item_id');
                    const selectedOption = selectElement.options[selectElement.selectedIndex];

                    if (selectedOption && selectedOption.value) {
                        this.itemQuantity = parseInt(selectedOption.dataset.quantity);
                        this.itemUnit = selectedOption.dataset.unit;
                        this.itemIsBorrowed = selectedOption.dataset.isBorrowed === 'true';
                        // Ensure borrowQuantity doesn't exceed itemQuantity if item is changed
                        if (this.borrowQuantity > this.itemQuantity) {
                            this.borrowQuantity = this.itemQuantity;
                        }
                    } else {
                        this.itemQuantity = 0;
                        this.itemUnit = '';
                        this.itemIsBorrowed = false;
                        this.borrowQuantity = 1; // Reset quantity if no item selected
                    }
                },

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