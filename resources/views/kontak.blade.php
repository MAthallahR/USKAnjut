<x-layout>
    @section('heading', 'Kontak Kami')

    <div class="space-y-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-1">
                <div class="sticky top-4">
                    <img class="w-full h-auto object-cover rounded-lg shadow-xl" 
                         src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxpFJQ7z4He3kB1eaacXychzv3gQ0KXXUNQG5kHt7MxITLrEigWrTz0gss6yTbfok9xaU&usqp=CAU" 
                         alt="Restaurant or business location image">
                </div>
            </div>

            <div class="md:col-span-2 bg-white shadow overflow-hidden sm:rounded-lg h-fit">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Informasi Kontak
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Kami senang mendengar dari Anda! Silakan hubungi kami melalui salah satu cara di bawah.
                    </p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Jl. Argentina No. 123, Kota Goat, Kode Pos 202</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="mailto:lionelmessi@gmail.com" class="text-blue-600 hover:text-blue-800">lionelmessi@gmail.com</a>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">+62 867 4167 7890</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Jam Operasional</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Senin - Sabtu: 09:00 - 21:00 WIB</dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                Kirim Pesan Langsung
            </h3>

            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('kontak.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama *</label>
                    <div class="mt-1">
                        <input 
                            id="nama" 
                            name="nama" 
                            type="text" 
                            required 
                            value="{{ old('nama') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('nama') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap Anda"
                        >
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <div class="mt-1">
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            value="{{ old('email') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('email') border-red-500 @enderror"
                            placeholder="Masukkan alamat email Anda"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="pesan" class="block text-sm font-medium text-gray-700">Pesan *</label>
                    <div class="mt-1">
                        <textarea 
                            id="pesan" 
                            name="pesan" 
                            rows="4" 
                            required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border @error('pesan') border-red-500 @enderror"
                            placeholder="Tulis pesan Anda di sini..."
                        >{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>

