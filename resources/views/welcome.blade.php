<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Perpus Alin') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-800">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">Perpus<span class="text-indigo-600">Alin</span></span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-gray-500 hover:text-indigo-600 font-medium transition">Beranda</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600 font-medium transition">Katalog</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600 font-medium transition">Tentang</a>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-gray-900 text-white rounded-full font-medium text-sm hover:bg-gray-800 transition shadow-lg shadow-gray-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium text-sm px-3">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-full font-medium text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative overflow-hidden bg-white">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&q=80&w=2000&h=600')] bg-cover bg-center opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 relative">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold tracking-wider uppercase mb-4">Perpustakaan Digital Kampus</span>
                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6 leading-tight">
                    Jelajahi Dunia <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Lewat Buku</span>
                </h1>
                <p class="text-lg text-gray-500 mb-10 leading-relaxed">
                    Akses ribuan koleksi buku digital dan fisik dengan mudah. Temukan referensi akademik dan bacaan santai dalam satu platform.
                </p>
                
                <form class="max-w-xl mx-auto relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" class="block w-full pl-12 pr-4 py-4 bg-white border border-gray-200 rounded-full text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-xl shadow-gray-100 transition" placeholder="Cari judul buku, penulis, atau kategori...">
                    <button type="button" class="absolute inset-y-1.5 right-1.5 px-6 bg-indigo-600 text-white rounded-full font-medium hover:bg-indigo-700 transition">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="border-y border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-2xl font-bold text-gray-900">5,000+</div>
                    <div class="text-sm text-gray-500">Koleksi Buku</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">1,200+</div>
                    <div class="text-sm text-gray-500">Mahasiswa Aktif</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">24/7</div>
                    <div class="text-sm text-gray-500">Akses Digital</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">Free</div>
                    <div class="text-sm text-gray-500">Peminjaman</div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Buku Populer</h2>
                    <p class="text-gray-500 mt-1">Paling banyak dipinjam minggu ini</p>
                </div>
                <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-800 text-sm flex items-center gap-1">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($latestBooks as $book)
                <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border border-gray-100">
                    <div class="aspect-[2/3] w-full overflow-hidden bg-gray-200 relative">
                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                        
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                        
                        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-md text-xs font-bold text-gray-800 shadow-sm">
                            {{ $book->category }}
                        </span>
                    </div>

                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 line-clamp-1 group-hover:text-indigo-600 transition-colors">
                            <a href="#">{{ $book->title }}</a>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $book->author }}</p>
                        
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-xs font-medium text-gray-400">
                                {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                            </div>
                            <div class="flex items-center text-yellow-400 text-xs font-bold gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                4.8
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">© 2024 PerpusAlin. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>