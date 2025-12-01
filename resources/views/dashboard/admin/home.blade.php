<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900">Ringkasan Perpustakaan</h3>
                <p class="text-gray-500 text-sm">Klik kartu di bawah untuk melihat detail.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <a href="{{ route('users.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 hover:shadow-md hover:border-indigo-200 transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-100 rounded-full text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium group-hover:text-indigo-600">Total Pengguna</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('books.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 hover:shadow-md hover:border-indigo-200 transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-indigo-100 rounded-full text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium group-hover:text-indigo-600">Koleksi Buku</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalBooks }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('reports.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 hover:shadow-md hover:border-indigo-200 transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600 group-hover:bg-yellow-500 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium group-hover:text-indigo-600">Sedang Dipinjam</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeLoans }}</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.fines') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6 hover:shadow-md hover:border-red-200 transition cursor-pointer">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-red-100 rounded-full text-red-600 group-hover:bg-red-600 group-hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium group-hover:text-red-600">Denda Terkumpul</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalFines) }}</p>
                        </div>
                    </div>
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('books.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">Kelola Buku</h4>
                            <p class="text-gray-500 mt-1">Tambah, edit, atau hapus koleksi buku.</p>
                        </div>
                        <span class="text-gray-300 group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                <a href="{{ route('users.index') }}" class="group block p-6 bg-white border border-gray-200 rounded-xl hover:shadow-lg transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600">Kelola Pengguna</h4>
                            <p class="text-gray-500 mt-1">Manajemen data mahasiswa dan pegawai.</p>
                        </div>
                        <span class="text-gray-300 group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>