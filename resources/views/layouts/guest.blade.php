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
    <body class="font-sans text-slate-800 antialiased">
        <main class="relative flex min-h-screen items-center justify-center overflow-hidden bg-stone-50 px-4 py-10 sm:px-6">
            <div class="pointer-events-none absolute -left-20 -top-20 h-72 w-72 rounded-full bg-orange-100/70 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-24 -right-20 h-80 w-80 rounded-full bg-emerald-100/50 blur-3xl" aria-hidden="true"></div>

            <div class="relative w-full max-w-md">
                <a href="{{ route('landing') }}" class="mb-6 flex items-center justify-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-600 text-white">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M19.2 3.5 14 19l-2.7-6.3L5 10l14.2-6.5Z" fill="currentColor"/>
                            <path d="m11.3 12.7 3.5-3.5" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="text-left text-base font-bold leading-tight text-slate-900">Learning<br>Adventure</span>
                </a>

                <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-lg shadow-stone-900/5 sm:p-8">
                    {{ $slot }}
                </section>
                <p class="mt-5 text-center text-[11px] leading-5 text-slate-500">Media pendamping belajar, bukan alat diagnosis atau penilaian akademik.</p>
            </div>
        </main>
    </body>
</html>
