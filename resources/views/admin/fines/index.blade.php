<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat & Rekapitulasi Denda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-xl border-l-4 border-red-500 shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Potensi Pendapatan (Belum Bayar)</p>
                        <p class="text-2xl font-extrabold text-red-600 mt-1">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-red-50 rounded-full text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border-l-4 border-green-500 shadow-sm flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Uang Masuk (Lunas)</p>
                        <p class="text-2xl font-extrabold text-green-600 mt-1">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Rincian Data Mahasiswa</h3>

                    @if($fines->isEmpty())
                        <div class="text-center py-10 text-gray-400 bg-gray-50 rounded-lg border-2 border-dashed">
                            Belum ada riwayat denda yang tercatat.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-500">
                                <thead class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 rounded-tl-lg">Mahasiswa</th>
                                        <th class="px-6 py-4">Buku & Tanggal</th>
                                        <th class="px-6 py-4 text-right">Nominal Denda</th> <th class="px-6 py-4 text-center">Status</th>
                                        <th class="px-6 py-4 text-center rounded-tr-lg">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($fines as $fine)
                                        <tr class="hover:bg-gray-50 transition duration-150">
                                            
                                            <td class="px-6 py-4 align-top">
                                                <div class="font-bold text-gray-900 text-base">{{ $fine->user->name }}</div>
                                                <div class="text-xs text-indigo-600 font-mono bg-indigo-50 inline-block px-2 py-0.5 rounded mt-1">
                                                    {{ $fine->user->nim ?? 'NIM KOSONG' }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 align-top">
                                                <div class="text-gray-900 font-medium">{{ $fine->book->title }}</div>
                                                <div class="text-xs text-gray-400 mt-1">
                                                    Kembali: {{ \Carbon\Carbon::parse($fine->return_date)->format('d M Y') }}
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 align-top text-right">
                                                <span class="block text-lg font-extrabold font-mono {{ $fine->fine_status == 'paid' ? 'text-green-600' : 'text-red-600' }}">
                                                    Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 align-top text-center">
                                                @if($fine->fine_status == 'paid')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                        ✅ Lunas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200 animate-pulse">
                                                        ⏳ Belum Bayar
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 align-top text-center">
                                                <form action="{{ route('admin.fines.destroy', $fine->id) }}" method="POST" onsubmit="return confirm('Hapus data ini? (Hanya untuk demo/bersih-bersih)');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-gray-400 hover:text-red-600 transition" title="Hapus Riwayat">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
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