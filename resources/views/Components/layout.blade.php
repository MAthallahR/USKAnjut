<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body::-webkit-scrollbar {
            display: none;
        }
        .my-element::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="">
<div class="min-h-full">
  <nav class="bg-gray-800" x-data="{ mobileMenuOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
            <a href="/welcome" class="flex items-center space-x-2"> 
                <div class="shrink-0">
                    <img src="https://www.svgrepo.com/show/530224/chicken.svg" alt="Your Company" class="size-8" />
                </div>
                <span class="text-xl font-bold text-white tracking-wider">
                    Pak Mes
                </span>
            </a>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <x-nav-link href="/welcome" :active="request()->is('welcome')">Dashboard</x-nav-link>
              <x-nav-link href="/produk" :active="request()->is('produk')">Produk</x-nav-link>
              <x-nav-link href="/comment" :active="request()->is('comment')">Komentar</x-nav-link>
              <x-nav-link href="/kontak" :active="request()->is('kontak')">Kontak</x-nav-link>
            </div>
          </div>
        </div>
        
        @auth
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <div class="relative ml-3" x-data="{ open: false }" @click.outside="open = false">
                <div>
                    <button @click="open = !open" type="button" class="relative flex max-w-xs items-center rounded-full text-white text-sm font-medium hover:text-gray-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        <span class="sr-only">Open user menu</span>
                        <div class="px-3 py-2">
                          {{ auth()->user()->nama ?? 'User' }}
                        </div>
                    </button>
                </div>
              <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                  <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</button>
                  </form>
              </div>
            </div>
          </div>
        </div>
        @else
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <a href="{{ route('login') }}" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">Login</a>
            <a href="{{ route('register') }}" class="text-white hover:text-gray-300 px-3 py-2 text-sm font-medium">Register</a>
          </div>
        </div>
        @endauth

        <div class="-mr-2 flex md:hidden">
          <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500" aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <svg :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="size-6 block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg :class="{ 'hidden': !mobileMenuOpen, 'block': mobileMenuOpen }" class="size-6 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <div class="md:hidden" id="mobile-menu" x-show="mobileMenuOpen" x-transition>
      <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
        <a href="/welcome" class="block rounded-md px-3 py-2 text-base font-medium {{ request()->is('/welcome') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Dashboard</a>
        <a href="/produk" class="block rounded-md px-3 py-2 text-base font-medium {{ request()->is('produk') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Produk</a>
        <a href="/comment" class="block rounded-md px-3 py-2 text-base font-medium {{ request()->is('comment') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Komentar</a>
        <a href="/kontak" class="block rounded-md px-3 py-2 text-base font-medium {{ request()->is('kontak') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Kontak</a>
      </div>
      
      @auth
      <div class="border-t border-white/10 pt-4 pb-3">
        <div class="flex items-center px-5">
          <div class="shrink-0">
            <!-- Anda bisa menambahkan avatar user jika ada -->
            <div class="size-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-bold">
              {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
            </div>
          </div>
          <div class="ml-3">
            <div class="text-base/5 font-medium text-white">{{ auth()->user()->nama }}</div>
            <div class="text-sm font-medium text-gray-400">{{ auth()->user()->email }}</div>
          </div>
        </div>
        <div class="mt-3 space-y-1 px-2">
            <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Sign out</button>
            </form>
        </div>
      </div>
      @else
      <div class="border-t border-white/10 pt-4 pb-3">
        <div class="space-y-1 px-2">
          <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Login</a>
          <a href="{{ route('register') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Register</a>
        </div>
      </div>
      @endauth
    </div>
  </nav>

  @isset($heading)
  <header class="relative bg-white shadow-sm">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $heading }}</h1>
        </div>
  </header> 
  @endisset

  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      {{ $slot }}
    </div>
  </main>
</div>
</body>
</html>