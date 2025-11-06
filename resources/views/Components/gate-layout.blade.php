<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $topics }}</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-4xl mx-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3">
            
            <!-- Gambar Section -->
            <div class="hidden lg:block relative min-h-[500px]"> <!-- Fixed height -->
                <!-- Gambar dengan Object Fill -->
                <img 
                    src="https://preview.redd.it/que-titulo-le-pondr%C3%ADas-a-la-foto-v0-iqtsqj6qckw91.jpg?width=1080&crop=smart&auto=webp&s=906dd54863f5b0e8f4a4d2a8d9b327be598d4633" 
                    alt="Restaurant Illustration" 
                    class="w-full h-full object-fill" <!-- Object fill untuk stretch -->
                />
                
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/80 to-purple-600/80 flex items-center justify-center">
                    <div class="text-center text-white p-8">
                        <h3 class="text-2xl font-bold mb-3">Pak Mes Restaurant</h3>
                        <p class="text-indigo-100 text-lg">Nikmati pengalaman makan terbaik</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-8 lg:col-span-2">
                <div class="text-center">
                    <img src="https://www.svgrepo.com/show/297252/cutlery-plate.svg" alt="Logo" class="mx-auto h-12 w-auto" />
                    <h2 class="mt-6 text-2xl font-bold text-gray-900">{{ $topics }}</h2>
                    <p class="mt-2 text-sm text-gray-500">Silahkan {{ $topics }}!</p>
                </div>

                {{ $slot }}

                <p class="mt-6 text-center text-sm text-gray-500">
                    {{ $topics === 'Login' ? 'Belum punya akun?' : 'Sudah punya akun?' }}
                    <a href="{{ $goto }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ $havent }}</a>
                </p>
            </div>

        </div>
    </div>
</div>

</body>
</html>