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
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition font-bold shadow-md">
                            Tampilkan Laporan
                        </button>
                        <button type="button" onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 transition font-bold shadow-md flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            Cetak PDF
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 print:mb-2">Hasil Laporan</h3>
                    <p class="text-sm text-gray-500 mb-4 print:mb-6">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-100 text-gray-800 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-4 py-3 rounded-tl-lg">Peminjam</th>
                                    <th class="px-4 py-3">Buku</th>
                                    <th class="px-4 py-3 text-center">Tgl Pinjam</th>
                                    <th class="px-4 py-3 text-center">Tgl Kembali</th>
                                    <th class="px-4 py-3 text-center">Status Peminjaman</th>
                                    <th class="px-4 py-3 text-right rounded-tr-lg">Denda (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($loans as $loan)
                                    @php
                                        // --- LOGIKA HITUNG STATUS & DENDA REAL ---
                                        $denda = 0;
                                        $statusHtml = '';

                                        // 1. Jika Sudah Dikembalikan (Data Final)
                                        if ($loan->status == 'returned') {
                                            $denda = $loan->fine_amount;
                                            
                                            if ($denda > 0) {
                                                // Ada Denda -> Selesai (Telat)
                                                $statusHtml = '<span class="font-bold text-gray-800">Selesai <span class="text-red-600">(Telat)</span></span>';
                                            } else {
                                                // Tidak Ada Denda -> Selesai (Tepat Waktu)
                                                $statusHtml = '<span class="font-bold text-gray-800">Selesai <span class="text-green-600">(Tepat Waktu)</span></span>';
                                            }
                                        } 
                                        // 2. Jika Masih Dipinjam (Hitung Realtime)
                                        else {
                                            $jatuhTempo = \Carbon\Carbon::parse($loan->due_date)->startOfDay();
                                            $hariIni = now()->startOfDay();

                                            if ($hariIni->gt($jatuhTempo)) {
                                                // Telat Berjalan -> Hitung Denda
                                                $hariTelat = $hariIni->diffInDays($jatuhTempo) ?: 1;
                                                $tarif = $loan->book->daily_fine > 0 ? $loan->book->daily_fine : 1000;
                                                $denda = $hariTelat * $tarif;

                                                $statusHtml = '<span class="font-bold text-gray-800">Dipinjam <span class="text-red-600 animate-pulse">(Telat ' . $hariTelat . ' Hari)</span></span>';
                                            } else {
                                                $statusHtml = '<span class="font-bold text-gray-800">Dipinjam <span class="text-blue-600">(Aman)</span></span>';
                                            }
                                        }
                                    @endphp

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-gray-900">{{ $loan->user->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $loan->user->nim ?? '-' }}</div>
                                        </td>
                                        
                                        <td class="px-4 py-3">{{ $loan->book->title }}</td>
                                        
                                        <td class="px-4 py-3 text-center">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/y') }}</td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            @if($loan->return_date)
                                                {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            {!! $statusHtml !!}
                                        </td>

                                        <td class="px-4 py-3 text-right font-mono font-bold {{ $denda > 0 ? 'text-red-600' : 'text-gray-400' }}">
                                            Rp {{ number_format($denda, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada data pada periode ini.</td>
                                    </tr>
                                @endforelse


                                 <tr class="bg-gray-50 font-bold text-gray-900 print:bg-gray-100 border-t-2 border-gray-200">
                                    <td colspan="5" class="px-4 py-4 text-right uppercase tracking-wider text-xs">Total Pendapatan Denda (Lunas):</td>
                                    <td class="px-4 py-4 text-right text-lg text-green-700">Rp {{ number_format($totalFines, 0, ',', '.') }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="hidden print:block mt-12 text-right">
                        <p class="text-sm text-gray-500">Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
                        <br><br><br>
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
            .py-12 { position: absolute; left: 0; top: 0; width: 100%; padding: 0; }
            nav, header, button { display: none !important; }
            .shadow-sm, .shadow-xl, .border { box-shadow: none !important; border: none !important; }
        }
    </style>
</x-app-layout>