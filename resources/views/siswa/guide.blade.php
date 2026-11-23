<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Petunjuk petualangan</h1>
                <p class="mt-1 text-sm text-stone-600">Kenali alurnya sebelum memulai.</p>
            </div>
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                Kembali ke beranda
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-xl font-bold text-stone-900">{{ $intro['title'] }}</h2>
            <p class="mt-2 leading-7 text-stone-700">{{ $intro['description'] }}</p>
            <p class="mt-4 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm leading-6 text-stone-800">{{ $disclaimer }}</p>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="how-to-title">
            <h2 id="how-to-title" class="text-xl font-bold text-stone-900">Cara bermain</h2>
            <ol class="mt-5 space-y-4">
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-900">1</span>
                    <p class="pt-1 leading-6 text-stone-700">Lihat peta dan mulai dari misi yang terbuka. Misi selanjutnya terbuka setelah langkah sebelumnya selesai.</p>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-900">2</span>
                    <p class="pt-1 leading-6 text-stone-700">Baca skenario dan pilih strategi atau susun langkah sesuai tantangan.</p>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-900">3</span>
                    <p class="pt-1 leading-6 text-stone-700">Baca alasan pada umpan balik. Jika perlu, kamu bisa mencoba tantangan lagi.</p>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-900">4</span>
                    <p class="pt-1 leading-6 text-stone-700">Catatan kemajuan hanya menunjukkan perjalananmu sendiri. Tidak ada peringkat atau perbandingan antar siswa.</p>
                </li>
            </ol>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="missions-title">
            <h2 id="missions-title" class="text-xl font-bold text-stone-900">Lima misi</h2>
            <ol class="mt-4 divide-y divide-stone-100">
                @foreach ($missions as $mission)
                    <li class="py-4 first:pt-0 last:pb-0">
                        <h3 class="font-semibold text-stone-900">{{ $mission->sequence }}. {{ $mission->title }}</h3>
                        <p class="mt-1 text-sm leading-6 text-stone-600">{{ $mission->description }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        <section class="rounded-2xl border border-amber-300 bg-amber-50 p-6 sm:p-8" aria-labelledby="privacy-title">
            <h2 id="privacy-title" class="text-lg font-bold text-amber-950">Tentang privasi refleksi</h2>
            <p class="mt-2 text-sm leading-6 text-amber-950">{{ $privacyNotice }}</p>
        </section>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('siswa.missions.map') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                Buka peta petualangan
            </a>
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                Beranda
            </a>
        </div>
    </div>
</x-app-layout>
