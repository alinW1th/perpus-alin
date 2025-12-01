<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Waqaf / Donasi Buku</h2>
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 px-4 py-3 rounded-xl">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-1 bg-white p-6 rounded-xl shadow-sm h-fit">
                    <h3 class="font-bold mb-4">Ajukan Donasi Baru</h3>
                    <form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="text-sm font-medium">Judul Buku</label>
                            <input type="text" name="title" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="text-sm font-medium">Penulis</label>
                            <input type="text" name="author" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-sm font-medium">Tahun</label>
                                <input type="number" name="publication_year" class="w-full rounded-md border-gray-300" required>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium">Kategori</label>
                                <select name="category" class="w-full rounded-md border-gray-300" required>
                                    <option value="" disabled selected>Pilih...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium">Cover (Opsional)</label>
                            <input type="file" name="cover_image" class="w-full text-sm">
                        </div>
                        <button class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">Kirim Pengajuan</button>
                    </form>
                </div>

                <div class="col-span-2 bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold mb-4">Riwayat Donasi Saya</h3>
                    <div class="space-y-4">
                        @foreach($donations as $don)
                            <div class="flex items-center justify-between p-4 border rounded-lg">
                                <div>
                                    <p class="font-bold">{{ $don->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $don->author }} ({{ $don->publication_year }})</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $don->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($don->status == 'accepted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($don->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>