<!DOCTYPE html>
<html lang="en">
<script src="https://cdn.tailwindcss.com"></script>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tailwind Layout with Carousel</title>
</head>


<body class="bg-gray-100">
    <div class="min-h-full">

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                {{-- Added 'group' class here --}}
                <div class="relative w-full max-w-6xl mx-auto overflow-hidden rounded-lg shadow-lg group">
                    <div id="carousel" class="flex transition-transform duration-700 ease-in-out">
                        
                        {{-- Slide 1: Sate Kambing --}}
                        <div class="w-full flex-shrink-0 relative"> 
                            {{-- Note: We removed group-hover styles here as the main wrapper is the group --}}
                            <img src="https://www.teakpalace.com/image/catalog/artikel/gambar-makanan-paling-enak-sate-kambing.jpg" alt="Sate Kambing" class="w-full h-80 object-cover">
                            
                            {{-- Hover Detail Overlay (using hover, not group-hover) --}}
                            <div class="absolute inset-0 flex items-center justify-center p-6 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white">
                                    <h3 class="text-2xl font-bold mb-2">Sate Kambing (Lamb Satay)</h3>
                                    <p class="text-md sm:text-lg mb-4">Juicy, grilled lamb skewers seasoned with a sweet soy sauce and spices.</p>
                                    <a href="#" class="mt-2 inline-block bg-indigo-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-indigo-600 transition">Lihat Produk</a>
                                </div>
                            </div>
                        </div>

                        {{-- Slide 2: Ayam Goreng --}}
                        <div class="w-full flex-shrink-0 relative">
                            <img src="https://asset.kompas.com/crops/VcgvggZKE2VHqIAUp1pyHFXXYCs=/202x66:1000x599/1200x800/data/photo/2023/05/07/6456a450d2edd.jpg" alt="Ayam Goreng" class="w-full h-80 object-cover">
                            
                            {{-- Hover Detail Overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center p-6 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white">
                                    <h3 class="text-2xl font-bold mb-2">Ayam Goreng (Fried Chicken)</h3>
                                    <p class="text-md sm:text-lg mb-4">The ultimate crispy and savory chicken, marinated in traditional herbs.</p>
                                    <a href="#" class="mt-2 inline-block bg-indigo-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-indigo-600 transition">Lihat Produk</a>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Slide 3: Nasi Goreng --}}
                        <div class="w-full flex-shrink-0 relative">
                            <img src="https://static.sehatq.com/content/image/pd-4-nasgor-2-jan-23.jpg" alt="Nasi Goreng" class="w-full h-80 object-cover">
                            
                            {{-- Hover Detail Overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center p-6 bg-black/50 opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <div class="text-center text-white">
                                    <h3 class="text-2xl font-bold mb-2">Nasi Goreng (Fried Rice)</h3>
                                    <p class="text-md sm:text-lg mb-4">Spicy and flavorful Indonesian fried rice with various toppings.</p>
                                    <a href="#" class="mt-2 inline-block bg-indigo-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-indigo-600 transition">Lihat Produk</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Buttons: Added opacity-0 and group-hover:opacity-100 --}}
                    <button id="prev" class="absolute top-1/2 left-5 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow z-10 transition opacity-0 group-hover:opacity-100">
                        ❮
                    </button>
                    <button id="next" class="absolute top-1/2 right-5 -translate-y-1/2 bg-white/70 hover:bg-white text-gray-800 rounded-full p-2 shadow z-10 transition opacity-0 group-hover:opacity-100">
                        ❯
                    </button>

                    <div class="absolute bottom-3 left-0 right-0 flex justify-center space-x-2 z-10">
                        <button class="dot w-3 h-3 rounded-full bg-white/70"></button>
                        <button class="dot w-3 h-3 rounded-full bg-white/70"></button>
                        <button class="dot w-3 h-3 rounded-full bg-white/70"></button>
                    </div>
                </div>
                </div>
        </main>
    </div>

    <script>
        const carousel = document.getElementById('carousel');
        const dots = document.querySelectorAll('.dot');
        const totalSlides = dots.length;
        let index = 0;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((dot, i) => {
                // Adjusting classes to look better: default is bg-white/70, active is bg-indigo-500
                dot.classList.remove('bg-indigo-500');
                dot.classList.add('bg-white/70');
                if (i === index) {
                    dot.classList.add('bg-indigo-500');
                    dot.classList.remove('bg-white/70');
                }
            });
        }

        document.getElementById('next').addEventListener('click', () => {
            index = (index + 1) % totalSlides;
            updateCarousel();
        });

        document.getElementById('prev').addEventListener('click', () => {
            index = (index - 1 + totalSlides) % totalSlides;
            updateCarousel();
        });

        dots.forEach((dot, i) => {
            dot.addEventListener('click', () => {
                index = i;
                updateCarousel();
            });
        });

        // Auto-slide
        setInterval(() => {
            index = (index + 1) % totalSlides;
            updateCarousel();
        }, 5000);

        updateCarousel();
    </script>
</body>
</html>