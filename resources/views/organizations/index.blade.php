@extends('layouts.app')

@section('title', 'Manajemen Organisasi - ' . config('app.name', 'Laravel'))

@section('content')
    <div x-data="{ showDeleteModal: false, deleteUrl: '', deleteName: '' }">
        <div class="bg-white rounded-xl card-shadow p-6 sm:p-8 border border-gray-100"> {{-- Padding responsif --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 sm:mb-8 pb-4 border-b border-gray-200"> {{-- Tata letak responsif untuk header --}}
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 flex items-center space-x-2 sm:space-x-3 mb-4 sm:mb-0"> {{-- Ukuran H1 responsif --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m8-10h1m-1 4h1m-1 4h1m-8 4v-4l2-2m0 0l2-2m-2 2l-2 2m2-2V7" />
                    </svg>
                    <span>Manajemen Organisasi</span>
                </h1>
                <a href="{{ route('organizations.create') }}" class="submit-button-gradient text-white font-semibold py-2 px-5 sm:py-3 sm:px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2 text-sm sm:text-base"> {{-- Ukuran tombol dan teks responsif --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor"> {{-- Ukuran ikon responsif --}}
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Organisasi</span>
                </a>
            </div>

            @if($organizations->isEmpty())
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-6 py-10 sm:px-8 sm:py-12 rounded-xl text-center card-shadow"> {{-- Padding responsif --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 sm:h-16 sm:w-16 mx-auto mb-3 sm:mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="text-xl sm:text-2xl font-semibold mb-2">Belum Ada Organisasi Terdaftar</h3> {{-- Ukuran H3 responsif --}}
                    <p class="text-base sm:text-lg">Silakan klik tombol "Tambah Organisasi" di atas untuk menambahkan yang pertama.</p> {{-- Ukuran P responsif --}}
                </div>
            @else
                <div class="overflow-x-auto rounded-xl card-shadow border border-gray-100"> {{-- overflow-x-auto untuk tabel di mobile --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider"> {{-- Padding dan teks responsif --}}
                                    Nama Organisasi
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Kode
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-left text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Deskripsi Singkat
                                </th>
                                <th class="px-4 py-3 sm:px-6 sm:py-4 text-center text-xs sm:text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($organizations as $organization)
                            <tr class="group transition-all duration-200 ease-in-out hover:bg-gray-50">
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-sm sm:text-base font-medium text-gray-900"> {{-- Padding dan teks responsif --}}
                                    {{ $organization->name }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-xs sm:text-sm text-gray-700"> {{-- Teks kode sedikit lebih kecil --}}
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"> {{-- Padding dan teks badge responsif --}}
                                        {{ $organization->code }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 text-xs sm:text-sm text-gray-700 max-w-xs truncate" title="{{ $organization->description }}"> {{-- Teks deskripsi sedikit lebih kecil --}}
                                    {{ Str::limit($organization->description, 50, '...') ?? '-' }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 sm:py-5 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2 sm:space-x-3"> {{-- Jarak tombol responsif --}}
                                        
                                        {{-- Tombol "Masuk sebagai Admin" --}}
                                        {{-- Hanya tampilkan jika organisasi ini memiliki setidaknya satu admin --}}
                                        @if($organization->users->whereNotNull('organization_id')->isNotEmpty())
                                            <form action="{{ route('users.impersonate', $organization->users->whereNotNull('organization_id')->first()->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class=" cursor-pointer inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out" title="Masuk sebagai Admin">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Opsional: Tampilkan tombol non-aktif atau pesan jika tidak ada admin --}}
                                            <button type="button" class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-gray-400 cursor-not-allowed" title="Tidak ada Admin untuk login">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                </svg>
                                            </button>
                                        @endif

                                        <a href="{{ route('organizations.show', $organization->id) }}" class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out" title="Lihat Detail"> {{-- Padding tombol responsif --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> {{-- Ukuran ikon responsif --}}
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('organizations.edit', $organization->id) }}" class="inline-flex items-center p-1 sm:p-2 rounded-full text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <button
                                            type="button"
                                            @click="showDeleteModal = true; deleteUrl='{{ route('organizations.destroy', $organization->id) }}'; deleteName='{{ $organization->name }}'"
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
            @endif
        </div>

        {{-- Modal Konfirmasi Hapus --}}
        <div
            x-show="showDeleteModal"
            x-transition.opacity
            class="fixed inset-0 flex items-center justify-center z-50 p-4" {{-- Tambah padding di modal overlay --}}
            style="display: none">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showDeleteModal=false"></div>

            <div
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="scale-90 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-90 opacity-0"
                class="relative bg-white rounded-xl shadow-2xl w-full max-w-md mx-auto p-6 sm:p-8"> {{-- Padding modal responsif --}}
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4">Konfirmasi Hapus</h2> {{-- Ukuran H2 responsif --}}
                <p class="text-base sm:text-lg text-gray-600 mb-6"> {{-- Ukuran P responsif --}}
                    Apakah Anda yakin ingin menghapus organisasi
                    <span class="font-semibold text-red-600" x-text="deleteName"></span>?<br>
                    <span class="text-sm text-gray-500">Data ini akan hilang secara permanen.</span>
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal=false" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm sm:text-base"> {{-- Ukuran tombol responsif --}}
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-md bg-red-500 hover:bg-red-600 text-white text-sm sm:text-base"> {{-- Ukuran tombol responsif --}}
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
@endsection