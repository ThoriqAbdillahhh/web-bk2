<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pribadi ID') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#faf9f6] text-stone-800">
        <div x-data="{ open: false }" class="min-h-screen lg:pl-64 print:pl-0">
            @include('layouts.navigation')

            <!-- Top bar (ponsel) -->
            <div class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b border-stone-200 bg-white px-4 lg:hidden print:hidden">
                <button type="button" @click="open = true"
                        class="-ml-1 rounded-md p-2 text-stone-600 hover:bg-stone-100" aria-label="Buka menu">
                    <x-icon name="menu" class="h-6 w-6" />
                </button>
                <span class="font-semibold text-stone-900">Pribadi ID</span>
            </div>

            @isset($header)
                <header class="border-b border-stone-200 bg-white">
                    <div class="px-4 py-5 sm:px-6 lg:px-8">{{ $header }}</div>
                </header>
            @endisset

            <main class="px-4 sm:px-0">{{ $slot }}</main>
        </div>
    </body>
</html>