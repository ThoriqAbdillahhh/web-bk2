{{-- 1. SIDEBAR DESKTOP (KIRI) --}}
<aside class="hidden border-r border-stone-200 bg-white lg:fixed lg:inset-y-0 lg:left-0 lg:z-30 lg:block lg:w-64 print:hidden">
    @include('layouts.sidebar-content')
</aside>

{{-- 2. MENU GESER PONSEL (DRAWER) --}}
<div x-show="open" x-cloak class="lg:hidden print:hidden" @keydown.escape.window="open = false">
    {{-- Latar belakang gelap (klik untuk tutup) --}}
    <div x-show="open" 
         x-transition.opacity 
         class="fixed inset-0 z-40 bg-stone-900/40" 
         @click="open = false">
    </div>

    {{-- Panel Menu --}}
    <aside x-show="open"
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85%] bg-white shadow-xl">
        
        {{-- Tombol Tutup --}}
        <button type="button" @click="open = false"
                class="absolute right-3 top-3 rounded-md p-2 text-stone-500 hover:bg-stone-100" 
                aria-label="Tutup menu">
            <x-icon name="tutup" class="h-5 w-5" />
        </button>

        {{-- Isi Menu (memanggil file sidebar-content) --}}
        @include('layouts.sidebar-content')
    </aside>
</div>