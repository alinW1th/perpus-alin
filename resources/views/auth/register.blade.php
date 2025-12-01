<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Perpus Alin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white">

    <div class="flex min-h-screen">
        
        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900">
            <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60" 
                 alt="Library Background">
            
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-xl shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-4xl font-bold leading-tight mb-4">Bergabunglah dengan<br>Komunitas Pembaca.</h2>
                <p class="text-lg text-gray-300">Akses ribuan koleksi buku digital dan fisik untuk menunjang studi Anda di Universitas Hasanuddin.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
                
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h1>
                    <p class="text-sm text-gray-500 mt-2">Lengkapi data diri Anda untuk memulai.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                                class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" 
                                placeholder="Nama Lengkap Anda">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM / Stambuk</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.896 1.75-2 2.167a5.002 5.002 0 01-2-2.167" />
                                </svg>
                            </div>
                            <input id="nim" type="text" name="nim" :value="old('nim')" required 
                                class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" 
                                placeholder="H071...">
                        </div>
                        <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required 
                                class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" 
                                placeholder="Email">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div x-data="{ 
                            password: '',
                            patterns: {
                                length: v => v.length >= 8,
                                upper: v => /[A-Z]/.test(v),
                                lower: v => /[a-z]/.test(v),
                                number: v => /[0-9]/.test(v),
                                symbol: v => /[!@#$%^&*(),.?:{}|<>]/.test(v)
                            }
                         }">
                        
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" x-model="password" required autocomplete="new-password"
                                class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" 
                                placeholder="••••••••">
                        </div>

                        <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-100" x-show="password.length > 0" x-transition>
                            <p class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Kualitas Password:</p>
                            <ul class="text-xs space-y-1.5 font-medium">
                                
                                <li class="flex items-center gap-2 transition-colors duration-200" 
                                    :class="patterns.length(password) ? 'text-green-600' : 'text-gray-400'">
                                    <span x-text="patterns.length(password) ? '✅' : '⚪'"></span>
                                    Minimal 8 Karakter
                                </li>

                                <li class="flex items-center gap-2 transition-colors duration-200" 
                                    :class="patterns.upper(password) ? 'text-green-600' : 'text-gray-400'">
                                    <span x-text="patterns.upper(password) ? '✅' : '⚪'"></span>
                                    Huruf Besar (A-Z)
                                </li>

                                <li class="flex items-center gap-2 transition-colors duration-200" 
                                    :class="patterns.lower(password) ? 'text-green-600' : 'text-gray-400'">
                                    <span x-text="patterns.lower(password) ? '✅' : '⚪'"></span>
                                    Huruf Kecil (a-z)
                                </li>

                                <li class="flex items-center gap-2 transition-colors duration-200" 
                                    :class="patterns.number(password) ? 'text-green-600' : 'text-gray-400'">
                                    <span x-text="patterns.number(password) ? '✅' : '⚪'"></span>
                                    Angka (0-9)
                                </li>

                                <li class="flex items-center gap-2 transition-colors duration-200" 
                                    :class="patterns.symbol(password) ? 'text-green-600' : 'text-gray-400'">
                                    <span x-text="patterns.symbol(password) ? '✅' : '⚪'"></span>
                                    Simbol Unik (!@#$%)
                                </li>
                            </ul>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Ulangi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required 
                                class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </button>

                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Sudah punya akun?</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                            Masuk di sini
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>