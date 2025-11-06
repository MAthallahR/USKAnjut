<x-layout>
    <x-slot:heading>
        Edit Produk
    </x-slot:heading>

    <div class="max-w-2xl mx-auto">
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Produk</h2>

            <form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk *</label>
                    <input 
                        type="text" 
                        id="nama_produk" 
                        name="nama_produk" 
                        value="{{ old('nama_produk', $produk->nama_produk) }}"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('nama_produk') border-red-500 @enderror"
                    >
                    @error('nama_produk')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori *</label>
                    <select 
                        id="kategori" 
                        name="kategori"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('kategori') border-red-500 @enderror"
                    >
                        <option value="Makanan" {{ old('kategori', $produk->kategori) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Minuman" {{ old('kategori', $produk->kategori) == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp) *</label>
                    <input 
                        type="number" 
                        id="harga" 
                        name="harga" 
                        value="{{ old('harga', $produk->harga) }}"
                        required
                        min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('harga') border-red-500 @enderror"
                    >
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi *</label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        rows="4"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('deskripsi') border-red-500 @enderror"
                    >{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                    
                    <!-- Gambar Saat Ini -->
                    @if($produk->gambar)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama_produk }}" 
                                 class="w-32 h-32 object-cover rounded-lg border"
                                 onerror="this.src='https://via.placeholder.com/150?text=Gambar+Tidak+Ditemukan'">
                            <p class="text-xs text-gray-500 mt-1">Path: {{ $produk->gambar }}</p>
                        </div>
                    @else
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Tidak ada gambar saat ini</p>
                        </div>
                    @endif

                    <input 
                        type="file" 
                        id="gambar" 
                        name="gambar" 
                        accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    >
                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('produk') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition duration-200 font-medium">
                        Batal
                    </a>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 font-medium">
                        Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview image sebelum upload
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hapus preview lama jika ada
                    const oldPreview = document.querySelector('.image-preview');
                    if (oldPreview) {
                        oldPreview.remove();
                    }
                    
                    // Buat preview baru
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'image-preview mb-3';
                    previewDiv.innerHTML = `
                        <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                        <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                    `;
                    
                    // Sisipkan sebelum input file
                    const fileInput = document.getElementById('gambar');
                    fileInput.parentNode.insertBefore(previewDiv, fileInput);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-layout>