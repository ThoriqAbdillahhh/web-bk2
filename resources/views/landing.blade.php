<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('adventure.intro.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 font-sans text-stone-800 antialiased">
    <main class="mx-auto flex min-h-screen max-w-2xl flex-col justify-center px-6 py-12">
        <p class="text-sm font-semibold text-brand-800">Pendamping belajar</p>
        <h1 class="mt-2 text-4xl font-bold text-stone-900">{{ config('adventure.intro.title') }}</h1>
        <p class="mt-4 leading-7 text-stone-700">{{ config('adventure.intro.description') }}</p>
        <p class="mt-4 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm leading-6">{{ config('adventure.disclaimer') }}</p>
        <a href="{{ route('login') }}" class="mt-8 inline-flex w-fit rounded-xl bg-brand-700 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Mulai</a>
    </main>
</body>
</html>
