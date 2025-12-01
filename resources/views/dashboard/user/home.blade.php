<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Peminjaman') }}
            </h2>
            <a href="{{ route('landing') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                + Pinjam Buku Lain
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="font-bold">Perhatian!</p>
                        <p>{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        Buku Sedang Dipinjam
                    </h3>

                    @if($activeLoans->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($activeLoans as $loan)
                                @php
                                    $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($loan->due_date));
                                @endphp
                                <div class="flex gap-4 p-4 rounded-xl border {{ $isOverdue ? 'border-red-200 bg-red-50' : 'border-gray-200 bg-white' }}">
                                    <div class="shrink-0">
                                        <img src="{{ $loan->book->cover_image ? asset('storage/' . $loan->book->cover_image) : 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&q=80&w=100&h=150' }}" alt="" class="w-16 h-24 object-cover rounded shadow-sm">
                                    </div>
                                    
                                    <div class="flex-1 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-900 line-clamp-1">{{ $loan->book->title }}</h4>
                                            <p class="text-xs text-gray-500 mb-1">{{ $loan->book->author }}</p>
                                            
                                            <div class="flex items-center gap-2 text-sm mb-3">
                                                <span class="text-gray-500 text-xs uppercase">Jatuh Tempo:</span>
                                                <span class="{{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-700 font-medium' }}">
                                                    {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <form action="{{ route('loans.user_return', $loan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin sudah mengembalikan buku ini?');">
                                                @csrf
                                                <button type="submit" class="w-full py-2 px-4 rounded-lg text-xs font-bold text-white transition shadow-md {{ $isOverdue ? 'bg-red-600 hover:bg-red-700' : 'bg-indigo-600 hover:bg-indigo-700' }}">
                                                    {{ $isOverdue ? 'Kembalikan (Telat)' : 'Kembalikan Buku' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                            <p class="text-gray-500 mb-4">Kamu sedang tidak meminjam buku apapun.</p>
                            <a href="{{ route('landing') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Cari Buku Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status Pengembalian</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Buku</th>
                                    <th class="px-6 py-3">Tgl Kembali</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($historyLoans as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $loan->book->title }}</td>
                                        <td class="px-6 py-4">
                                            {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($loan->status == 'return_pending')
                                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                                    Verifikasi Pegawai
                                                </span>
                                            
                                            @elseif($loan->status == 'returned')
                                                
                                                @if($loan->fine_status == 'unpaid')
                                                    <div class="flex flex-col items-start gap-2">
                                                        <span class="text-red-600 font-bold text-xs bg-red-50 px-2 py-1 rounded">
                                                            ⚠️ Denda: Rp {{ number_format($loan->fine_amount) }}
                                                        </span>
                                                        
                                                        @if($loan->payment_proof)
                                                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-200">
                                                                ⏳ Bukti Dikirim (Tunggu Konfirmasi)
                                                            </span>
                                                        @else
                                                            <a href="{{ route('loans.pay', $loan->id) }}" class="inline-block bg-red-600 text-white px-3 py-1.5 rounded text-[10px] font-bold hover:bg-red-700 shadow-sm transition transform hover:scale-105">
                                                                Bayar Sekarang &rarr;
                                                            </a>
                                                        @endif
                                                    </div>

                                                @elseif($loan->fine_status == 'paid')
                                                    <div class="flex flex-col">
                                                        <span class="text-green-700 font-bold text-xs">✅ Selesai</span>
                                                        @if($loan->fine_amount > 0)
                                                            <span class="text-[10px] text-green-600">Denda Lunas</span>
                                                        @endif
                                                    </div>
                                                
                                                @else
                                                    <span class="text-green-700 font-bold text-xs bg-green-50 px-2 py-1 rounded">✅ Tepat Waktu</span>
                                                @endif

                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-400">Belum ada riwayat pengembalian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>