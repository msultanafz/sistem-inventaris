@extends('layouts.app')

@section('title', 'Manajemen Admin - ' . config('app.name', 'Laravel'))

@section('content')
    <div
        class="flex-1 p-8 bg-gray-50"
        x-data="{ showDeleteModal: false, deleteUrl: '', deleteName: '' }"> {{-- x-data dipindahkan ke sini untuk konsistensi --}}
        <div class="bg-white rounded-xl card-shadow p-8 border border-gray-100">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                <h1 class="text-4xl font-extrabold text-gray-800 flex items-center space-x-3">
                    <svg class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H2C3.518 15.363 8.368 12 14 12h3.356m7.138 0a.75.75 0 000 1.5H21a.75.75 0 000-1.5h-.862zm-.862-3.75h-.01M21 12v3.75h2.25V12h-2.25z" />
                    </svg>
                    <span>Manajemen Admin</span>
                </h1>
                <a href="{{ route('users.create') }}" class="submit-button-gradient text-white font-semibold py-3 px-7 rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Admin Baru</span>
                </a>
            </div>

            @if($users->isEmpty())
            <div class="bg-blue-50 border border-blue-200 text-blue-800 px-8 py-12 rounded-xl text-center card-shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-2xl font-semibold mb-2">Belum Ada Admin Terdaftar</h3>
                <p class="text-lg">Silakan klik tombol "Tambah Admin Baru" di atas untuk menambahkan yang pertama.</p>
            </div>
            @else
            <div class="overflow-hidden rounded-xl card-shadow border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                Nama
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-800 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($users as $user)
                        <tr class="group transition-all duration-200 ease-in-out hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-900">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-3">
                                    {{-- Tidak ada tombol 'view' untuk admin, langsung edit/hapus --}}
                                    <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center p-2 rounded-full text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <button
                                        type="button"
                                        @click="showDeleteModal = true; deleteUrl='{{ route('users.destroy', $user->id) }}'; deleteName='{{ $user->name }}'"
                                        class="inline-flex items-center p-2 rounded-full text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out"
                                        title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

        <div
            x-show="showDeleteModal"
            x-transition.opacity
            class="fixed inset-0 flex items-center justify-center z-50"
            style="display: none">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showDeleteModal=false"></div>

            <div
                x-transition:enter="transform transition ease-out duration-300"
                x-transition:enter-start="scale-90 opacity-0"
                x-transition:enter-end="scale-100 opacity-100"
                x-transition:leave="transform transition ease-in duration-200"
                x-transition:leave-start="scale-100 opacity-100"
                x-transition:leave-end="scale-90 opacity-0"
                class="relative bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Konfirmasi Hapus</h2>
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus admin
                    <span class="font-semibold text-red-600" x-text="deleteName"></span>?<br>
                    <span class="text-sm text-gray-500">Data ini akan hilang secara permanen.</span>
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal=false" class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-md bg-red-500 hover:bg-red-600 text-white">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
@endsection