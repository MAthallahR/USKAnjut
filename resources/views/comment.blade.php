<x-layout>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Form Komentar -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Beri Komentar & Rating</h2>
            
            <!-- Cek apakah user sudah login -->
            @auth
            <form action="{{ route('comment.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Notifikasi -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Info User yang Login -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-900">Anda login sebagai:</p>
                            <p class="text-blue-700 capitalize">{{ auth()->user()->nama }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Pilih Produk *
                    </label>
                    <select 
                        id="product_id" 
                        name="product_id"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}" {{ old('product_id') == $produk->id ? 'selected' : '' }}>
                                {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Rating (1 - 5 Bintang) *
                    </label>
                    <div id="ratingStarsContainer" class="flex space-x-1">
                        <!-- Stars will be dynamically injected here -->
                    </div>
                    <input type="hidden" id="rating" name="rating" value="{{ old('rating', 0) }}" required>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="komentar" class="block text-sm font-medium text-gray-700 mb-1">
                        Komentar *
                    </label>
                    <textarea 
                        id="komentar" 
                        name="komentar"
                        rows="4"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tulis komentar Anda tentang produk ini..."
                    >{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium"
                >
                    Kirim Komentar
                </button>
            </form>
            @else
            <!-- Tampilan jika user belum login -->
            <div class="text-center py-8 bg-yellow-50 rounded-lg border border-yellow-200">
                <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-yellow-800">Login Diperlukan</h3>
                <p class="mt-2 text-yellow-600">Anda harus login terlebih dahulu untuk memberikan komentar dan rating.</p>
                <div class="mt-6">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Login Sekarang
                    </a>
                    <a href="{{ route('register') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Daftar Akun
                    </a>
                </div>
            </div>
            @endauth
        </div>

        <!-- Daftar Komentar -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Komentar & Rating Pelanggan</h2>
            
            @if($ulasans->count() > 0)
                <div class="space-y-6">
                    @foreach($ulasans as $ulasan)
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                            {{ strtoupper(substr($ulasan->nama_reviewer, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 capitalize">{{ $ulasan->nama_reviewer }}</h3>
                                        <p class="text-gray-600 text-sm">Review untuk: <span class="font-semibold">{{ $ulasan->produk->nama_produk }}</span></p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $ulasan->created_at->format('d M Y H:i') }}</span>
                            </div>

                            <!-- Rating Stars -->
                            <div class="mb-3">
                                <div class="flex items-center space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-semibold text-gray-700">{{ $ulasan->rating }}/5</span>
                                </div>
                            </div>

                            <!-- Komentar -->
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $ulasan->komentar }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-lg shadow-md">
                    <p class="text-gray-500 text-lg">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
            @endif
        </div>
    </div>

    @auth
    <script>
        // Rating Stars Logic (hanya dijalankan jika user login)
        const ratingContainer = document.getElementById('ratingStarsContainer');
        const ratingInput = document.getElementById('rating');
        let currentRating = {{ old('rating', 0) }};

        // Function to create an SVG star icon
        const createStarIcon = (index) => {
            const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute("viewBox", "0 0 20 20");
            svg.setAttribute("fill", "currentColor");
            svg.classList.add('w-8', 'h-8', 'star-icon', 'cursor-pointer', 'transition-colors');
            svg.dataset.value = index;

            // Star path
            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", "M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z");
            svg.appendChild(path);

            // Click Handler
            svg.addEventListener('click', () => {
                currentRating = index;
                ratingInput.value = index;
                updateStars(currentRating);
            });

            // Hover effects
            svg.addEventListener('mouseenter', () => updateStars(index, true));
            svg.addEventListener('mouseleave', () => updateStars(currentRating));

            return svg;
        };

        // Function to visually update the stars
        const updateStars = (rating, isHover = false) => {
            const stars = ratingContainer.querySelectorAll('.star-icon');
            stars.forEach((star) => {
                const starValue = parseInt(star.dataset.value);
                const isActive = isHover ? starValue <= rating : starValue <= currentRating;
                
                star.classList.toggle('text-yellow-400', isActive);
                star.classList.toggle('text-gray-300', !isActive);
            });
        };

        // Initialize 5 stars
        for (let i = 1; i <= 5; i++) {
            ratingContainer.appendChild(createStarIcon(i));
        }
        updateStars(currentRating); // Initialize with current rating
    </script>

    <style>
        .star-icon {
            transition: color 0.2s ease-in-out;
        }
        .star-icon:hover {
            transform: scale(1.1);
        }
    </style>
    @endauth
</x-layout>