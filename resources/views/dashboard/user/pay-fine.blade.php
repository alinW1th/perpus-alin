<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran Denda</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6">
                
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                    <p class="font-bold text-red-700 text-lg">Total Denda: Rp {{ number_format($loan->fine_amount) }}</p>
                    <p class="text-sm text-red-600">Buku: {{ $loan->book->title }} (Terlambat)</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Metode Pembayaran</h3>
                        
                        <div class="space-y-4 h-96 overflow-y-auto pr-2">
                            <div class="p-4 border rounded-xl bg-gray-50">
                                <p class="font-bold text-blue-800 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 100-4 2 2 0 000 4zm-6 0a2 2 0 100-4 2 2 0 000 4h12v-2a1 1 0 00-1-1h-3l-4 8z"/></svg>
                                    Transfer Bank
                                </p>
                                <ul class="text-sm text-gray-600 mt-2 space-y-2">
                                    <li class="flex justify-between"><span>BRI</span> <span class="font-mono font-bold">1234-5678-9012</span></li>
                                    <li class="flex justify-between"><span>Mandiri</span> <span class="font-mono font-bold">137-00-1234567-8</span></li>
                                </ul>
                            </div>

                            <div class="p-4 border rounded-xl bg-gray-50">
                                <p class="font-bold text-green-700 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    E-Wallet (A.n Perpus Alin)
                                </p>
                                <div class="grid grid-cols-1 gap-2 text-sm text-gray-600 mt-2">
                                    <div class="flex justify-between"><span>GoPay</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                    <div class="flex justify-between"><span>Dana</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                    <div class="flex justify-between"><span>ShopeePay</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                    <div class="flex justify-between"><span>AlloBank</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                    <div class="flex justify-between"><span>Jago</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                    <div class="flex justify-between"><span>i.saku</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                    <div class="flex justify-between"><span>Flip</span> <span class="font-mono font-bold">0878-7411-7883</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-center">
                        <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                            <h3 class="font-bold text-indigo-900 mb-4 text-center">Konfirmasi Pembayaran</h3>
                            <form action="{{ route('loans.store_payment', $loan->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                                    <input type="file" name="payment_proof" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer bg-white rounded-lg border border-gray-300" required>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-1">
                                    Kirim Bukti Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>