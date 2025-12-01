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

    <nav class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2 font-bold text-lg text-gray-600 hover:text-indigo-600 transition group">
                <div class="bg-gray-100 p-2 rounded-lg text-gray-500 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <span>Kembali ke Katalog</span>
            </a>
            
            <div class="flex items-center gap-4">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden sm:block">
                                <div class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] uppercase font-bold tracking-wider text-gray-400">{{ Auth::user()->role }}</div>
                            </div>
                            <div class="relative">
                                <img class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm group-hover:border-indigo-100 transition" 
                                     src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                     alt="{{ Auth::user()->name }}" />
                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
                            </div>
                            <svg class="h-4 w-4 text-gray-400 group-hover:text-indigo-600 transition transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50" style="display: none;">
                             <div class="px-4 py-3 border-b border-gray-50">
                                 <p class="text-sm text-gray-500">Halo,</p>
                                 <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                             </div>
                             <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Dashboard</a>
                             <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Edit Profil</a>
                             <div class="border-t border-gray-50 my-1"></div>
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">Keluar</button>
                             </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition px-4 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="text-sm font-bold bg-indigo-600 text-white px-5 py-2.5 rounded-full hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl flex items-center gap-2 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                {{ session('error') }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-xl flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 bg-white group">
                        <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=600&h=800' }}" 
                             alt="{{ $book->title }}" 
                             class="w-full object-cover transition transform group-hover:scale-105 duration-500">
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
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 mb-4 tracking-wide uppercase">{{ $book->category }}</span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-2">{{ $book->title }}</h1>
                    <p class="text-xl text-gray-500 font-medium">{{ $book->author }}</p>
                    
                    @if($book->reviews->count() > 0)
                        <div class="flex items-center gap-2 mt-3">
                            <div class="flex text-yellow-400 text-sm">
                                <span class="text-gray-900 font-bold text-lg mr-1">{{ $book->average_rating }}</span>
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <span class="text-gray-400 text-sm font-medium">({{ $book->reviews->count() }} Ulasan)</span>
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 mt-8 shadow-inner">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Ketersediaan Stok</p>
                            <p class="text-3xl font-extrabold {{ $book->available_stock > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                {{ $book->available_stock }} <span class="text-lg text-gray-400 font-normal">/ {{ $book->stock }}</span>
                            </p>
                        </div>
                        <div class="w-full sm:w-auto">
                            @auth
                                @if(Auth::user()->role == 'user')
                                    @if($book->available_stock > 0)
                                        <form action="{{ route('loans.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                                <span>Pinjam Buku Ini</span>
                                            </button>
                                        </form>
                                    @else
                                        @php
                                            $isReserved = \App\Models\Reservation::where('user_id', Auth::id())
                                                ->where('book_id', $book->id)->where('status', 'active')->exists();
                                        @endphp
                                        @if($isReserved)
                                            <button disabled class="w-full sm:w-auto px-8 py-4 bg-yellow-100 text-yellow-700 font-bold rounded-xl border border-yellow-200 cursor-not-allowed flex items-center justify-center gap-2">
                                                Dalam Antrian
                                            </button>
                                        @else
                                            <form action="{{ route('reservations.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-1">
                                                    Reservasi (Booking)
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    <div class="px-6 py-4 bg-gray-100 text-gray-500 rounded-xl font-medium text-center border border-gray-200">
                                        Login sebagai <strong>Mahasiswa</strong> untuk meminjam buku.
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full sm:w-auto px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl text-center transition shadow-lg">
                                    Login untuk Meminjam
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="mt-12 border-t border-gray-100 pt-10">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        Ulasan Pembaca
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm rounded-full">{{ $book->reviews->count() }}</span>
                    </h3>

                    @auth
                        @php
                            $hasReturned = \App\Models\Loan::where('user_id', Auth::id())
                                ->where('book_id', $book->id)->where('status', 'returned')->exists();
                            $existingReview = \App\Models\Review::where('user_id', Auth::id())
                                ->where('book_id', $book->id)->first();
                        @endphp

                        @if($hasReturned)
                            <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-6 mb-10 border border-indigo-100 shadow-sm relative overflow-hidden">
                                @if($existingReview)
                                    <div class="absolute top-0 right-0 bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-bl-xl font-bold">Edit Mode</div>
                                @endif
                                <h4 class="font-bold text-indigo-900 mb-4">{{ $existingReview ? 'Ubah Penilaian Anda' : 'Berikan Penilaian' }}</h4>
                                <form action="{{ route('reviews.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <div class="mb-4" x-data="{ 
                                            currentRating: {{ $existingReview ? $existingReview->rating : 0 }},
                                            hoverRating: 0 
                                        }">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Berikan Rating:</label>
                                        
                                        <input type="hidden" name="rating" :value="currentRating" required>

                                        <div class="flex items-center gap-1">
                                            @foreach(range(1, 5) as $star)
                                                <button type="button" 
                                                        @click="currentRating = {{ $star }}" 
                                                        @mouseenter="hoverRating = {{ $star }}" 
                                                        @mouseleave="hoverRating = 0"
                                                        class="focus:outline-none transform transition hover:scale-110 duration-200">
                                                    
                                                    <svg class="w-8 h-8 transition-colors duration-200" 
                                                         :class="(hoverRating || currentRating) >= {{ $star }} ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'"
                                                         viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                    </svg>
                                                </button>
                                            @endforeach
                                            
                                            <span class="ml-3 text-sm font-bold text-indigo-600" x-text="currentRating > 0 ? currentRating + ' Bintang' : 'Pilih Bintang'"></span>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Komentar (Opsional)</label>
                                        <textarea name="comment" rows="3" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ $existingReview ? $existingReview->comment : '' }}</textarea>
                                    </div>
                                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md">
                                        {{ $existingReview ? 'Simpan Perubahan' : 'Kirim Ulasan' }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <div class="space-y-8">
                        @forelse($book->reviews()->with('replies.user')->latest()->get() as $review)
                            <div class="flex gap-4 items-start group" x-data="{ showReply: false }">
                                <div class="shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                                         src="{{ $review->user->profile_photo_path ? asset('storage/' . $review->user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                         alt="{{ $review->user->name }}" />
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-sm text-gray-900">{{ $review->user->name }}</span>
                                        <span class="text-[10px] text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs my-1">
                                        @for($i=0; $i<$review->rating; $i++) ★ @endfor
                                        @for($i=$review->rating; $i<5; $i++) <span class="text-gray-200">★</span> @endfor
                                    </div>
                                    
                                    @if($review->comment)
                                        <p class="text-gray-700 text-sm leading-relaxed mb-1">{{ $review->comment }}</p>
                                    @endif

                                    <div class="flex items-center gap-4 mt-2">
                                        @auth
                                            <button @click="showReply = !showReply" class="text-xs font-bold text-gray-500 hover:text-gray-800 transition cursor-pointer flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                                Balas
                                            </button>

                                            @if(Auth::id() == $review->user_id || in_array(Auth::user()->role, ['admin', 'manager']))
                                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ulasan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-600 transition cursor-pointer flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                        
                                        @if($review->user->role == 'admin')
                                            <span class="text-[10px] bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded font-bold border border-indigo-200">Admin</span>
                                        @elseif($review->user->role == 'manager')
                                            <span class="text-[10px] bg-green-100 text-green-700 px-1.5 py-0.5 rounded font-bold border border-green-200">Petugas</span>
                                        @endif
                                    </div>

                                    <div x-show="showReply" style="display: none;" class="mt-3" x-transition>
                                        <form action="{{ route('reviews.reply', $review->id) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="text" name="body" class="w-full text-xs border-gray-300 rounded-full focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 px-4" placeholder="Tulis balasan..." required>
                                            <button type="submit" class="text-indigo-600 font-bold text-xs hover:underline">Kirim</button>
                                        </form>
                                    </div>

                                    @if($review->replies->count() > 0)
                                        <div class="mt-3 space-y-3 pl-4 border-l-2 border-gray-100">
                                            @foreach($review->replies as $reply)
                                                <div class="flex gap-3 items-start">
                                                    <img class="h-6 w-6 rounded-full object-cover" 
                                                         src="{{ $reply->user->profile_photo_path ? asset('storage/' . $reply->user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) . '&background=random' }}" alt="" />
                                                    <div>
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-bold text-xs text-gray-900">{{ $reply->user->name }}</span>
                                                            <span class="text-[10px] text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-gray-600 text-xs mt-0.5">{{ $reply->body }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-gray-400 italic mb-2">Belum ada ulasan untuk buku ini.</p>
                                <p class="text-sm text-gray-500">Jadilah yang pertama memberikan rating!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>