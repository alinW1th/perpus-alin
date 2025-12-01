<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl shadow-sm border-l-4 border-yellow-500">{{ session('warning') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        Transaksi Sedang Berjalan
                    </h3>

                    @if($loans->isEmpty())
                        <div class="text-center py-8 text-gray-400">Tidak ada peminjaman aktif.</div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-500">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                    <tr>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Peminjam</th>
                                        <th class="px-6 py-3">Buku</th>
                                        <th class="px-6 py-3">Jatuh Tempo</th>
                                        <th class="px-6 py-3 text-center">Aksi / Kontrol</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($loans as $loan)
                                        @php 
                                            $isOverdue = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($loan->due_date)); 
                                        @endphp
                                        <tr class="hover:bg-gray-50 {{ $loan->status == 'return_pending' ? 'bg-yellow-50' : '' }}">
                                            
                                            <td class="px-6 py-4">
                                                @if($loan->status == 'return_pending')
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded animate-pulse">🔔 Minta Kembali</span>
                                                @elseif($isOverdue)
                                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">⚠️ Terlambat</span>
                                                @else
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">Sedang Dipinjam</span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-900">{{ $loan->user->name }}</div>
                                                <div class="text-xs">{{ $loan->user->nim ?? 'No NIM' }}</div>
                                            </td>

                                            <td class="px-6 py-4">{{ $loan->book->title }}</td>

                                            <td class="px-6 py-4 font-bold {{ $isOverdue ? 'text-red-600' : '' }}">
                                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d M Y') }}
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-3">
                                                    
                                                    <form action="{{ route('manager.return', $loan->id) }}" method="POST" onsubmit="return confirm('Proses pengembalian ini?');">
                                                        @csrf
                                                        @if($loan->status == 'return_pending')
                                                            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-700 shadow-lg whitespace-nowrap">
                                                                ✅ Setujui
                                                            </button>
                                                        @else
                                                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-indigo-700 whitespace-nowrap">
                                                                Terima
                                                            </button>
                                                        @endif
                                                    </form>

                                                    @if(!$isOverdue && $loan->status == 'borrowed')
                                                    <div class="flex flex-col items-start">
                                                        <form action="{{ route('manager.overdue', $loan->id) }}" method="POST" class="flex items-center gap-1 bg-gray-100 p-1 rounded border border-gray-200">
                                                            @csrf
                                                            <input type="number" name="days" value="3" 
                                                                   class="w-16 h-8 text-xs border-gray-300 rounded p-1 text-center focus:ring-red-500 focus:border-red-500" 
                                                                   title="Input Jumlah Hari Telat">
                                                            
                                                            <button type="submit" class="bg-gray-800 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-black transition whitespace-nowrap">
                                                                ⚡ Telatkan
                                                            </button>
                                                        </form>
                                                        <span class="text-[10px] text-gray-400 italic mt-0.5 ml-1">*Demo Only</span>
                                                    </div>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        Verifikasi Denda & Riwayat
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th class="px-6 py-3">Tgl Kembali</th>
                                    <th class="px-6 py-3">Mahasiswa</th>
                                    <th class="px-6 py-3">Buku</th>
                                    <th class="px-6 py-3">Status Denda</th>
                                    <th class="px-6 py-3 text-center">Verifikasi Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($historyLoans as $history)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($history->return_date)->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $history->user->name }}</div>
                                            <div class="text-xs">{{ $history->user->nim ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">{{ $history->book->title }}</td>
                                        
                                        <td class="px-6 py-4">
                                            @if($history->fine_amount > 0)
                                                @if($history->fine_status == 'paid')
                                                    <span class="text-green-600 font-bold bg-green-50 px-2 py-1 rounded">Lunas (Rp {{ number_format($history->fine_amount) }})</span>
                                                @else
                                                    <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">Belum Lunas (Rp {{ number_format($history->fine_amount) }})</span>
                                                @endif
                                            @else
                                                <span class="text-gray-500 italic">Tepat Waktu</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @if($history->payment_proof && $history->fine_status == 'unpaid')
                                                <div class="flex flex-col items-center gap-2">
                                                    <a href="{{ asset('storage/' . $history->payment_proof) }}" target="_blank" class="text-blue-600 underline text-xs font-bold bg-blue-50 px-2 py-1 rounded">
                                                        📄 Lihat Bukti
                                                    </a>
                                                    <form action="{{ route('manager.approve_fine', $history->id) }}" method="POST" onsubmit="return confirm('Bukti valid? Lunaskan denda?');">
                                                        @csrf
                                                        <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-blue-700 shadow-md">
                                                            Verifikasi Lunas
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($history->fine_status == 'paid' && $history->fine_amount > 0)
                                                <span class="text-xs text-gray-400">Terverifikasi</span>
                                            @else
                                                <span class="text-xs text-gray-300">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>