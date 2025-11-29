<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validasi Pengembalian Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('warning'))
                <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl font-bold border-l-4 border-yellow-500">
                    {{ session('warning') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Peminjaman Aktif</h3>

                    @if($loans->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            Tidak ada buku yang sedang dipinjam saat ini.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-500">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                    <tr>
                                        <th class="px-6 py-3">Peminjam</th>
                                        <th class="px-6 py-3">Buku</th>
                                        <th class="px-6 py-3">Tgl Pinjam</th>
                                        <th class="px-6 py-3">Jatuh Tempo</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($loans as $loan)
                                        @php
                                            $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($loan->due_date));
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $loan->user->name }}
                                                <div class="text-xs text-gray-400">{{ $loan->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $loan->book->title }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/y') }}
                                            </td>
                                            <td class="px-6 py-4 font-bold {{ $isOverdue ? 'text-red-600' : '' }}">
                                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($isOverdue)
                                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded">
                                                        Terlambat
                                                    </span>
                                                @else
                                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded">
                                                        Aman
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    
                                                    <form action="{{ route('manager.return', $loan->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku ini?');">
                                                        @csrf
                                                        <button type="submit" class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 transition shadow-sm" title="Terima Buku">
                                                            Terima Kembali
                                                        </button>
                                                    </form>

                                                    @if(!$isOverdue)
                                                    <form action="{{ route('manager.overdue', $loan->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-gray-100 text-gray-400 px-2 py-2 rounded-lg text-xs hover:bg-purple-100 hover:text-purple-600 transition" title="[DEMO] Paksa Telat 3 Hari">
                                                            ⚡
                                                        </button>
                                                    </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>