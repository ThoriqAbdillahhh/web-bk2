<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('adventure.intro.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 font-sans text-stone-800 antialiased">
    <main class="mx-auto flex min-h-screen max-w-6xl flex-col justify-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-600 text-white">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M19.2 3.5 14 19l-2.7-6.3L5 10l14.2-6.5Z" fill="currentColor"/>
                    <path d="m11.3 12.7 3.5-3.5" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </span>
            <span class="text-base font-bold leading-tight text-slate-900">Learning<br>Adventure</span>
        </div>
        <section class="relative isolate overflow-hidden rounded-2xl bg-gradient-to-r from-orange-100 via-orange-50 to-[#fff4e8] px-6 py-10 sm:px-10 sm:py-14">
            <div class="relative z-10 max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-700">Pendamping belajar</p>
                <h1 class="mt-3 text-3xl font-bold leading-tight text-slate-900 sm:text-4xl">{{ config('adventure.intro.title') }}</h1>
                <p class="mt-4 max-w-xl leading-7 text-slate-700">{{ config('adventure.intro.description') }}</p>
                <p class="mt-5 max-w-xl rounded-xl border border-white/80 bg-white/70 p-4 text-sm leading-6 text-slate-700">{{ config('adventure.disclaimer') }}</p>
                <a href="{{ route('login') }}" class="mt-7 inline-flex min-h-11 items-center justify-center rounded-lg bg-brand-600 px-6 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Mulai petualangan <span class="ml-2" aria-hidden="true">→</span></a>
            </div>
            <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full border-[36px] border-white/40 sm:right-12 sm:top-10 sm:h-80 sm:w-80" aria-hidden="true"></div>
            <svg class="pointer-events-none absolute -bottom-5 right-0 hidden h-56 w-[42%] max-w-lg sm:block" viewBox="0 0 460 220" fill="none" aria-hidden="true">
                <circle cx="344" cy="50" r="31" fill="#FFE3C5"/>
                <path d="M253 190 288 121l54-12 44 81H253Z" fill="#F9D7B5"/>
                <path d="m287 121 28-29 37 17-10 21-55-9Z" fill="#FFF8F0"/>
                <path d="m342 109 30-22 29 18-17 18-42-14Z" fill="#F4CBA6"/>
                <path d="m289 121 54 11 28 24-89 7-29-12 36-30Z" fill="#FFF8F0"/>
                <path d="m282 163 89-7 32 19-112 13-38-11 29-14Z" fill="#F5D6B8"/>
                <path d="M178 203c30-21 75-16 111-30 30-12 46-31 34-40-8-7-27-4-26-12 1-7 19-7 31-13 13-6 15-15 7-21" stroke="#E8753F" stroke-width="15" stroke-linecap="round"/>
                <path d="M336 88V20" stroke="#39434A" stroke-width="3" stroke-linecap="round"/>
                <path d="M338 21h29l-11 13h-18V21Z" fill="#D95C32"/>
                <path d="M76 190c-9-24-11-40-5-51 8 9 13 22 13 40 4-24 13-37 23-39-1 16-8 30-22 43" fill="#92A883"/>
                <path d="M133 194c-7-22-5-42 5-59 8 16 8 33-1 51 9-22 21-33 33-33-5 17-16 31-34 40" fill="#A4B591"/>
                <path d="M411 192c-4-20 1-37 14-50 4 17 1 32-9 46 12-15 25-22 37-19-9 14-23 23-42 27" fill="#92A883"/>
            </svg>
        </section>
    </main>
</body>
</html>
