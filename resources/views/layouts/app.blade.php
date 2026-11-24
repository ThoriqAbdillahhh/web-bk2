<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Learning Adventure') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-stone-800">
        @php
            $user = Auth::user();
            $role = $user->roles->first()?->name;
            $displayName = $user->display_name;
            $roleLabel = $role === 'guru' ? 'Guru BK' : \Illuminate\Support\Str::ucfirst($role);
        @endphp

        <div class="min-h-screen bg-stone-50">
            <header class="sticky top-0 z-30 border-b border-stone-200 bg-white print:hidden">
                <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between gap-4">
                        <a href="{{ route('dashboard') }}" class="group flex min-w-0 items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-700 text-sm font-bold text-white">L</span>
                            <span class="truncate text-sm font-bold tracking-tight text-stone-900">Learning Adventure</span>
                        </a>

                        <div class="hidden shrink-0 items-center gap-4 md:flex">
                            <div class="mr-1 border-r border-stone-200 pr-4">
                                <span class="max-w-40">
                                    <span class="block truncate text-xs font-bold text-stone-800">{{ $displayName }}</span>
                                    <span class="mt-0.5 block text-[11px] font-medium text-stone-500">{{ $roleLabel }}</span>
                                </span>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="inline-flex h-9 items-center gap-2 text-xs font-medium text-stone-600 transition-colors hover:text-brand-800">
                                <x-icon name="kunci" class="h-4 w-4 text-stone-400" />
                                <span class="hidden lg:inline">Ganti password</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex h-9 items-center gap-2 text-xs font-medium text-stone-600 transition-colors hover:text-rose-800">
                                    <x-icon name="keluar" class="h-4 w-4" />
                                    Keluar
                                </button>
                            </form>
                        </div>

                        <details class="relative md:hidden">
                            <summary aria-label="Buka menu utama" class="flex h-10 cursor-pointer list-none items-center gap-2 border-l border-stone-200 pl-3 text-sm font-semibold text-stone-700 transition hover:text-brand-800">
                                <x-icon name="menu" class="h-5 w-5 text-stone-500" />
                                <span>Menu</span>
                            </summary>
                            <div class="absolute right-0 top-full mt-1 max-h-[calc(100vh-5rem)] w-[min(24rem,calc(100vw-2rem))] overflow-y-auto border border-stone-200 bg-white p-3 shadow-lg">
                                @include('layouts.navigation-links', ['mode' => 'mobile'])

                                <div class="mt-2 border-t border-stone-200 pt-3">
                                    <div class="mb-2 px-3">
                                        <span class="block truncate text-xs font-semibold text-stone-800">{{ $displayName }}</span>
                                        <span class="mt-0.5 block text-[11px] text-stone-500">{{ $roleLabel }}</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <a href="{{ route('profile.edit') }}" class="inline-flex min-h-10 items-center justify-center gap-2 px-3 text-xs font-medium text-stone-600 transition-colors hover:text-brand-800">
                                            <x-icon name="kunci" class="h-4 w-4 text-stone-400" />
                                            Password
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="inline-flex min-h-10 w-full items-center justify-center gap-2 px-3 text-xs font-medium text-stone-600 transition-colors hover:text-rose-800">
                                                <x-icon name="keluar" class="h-4 w-4" />
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </details>
                    </div>

                    <div class="hidden border-t border-stone-100 md:block">
                        @include('layouts.navigation-links', ['mode' => 'desktop'])
                    </div>
                </div>
            </header>

            <div class="min-w-0">
                @if (isset($header))
                    <section class="border-b border-stone-200 bg-white">
                        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8 sm:py-7">
                            {{ $header }}
                        </div>
                    </section>
                @endif

                <main class="min-h-[calc(100vh-8rem)]">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
