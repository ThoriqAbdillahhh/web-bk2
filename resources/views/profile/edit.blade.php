<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold leading-tight text-stone-900">Ganti password</h1>
            <p class="mt-1 text-sm text-stone-600">Gunakan password yang panjang dan sulit ditebak.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            @include('profile.partials.update-password-form')
        </div>
    </div>
</x-app-layout>
