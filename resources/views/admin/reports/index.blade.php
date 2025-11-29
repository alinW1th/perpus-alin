<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6 print:hidden">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                            Filter Data
                        </button>
                        <button type="button" onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2-4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Cetak Laporan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 print:shadow-none print:border-none">
                <div class="p-6">
                    
                    <div class="hidden print:block text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">PERPUS ALIN</h1>
                        <p class="text-gray-500">Laporan Transaksi Peminjaman</p>
                        <p class="text-sm text-gray-400">Periode: {{ $startDate }} s/d {{ $endDate }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700 print:bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3">Tanggal Pinjam</th>
                                    <th class="px-4 py-3">Peminjam</th>
                                    <th class="px-4 py-3">Buku</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Tgl Kembali</th>
                                    <th class="px-4 py-3 text-right">Denda</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($loans as $loan)
                                    <tr>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $loan->user->name }}</td>
                                        <td class="px-4 py-3">{{ $loan->book->title }}</td>
                                        <td class="px-4 py-3">
                                            @if($loan->status == 'borrowed')
                                                <span class="text-yellow-600 font-bold">Sedang Dipinjam</span>
                                            @else
                                                <span class="text-green-600 font-bold">Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-mono">
                                            {{ $loan->fine_amount > 0 ? 'Rp '.number_format($loan->fine_amount) : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada data pada periode ini.</td>
                                    </tr>
                                @endforelse
                                
                                <tr class="bg-gray-50 font-bold text-gray-900 print:bg-gray-100">
                                    <td colspan="5" class="px-4 py-3 text-right">TOTAL PENDAPATAN DENDA</td>
                                    <td class="px-4 py-3 text-right">Rp {{ number_format($totalFines) }}</td>
                                </div>
                            </tbody>
                        </table>
                    </div>

                    <div class="hidden print:block mt-12 text-right">
                        <p class="text-sm text-gray-500">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
                        <p class="mt-8 font-bold underline">{{ Auth::user()->name }}</p>
                        <p class="text-sm">Administrator</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body * { visibility: hidden; }
            .py-12, .py-12 * { visibility: visible; }
            .py-12 { position: absolute; left: 0; top: 0; width: 100%; }
            nav, header { display: none !important; }
        }
    </style>
</x-app-layout>
