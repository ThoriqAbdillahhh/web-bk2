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
    <body class="font-sans text-stone-800 antialiased bg-stone-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Logo --}}
            <div>
                <a href="/">
                    <div class="flex items-center gap-2 mb-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-md bg-brand-600 text-lg font-bold text-white">P</span>
                        <span class="text-xl font-bold text-stone-900">Pribadi ID</span>
                    </div>
                </a>
            </div>

            {{-- Kartu Form --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white border border-stone-200 sm:rounded-lg">
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-sm text-stone-500">&copy; {{ date('Y') }} Pribadi ID.</p>
        </div>
    </body>
</html>