<x-gate-layout 
    :topics="'Register'" 
    :havent="'Silahkan login!'" 
    :goto="route('login')"
>
    <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="name" placeholder="Lotoeng" 
                class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm" />
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="person@example.com" 
                class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm" />
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <div class="mt-1 relative">
                <input :type="show ? 'text' : 'password'" id="password" name="password" required autocomplete="new-password" placeholder="Enter password"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 pr-10 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm" />
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 3C5 3 1.73 7.11 1.73 10s3.27 7 8.27 7 8.27-4.11 8.27-7-3.27-7-8.27-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                        <path d="M10 7a3 3 0 100 6 3 3 0 000-6z"/>
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ show_confirmation: false }">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <div class="mt-1 relative">
                <input :type="show_confirmation ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 pr-10 text-gray-900 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm" />
                
                <button type="button" @click="show_confirmation = !show_confirmation" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    <svg x-show="!show_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 3C5 3 1.73 7.11 1.73 10s3.27 7 8.27 7 8.27-4.11 8.27-7-3.27-7-8.27-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                        <path d="M10 7a3 3 0 100 6 3 3 0 000-6z"/>
                    </svg>
                    <svg x-show="show_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                    </svg>
                </button>
            </div>
        </div>

        @error('terms')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Daftar
            </button>
        </div>
    </form>
</x-gate-layout>