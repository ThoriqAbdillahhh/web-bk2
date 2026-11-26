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

        <div class="min-h-screen bg-stone-50 md:flex">
            <aside class="hidden w-64 shrink-0 border-r border-stone-200 bg-white md:sticky md:top-0 md:flex md:h-screen md:flex-col print:hidden">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-6">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M19.2 3.5 14 19l-2.7-6.3L5 10l14.2-6.5Z" fill="currentColor"/>
                            <path d="m11.3 12.7 3.5-3.5" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span class="text-base font-bold leading-tight tracking-tight text-slate-900">Learning<br>Adventure</span>
                </a>

                <p class="px-5 pb-2 pt-1 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">Ruang belajar</p>
                @include('layouts.navigation-links', ['mode' => 'desktop'])

                <div class="mt-auto px-4 pb-4">
                    @if ($role === 'siswa')
                        <a href="{{ route('siswa.guide') }}" class="block rounded-xl bg-emerald-50 p-4 text-emerald-950 transition hover:bg-emerald-100">
                            <x-adventure-icon name="people" class="h-6 w-6 text-emerald-800" />
                            <span class="mt-2 block text-xs font-bold">Butuh teman bercerita?</span>
                            <span class="mt-1 block text-[11px] leading-5 text-emerald-900/80">Guru BK siap mendampingimu.</span>
                            <span class="mt-3 block text-[11px] font-bold text-emerald-800">Lihat petunjuk <span aria-hidden="true">→</span></span>
                        </a>
                    @elseif ($role === 'guru')
                        <a href="{{ route('guru.observations.index') }}" class="block rounded-xl bg-emerald-50 p-4 text-emerald-950 transition hover:bg-emerald-100">
                            <x-adventure-icon name="observe" class="h-6 w-6 text-emerald-800" />
                            <span class="mt-2 block text-xs font-bold">Dampingi dengan empati</span>
                            <span class="mt-1 block text-[11px] leading-5 text-emerald-900/80">Gunakan catatan untuk mendukung proses siswa.</span>
                        </a>
                    @else
                        <a href="{{ route('admin.classrooms.index') }}" class="block rounded-xl bg-emerald-50 p-4 text-emerald-950 transition hover:bg-emerald-100">
                            <x-adventure-icon name="class" class="h-6 w-6 text-emerald-800" />
                            <span class="mt-2 block text-xs font-bold">Kelola ruang belajar</span>
                            <span class="mt-1 block text-[11px] leading-5 text-emerald-900/80">Atur kelas dan akun dalam satu tempat.</span>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="mt-3 border-t border-stone-100 pt-3">
                        @csrf
                        <button type="submit" class="flex min-h-10 w-full items-center gap-3 rounded-lg px-2 text-xs font-medium text-slate-600 transition hover:bg-stone-50 hover:text-brand-700">
                            <x-icon name="keluar" class="h-4 w-4" />
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="sticky top-0 z-30 border-b border-stone-200 bg-white/95 backdrop-blur print:hidden">
                    <div class="mx-auto flex min-h-[3.75rem] max-w-screen-xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex min-w-0 items-center gap-3">
                            <details class="relative md:hidden">
                                <summary aria-label="Buka menu utama" class="flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-lg text-slate-600 hover:bg-stone-100">
                                    <x-icon name="menu" class="h-5 w-5" />
                                </summary>
                                <div class="absolute left-0 top-full z-40 mt-2 max-h-[calc(100vh-5rem)] w-72 overflow-y-auto rounded-xl border border-stone-200 bg-white p-3 shadow-xl">
                                    <p class="px-3 pb-2 pt-1 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">Ruang belajar</p>
                                    @include('layouts.navigation-links', ['mode' => 'mobile'])
                                    <div class="mt-2 border-t border-stone-100 pt-2">
                                        <a href="{{ route('profile.edit') }}" class="flex min-h-10 items-center gap-3 rounded-lg px-3 text-sm text-slate-600 hover:bg-stone-50">
                                            <x-icon name="kunci" class="h-4 w-4" /> Ganti password
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex min-h-10 w-full items-center gap-3 rounded-lg px-3 text-sm text-slate-600 hover:bg-stone-50">
                                                <x-icon name="keluar" class="h-4 w-4" /> Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </details>
                            <p class="truncate text-xs text-slate-500">
                                <a href="{{ route('dashboard') }}" class="hover:text-brand-700">Beranda</a>
                                <span class="mx-1.5 text-stone-300">/</span>
                                <span class="font-semibold text-slate-800">{{ $roleLabel }}</span>
                            </p>
                        </div>

                        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                            <a href="{{ route('profile.edit') }}" class="hidden text-xs font-medium text-slate-500 transition hover:text-brand-700 lg:inline-flex">
                                Ganti password
                            </a>
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-600 text-[11px] font-bold text-white" aria-hidden="true">
                                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($displayName, 0, 1)) }}
                            </span>
                            <span class="hidden min-w-0 sm:block">
                                <span class="block max-w-36 truncate text-xs font-bold text-slate-800">{{ $displayName }}</span>
                                <span class="block text-[10px] text-slate-500">{{ $roleLabel }}</span>
                            </span>
                        </div>
                    </div>
                </header>

                @if (isset($header))
                    <section class="border-b border-stone-200 bg-white">
                        <div class="mx-auto max-w-screen-xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8">
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
