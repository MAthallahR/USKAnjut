<x-layout>
    <x-slot:heading>
        Produk
    </x-slot:heading>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Filter dan Search Bar -->
    <div class="max-w-7xl mx-auto px-4 mb-6">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            
            <div class="flex flex-col sm:flex-row gap-4">
                <form method="GET" action="{{ route('produk') }}" class="flex items-center space-x-2">
                    @if($searchQuery)
                        <input type="hidden" name="search" value="{{ $searchQuery }}">
                    @endif
                    <label for="kategori" class="text-sm font-medium text-gray-700 hidden sm:block">Kategori:</label>
                    <select 
                        name="kategori" 
                        id="kategori"
                        onchange="this.form.submit()"
                        class="block w-40 rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="Semua" {{ ($filterKategori ?? 'Semua') === 'Semua' ? 'selected' : '' }}>Semua Menu</option>
                        <option value="Makanan" {{ ($filterKategori ?? '') === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ ($filterKategori ?? '') === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                </form>

                <form method="GET" action="{{ route('produk') }}" class="flex items-center">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            id="search"
                            value="{{ $searchQuery ?? '' }}"
                            placeholder="Cari menu..."
                            class="block w-64 rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                        >
                        <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hasil Pencarian Info -->
        @if($searchQuery)
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-md p-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <p class="text-blue-800 text-sm">
                            Menampilkan hasil untuk: <span class="font-semibold">"{{ $searchQuery }}"</span>
                        </p>
                    </div>
                    <a href="{{ route('produk') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Hapus pencarian
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Tampilkan berdasarkan filter -->
    @if($makanan->count() > 0 || $minuman->count() > 0)
        @if(($filterKategori ?? 'Semua') === 'Semua' || ($filterKategori ?? '') === '')
            <!-- Tampilkan semua kategori -->
            @if($makanan->count() > 0)
                <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-4 px-4 max-w-7xl mx-auto">Makanan 🍜</h2>
                <div class="flex flex-wrap justify-center gap-6 p-4">
                    @foreach ($makanan as $item)
                    <div class="w-60 shadow-lg rounded-xl bg-white transition-all duration-300 ease-in-out hover:scale-[1.05] overflow-hidden flex flex-col relative">
                        <!-- Tombol Edit/Hapus untuk Admin -->
                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="absolute top-2 right-2 flex space-x-1 z-10">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('produk.edit', $item) }}" 
                                       class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition duration-200 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('produk.destroy', $item) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition duration-200 shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_produk }}" class="object-cover w-full h-40">
                        <div class="p-4 relative flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->nama_produk }}</h3>
                            <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $item->deskripsi }}</p>
                            <span class="absolute bottom-0 right-0 p-1 px-2 rounded-tl-lg text-sm font-bold bg-indigo-600 text-white">
                                Rp {{ number_format($item->harga, 0, ',', '.') }} 
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            @if($minuman->count() > 0)
                @if($makanan->count() > 0)
                    <hr class="my-8 border-t border-gray-200 max-w-7xl mx-auto">
                @endif
                
                <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-4 px-4 max-w-7xl mx-auto">Minuman 🥤</h2>
                <div class="flex flex-wrap justify-center gap-6 p-4">
                    @foreach ($minuman as $item)
                    <div class="w-60 shadow-lg rounded-xl bg-white transition-all duration-300 ease-in-out hover:scale-[1.05] overflow-hidden flex flex-col relative">
                        <!-- Tombol Edit/Hapus untuk Admin -->
                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="absolute top-2 right-2 flex space-x-1 z-10">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('produk.edit', $item) }}" 
                                       class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition duration-200 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('produk.destroy', $item) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition duration-200 shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_produk }}" class="object-cover w-full h-40">
                        <div class="p-4 relative flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->nama_produk }}</h3>
                            <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $item->deskripsi }}</p>
                            <span class="absolute bottom-0 right-0 p-1 px-2 rounded-tl-lg text-sm font-bold bg-indigo-600 text-white">
                                Rp {{ number_format($item->harga, 0, ',', '.') }} 
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        @elseif(($filterKategori ?? '') === 'Makanan' && $makanan->count() > 0)
            <!-- Hanya tampilkan makanan -->
            <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-4 px-4 max-w-7xl mx-auto">Makanan 🍜</h2>
            <div class="flex flex-wrap justify-center gap-6 p-4">
                @foreach ($makanan as $item)
                <div class="w-60 shadow-lg rounded-xl bg-white transition-all duration-300 ease-in-out hover:scale-[1.05] overflow-hidden flex flex-col relative">
                    <!-- Tombol Edit/Hapus untuk Admin -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="absolute top-2 right-2 flex space-x-1 z-10">
                                <a href="{{ route('produk.edit', $item) }}" 
                                   class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition duration-200 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('produk.destroy', $item) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition duration-200 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_produk }}" class="object-cover w-full h-40">
                    <div class="p-4 relative flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->nama_produk }}</h3>
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $item->deskripsi }}</p>
                        <span class="absolute bottom-0 right-0 p-1 px-2 rounded-tl-lg text-sm font-bold bg-indigo-600 text-white">
                            Rp {{ number_format($item->harga, 0, ',', '.') }} 
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

        @elseif(($filterKategori ?? '') === 'Minuman' && $minuman->count() > 0)
            <!-- Hanya tampilkan minuman -->
            <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-4 px-4 max-w-7xl mx-auto">Minuman 🥤</h2>
            <div class="flex flex-wrap justify-center gap-6 p-4">
                @foreach ($minuman as $item)
                <div class="w-60 shadow-lg rounded-xl bg-white transition-all duration-300 ease-in-out hover:scale-[1.05] overflow-hidden flex flex-col relative">
                    <!-- Tombol Edit/Hapus untuk Admin -->
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="absolute top-2 right-2 flex space-x-1 z-10">
                                <a href="{{ route('produk.edit', $item) }}" 
                                   class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition duration-200 shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                
                                <form action="{{ route('produk.destroy', $item) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition duration-200 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_produk }}" class="object-cover w-full h-40">
                    <div class="p-4 relative flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->nama_produk }}</h3>
                        <p class="text-sm text-gray-500 mb-2 line-clamp-2">{{ $item->deskripsi }}</p>
                        <span class="absolute bottom-0 right-0 p-1 px-2 rounded-tl-lg text-sm font-bold bg-indigo-600 text-white">
                            Rp {{ number_format($item->harga, 0, ',', '.') }} 
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    @else
        <!-- Tidak ada produk -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada produk ditemukan</h3>
                <p class="mt-2 text-gray-500">
                    @if($searchQuery)
                        Tidak ada produk yang cocok dengan pencarian "{{ $searchQuery }}"
                    @else
                        Tidak ada produk yang tersedia untuk kategori ini.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('produk') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Lihat Semua Menu
                    </a>
                </div>
            </div>
        </div>
    @endif

</x-layout>