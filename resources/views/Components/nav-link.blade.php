@props(['active' => false])

<a class="block rounded-md px-3 py-2 text-base font-medium transition duration-300 ease-in-out 
    {{ $active ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white hover:scale-105' }}"
    aria-current="{{ $active ? 'page' : 'false' }}"
    {{ $attributes }}
>{{ $slot }}</a>