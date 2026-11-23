<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Peta petualangan</h1>
                <p class="mt-1 text-sm text-stone-600">Jalani misi satu per satu sesuai langkahmu.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Beranda
                </a>
                <a href="{{ route('siswa.guide') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Petunjuk
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <p class="rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm leading-6 text-stone-800">{{ $disclaimer }}</p>

        @forelse ($missionItems as $item)
            <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-7" aria-labelledby="mission-{{ $item['mission']->id }}">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex gap-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-brand-300 bg-brand-50 font-bold text-brand-900" aria-hidden="true">
                            {{ $item['mission']->sequence }}
                        </span>
                        <div>
                            <h2 id="mission-{{ $item['mission']->id }}" class="text-lg font-bold text-stone-900">{{ $item['mission']->title }}</h2>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-stone-600">{{ $item['mission']->description }}</p>
                            <p class="mt-3 text-sm text-stone-700">
                                {{ $item['mission']->challenges_count }} tantangan bertahap
                            </p>
                        </div>
                    </div>
                    <x-status-badge :status="$item['status']" />
                </div>

                @if ($item['status'] === 'locked')
                    <p class="mt-5 rounded-xl border border-stone-300 bg-stone-50 p-4 text-sm leading-6 text-stone-700">
                        Misi ini terbuka setelah kamu menyelesaikan misi sebelumnya.
                    </p>
                @else
                    <a href="{{ route('siswa.missions.show', $item['mission']) }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        {{ $item['status'] === 'completed' ? 'Lihat misi' : ($item['status'] === 'in_progress' ? 'Lanjutkan misi' : 'Mulai misi') }}
                    </a>
                @endif
            </article>
        @empty
            <section class="rounded-2xl border border-stone-200 bg-white p-8 text-center shadow-sm">
                <h2 class="text-lg font-bold text-stone-900">Belum ada misi aktif</h2>
                <p class="mt-2 text-sm text-stone-600">Coba kunjungi lagi nanti atau kembali ke beranda.</p>
                <a href="{{ route('siswa.dashboard') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Beranda
                </a>
            </section>
        @endforelse
    </div>
</x-app-layout>
