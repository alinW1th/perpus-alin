<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Buku') }}
        </h2>
    </x-slot>

    @php
        $categories = [
            'Agama', 'Aliran & Gaya Bahasa', 'Arsitektur', 'Barang Antik & Koleksi', 'Bepergian',
            'Berkebun', 'Biografi & Autobiografi', 'Bisnis & Ekonomi', 'Desain', 'Fiksi',
            'Fiksi Anak & Remaja', 'Fiksi Dewasa', 'Fiksi Teenlit', 'Filsafat', 'Fotografi',
            'Game & Aktivitas', 'Hewan Peliharaan', 'Hukum', 'Humor', 'Ilmu Politik',
            'Ilmu Sosial', 'Keluarga & Hubungan', 'Kerajinan & Hobi', 'Kesehatan & Kebugaran',
            'Komik & Novel Grafis', 'Komputer', 'Matematika', 'Medis', 'Musik',
            'Nonfiksi Anak & Remaja', 'Nonfiksi Dewasa', 'Olahraga & Rekreasi', 'Pendidikan',
            'Pengembangan Diri', 'Persiapan Ujian', 'Pertunjukan Seni', 'Psikologi', 'Puisi',
            'Referensi', 'Resep & Masakan', 'Rumah', 'Sains', 'Sejarah', 'Seni',
            'Studi Bahasa Asing', 'Tahu', 'Teknologi & Rekayasa', 'Transportasi', 'Tubuh, Pikiran & Jiwa'
        ];
        sort($categories);
    @endphp

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border border-gray-100">
                
                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-input-label for="title" :value="__('Judul Buku')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $book->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="author" :value="__('Penulis')" />
                            <x-text-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author', $book->author)" required />
                            <x-input-error :messages="$errors->get('author')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="publisher" :value="__('Penerbit')" />
                            <x-text-input id="publisher" class="block mt-1 w-full" type="text" name="publisher" :value="old('publisher', $book->publisher)" required />
                            <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="publication_year" :value="__('Tahun Terbit')" />
                            <x-text-input id="publication_year" class="block mt-1 w-full" type="number" name="publication_year" :value="old('publication_year', $book->publication_year)" required />
                            <x-input-error :messages="$errors->get('publication_year')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="category" :value="__('Kategori')" />
                            <select name="category" id="category" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $book->category) == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="daily_fine" :value="__('Denda Harian (Rp)')" />
                            <x-text-input id="daily_fine" class="block mt-1 w-full" type="number" name="daily_fine" :value="old('daily_fine', $book->daily_fine)" required />
                        </div>
                        <div>
                            <x-input-label for="stock" :value="__('Jumlah Stok')" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $book->stock)" required />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="cover_image" :value="__('Ganti Cover (Opsional)')" />
                        
                        @if($book->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Saat Ini" class="w-20 h-28 object-cover rounded border">
                            </div>
                        @endif

                        <input id="cover_image" type="file" name="cover_image" class="block w-full text-sm text-gray-500 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Sinopsis / Deskripsi')" />
                        <textarea name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $book->description) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">Update Buku</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>