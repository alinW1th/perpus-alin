<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Validasi Waqaf Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                @if($donations->isEmpty())
                    <p class="text-center text-gray-500">Tidak ada pengajuan donasi baru.</p>
                @else
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="p-3">Mahasiswa</th>
                                <th class="p-3">Detail Buku</th>
                                <th class="p-3">Cover</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $don)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">{{ $don->user->name }}<br><span class="text-xs text-gray-500">{{ $don->user->nim }}</span></td>
                                    <td class="p-3">
                                        <div class="font-bold">{{ $don->title }}</div>
                                        <div>{{ $don->author }} - {{ $don->publication_year }}</div>
                                        <div class="text-xs text-gray-500">{{ $don->category }}</div>
                                    </td>
                                    <td class="p-3">
                                        @if($don->cover_image)
                                            <img src="{{ asset('storage/'.$don->cover_image) }}" class="w-10 h-14 object-cover">
                                        @else - @endif
                                    </td>
                                    <td class="p-3 flex gap-2">
                                        <form action="{{ route('manager.donations.update', $don->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="accepted">
                                            <button class="bg-green-600 text-white px-3 py-1 rounded text-xs">Terima</button>
                                        </form>
                                        <form action="{{ route('manager.donations.update', $don->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>