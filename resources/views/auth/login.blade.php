<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - Inventory Kampus</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')

    <!-- Pastikan Alpine.js dimuat -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Custom CSS untuk gradasi latar belakang */
        body {
            background: linear-gradient(to bottom right, #f0f4f8, #c6d9ee); /* Gradasi biru muda */
        }
        /* Efek bayangan yang lebih halus */
        .shadow-custom-light {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-poppins antialiased min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-md my-auto">
        <div class="bg-white rounded-2xl shadow-custom-light px-6 py-8 sm:px-8 sm:py-10 border border-gray-200">
            <div class="text-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 sm:h-16 sm:w-16 mx-auto text-indigo-600 mb-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Super Admin Login</h2>
                <p class="text-sm sm:text-base text-gray-600 mt-2">Masuk untuk mengelola sistem inventaris.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 px-4 py-3 rounded-lg bg-red-100 text-red-700 text-sm font-medium">
                    <div class="font-bold mb-1">
                        Oops! Terjadi kesalahan:
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input id="email" 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg placeholder-gray-400"
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username" 
                           placeholder="email@kampus.ac.id">
                </div>

                <!-- Password Input with Toggle Visibility -->
                <div class="mb-6" x-data="{ passwordVisible: false }">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <!-- Default type=password untuk fallback -->
                        <input id="password" 
                               type="password"
                               x-bind:type="passwordVisible ? 'text' : 'password'"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg placeholder-gray-400 pr-10"
                               name="password" 
                               required 
                               autocomplete="current-password" 
                               placeholder="••••••••">
                        
                        <!-- Toggle button -->
                        <button type="button" 
                                @click="passwordVisible = !passwordVisible" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <!-- Icon saat password terlihat -->
                            <template x-if="passwordVisible">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7c.563-1.478 1.48-2.835 2.66-4.015m1.414-1.414L10 6.172M13 10a3 3 0 11-6 0 3 3 0 016 0zm6.571-5.757a1 1 0 00-1.414-1.414L3.293 17.293a1 1 0 001.414 1.414L19.571 6.571z" />
                                </svg>
                            </template>
                            <!-- Icon saat password disembunyikan -->
                            <template x-if="!passwordVisible">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                        </button>
                    </div>
                </div>

                <!-- Remember me & forgot password -->
                <div class="flex flex-col sm:flex-row items-center justify-between mb-8 space-y-3 sm:space-y-0">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-indigo-600 hover:text-indigo-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-700 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105 text-base sm:text-lg flex items-center justify-center space-x-2">
                    <span>{{ __('Log in') }}</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
