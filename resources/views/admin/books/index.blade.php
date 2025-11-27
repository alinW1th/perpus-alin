<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Buku') }}
            </h2>
            <a href="{{ route('books.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-4">Buku</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Stok</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($books as $book)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center gap-4">
                                    <img src="{{ $book->cover_image }}" alt="" class="w-12 h-16 object-cover rounded shadow-sm bg-gray-200">
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $book->title }}</div>
                                        <div class="text-xs text-gray-400">{{ $book->author }} ({{ $book->publication_year }})</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-indigo-50 text-indigo-600 py-1 px-3 rounded-full text-xs font-bold">
                                        {{ $book->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $book->available_stock }} / {{ $book->stock }}</div>
                                    <div class="text-xs text-gray-400">Tersedia</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>