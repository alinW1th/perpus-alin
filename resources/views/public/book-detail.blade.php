<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} - Perpus Alin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 font-bold text-xl text-gray-900">
                <div class="bg-indigo-600 p-1.5 rounded-lg text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </div>
                Kembali
            </a>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center gap-2">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 bg-white">
                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full object-cover">
                    </div>
                    
                    <div class="mt-6 p-4 bg-white rounded-xl shadow-sm border border-gray-100 text-center lg:hidden">
                        <span class="block text-sm text-gray-500 mb-1">Stok Tersedia</span>
                        <span class="text-2xl font-bold {{ $book->available_stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $book->available_stock }} Buku
                        </span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-8">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 mb-4">
                        {{ $book->category }}
                    </span>
                    <h1 class="text-4xl font-extrabold text-gray-900 leading-tight mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-500 font-medium">{{ $book->author }}</p>
                    
                    @if($book->reviews->count() > 0)
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex text-yellow-400 text-sm">
                                <span class="text-gray-900 font-bold text-lg mr-1">{{ $book->average_rating }}</span>
                                ★
                            </div>
                            <span class="text-gray-400 text-sm">({{ $book->reviews->count() }} Ulasan)</span>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-6 border-y border-gray-100">
                    <div>
                        <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Penerbit</span>
                        <span class="font-semibold text-gray-800">{{ $book->publisher }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Tahun</span>
                        <span class="font-semibold text-gray-800">{{ $book->publication_year }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Maks Pinjam</span>
                        <span class="font-semibold text-gray-800">{{ $book->max_loan_days }} Hari</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Denda/Hari</span>
                        <span class="font-semibold text-red-600">Rp {{ number_format($book->daily_fine, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Sinopsis</h3>
                    <div class="prose text-gray-600 leading-relaxed">
                        {{ $book->description }}
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mt-8">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Ketersediaan Stok</p>
                            <p class="text-2xl font-bold {{ $book->available_stock > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                {{ $book->available_stock }} / {{ $book->stock }}
                            </p>
                        </div>

                        <div class="w-full sm:w-auto">
                            @auth
                                @if(Auth::user()->role == 'user')
                                    @if($book->available_stock > 0)
                                        <form action="{{ route('loans.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                                                Pinjam Buku Sekarang
                                            </button>
                                        </form>
                                    @else
                                        @php
                                            $isReserved = \App\Models\Reservation::where('user_id', Auth::id())
                                                ->where('book_id', $book->id)
                                                ->where('status', 'active')
                                                ->exists();
                                        @endphp

                                        @if($isReserved)
                                            <button disabled class="w-full sm:w-auto px-8 py-3 bg-yellow-100 text-yellow-700 font-bold rounded-xl border border-yellow-200 cursor-not-allowed">
                                                Sudah Direservasi (Menunggu Stok)
                                            </button>
                                        @else
                                            <form action="{{ route('reservations.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl shadow-lg shadow-yellow-200 transition transform hover:-translate-y-1">
                                                    Reservasi Buku Ini
                                                </button>
                                            </form>
                                            <p class="text-xs text-gray-500 mt-2 text-center sm:text-left">Stok habis. Lakukan reservasi untuk masuk antrian.</p>
                                        @endif
                                    @endif
                                @else
                                    <div class="px-6 py-3 bg-gray-200 text-gray-600 rounded-xl font-medium text-center">
                                        Login sebagai Mahasiswa untuk meminjam
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full sm:w-auto px-8 py-3 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl text-center transition">
                                    Login untuk Meminjam
                                </a>
                            @endauth
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 text-center sm:text-left">
                        * Pastikan tidak ada denda tertunggak sebelum meminjam.
                    </p>
                </div>

                <div class="mt-12 border-t border-gray-100 pt-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pembaca ({{ $book->reviews->count() }})</h3>

                    @auth
                        @php
                            $hasBorrowed = \App\Models\Loan::where('user_id', Auth::id())
                                ->where('book_id', $book->id)
                                ->where('status', 'returned')
                                ->exists();
                            
                            $alreadyReviewed = \App\Models\Review::where('user_id', Auth::id())
                                ->where('book_id', $book->id)
                                ->exists();
                        @endphp

                        @if($hasBorrowed && !$alreadyReviewed)
                            <div class="bg-indigo-50 rounded-xl p-6 mb-8 border border-indigo-100">
                                <h4 class="font-bold text-indigo-900 mb-4">Tulis Ulasan Anda</h4>
                                <form action="{{ route('reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-indigo-800 mb-1">Rating</label>
                                        <select name="rating" class="rounded-lg border-indigo-200 focus:ring-indigo-500">
                                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                            <option value="3">⭐⭐⭐ (Cukup)</option>
                                            <option value="2">⭐⭐ (Kurang)</option>
                                            <option value="1">⭐ (Buruk)</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-indigo-800 mb-1">Komentar</label>
                                        <textarea name="comment" rows="3" class="w-full rounded-lg border-indigo-200 focus:ring-indigo-500" placeholder="Bagaimana pendapat Anda tentang buku ini?" required></textarea>
                                    </div>

                                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition">
                                        Kirim Ulasan
                                    </button>
                                </form>
                            </div>
                        @elseif(Auth::user()->role == 'user' && !$hasBorrowed)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-center mb-8">
                                <p class="text-gray-500 text-sm">Anda harus meminjam dan mengembalikan buku ini terlebih dahulu untuk menulis ulasan.</p>
                            </div>
                        @endif
                    @endauth

                    <div class="space-y-6">
                        @forelse($book->reviews()->latest()->get() as $review)
                            <div class="flex gap-4 p-4 rounded-xl hover:bg-gray-50 transition">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600 shrink-0">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-gray-900">{{ $review->user->name }}</span>
                                        <span class="text-xs text-gray-400">• {{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs mb-2">
                                        @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                        @for($i=$review->rating; $i<5; $i++) <span class="text-gray-300">★</span> @endfor
                                    </div>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-400 italic">
                                Belum ada ulasan untuk buku ini. Jadilah yang pertama mengulas!
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>