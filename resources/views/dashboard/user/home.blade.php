<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
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
                                        <img src="{{ $loan->book->cover_image }}" alt="" class="w-16 h-24 object-cover rounded shadow-sm">
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 line-clamp-1">{{ $loan->book->title }}</h4>
                                        <p class="text-sm text-gray-500 mb-2">Dipinjam: {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</p>
                                        
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="font-medium">Batas:</span>
                                            <span class="{{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                            </span>
                                        </div>

                                        @if($isOverdue)
                                            <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Terlambat / Denda Aktif
                                            </div>
                                        @else
                                            <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Sedang Dipinjam
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-4">Kamu sedang tidak meminjam buku apapun.</p>
                            <a href="{{ route('landing') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Cari Buku
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Pengembalian</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Buku</th>
                                    <th class="px-6 py-3">Tgl Pinjam</th>
                                    <th class="px-6 py-3">Tgl Kembali</th>
                                    <th class="px-6 py-3">Status Denda</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($historyLoans as $loan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $loan->book->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($loan->fine_status == 'paid')
                                                <span class="text-green-600 font-bold">Lunas (Rp {{ number_format($loan->fine_amount) }})</span>
                                            @elseif($loan->fine_status == 'unpaid')
                                                <span class="text-red-600 font-bold">Belum Lunas (Rp {{ number_format($loan->fine_amount) }})</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada riwayat peminjaman.</td>
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