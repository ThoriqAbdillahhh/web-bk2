<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Refleksi yang dibagikan</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-stone-600">Catatan yang dibagikan siswa untuk dibaca dan ditanggapi.</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex shrink-0 items-center gap-2 self-start text-sm font-medium text-stone-600 underline decoration-stone-300 underline-offset-4 transition hover:text-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2 sm:self-auto">
                Kembali ke beranda
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-2 border-l-2 border-brand-400 pl-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="max-w-2xl text-sm leading-6 text-stone-600">Yang terlihat di sini hanya refleksi yang siswa pilih untuk dibagikan. Refleksi privat tetap milik siswa.</p>
            <p class="shrink-0 text-xs font-medium text-stone-500">{{ $reflections->total() }} catatan</p>
        </div>

        <h2 class="border-b border-stone-200 pb-2 text-sm font-semibold text-stone-800">Catatan terbaru</h2>

        @forelse ($reflections as $reflection)
            <article class="border-b border-stone-200 pb-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-semibold text-stone-900">{{ $reflection->user->nickname ?: $reflection->user->name }}</h3>
                        <p class="mt-1 text-xs text-stone-500">
                            {{ $reflection->user->classroom?->name ?? 'Kelas belum terdaftar' }}
                            <span aria-hidden="true">·</span>
                            {{ $reflection->mission->title }}
                            <span aria-hidden="true">·</span>
                            <time datetime="{{ $reflection->created_at->toIso8601String() }}">{{ $reflection->created_at->translatedFormat('d M Y, H:i') }}</time>
                        </p>
                    </div>
                    <div class="pt-0.5">
                        @if ($reflection->feedback_count > 0)
                            <x-status-badge status="completed" label="Sudah diberi umpan balik" />
                        @else
                            <x-status-badge status="available" label="Menunggu umpan balik" />
                        @endif
                    </div>
                </div>

                <p class="mt-4 max-w-3xl text-sm leading-6 text-stone-700">{{ $reflection->what_learned }}</p>
                <a href="{{ route('guru.reflections.show', $reflection) }}" class="mt-3 inline-flex text-sm font-medium text-brand-800 underline decoration-brand-300 underline-offset-4 transition hover:text-brand-900 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Baca dan beri tanggapan
                </a>
            </article>
        @empty
            <section class="border-b border-stone-200 py-8">
                <h3 class="text-sm font-semibold text-stone-900">Belum ada refleksi yang dibagikan</h3>
                <p class="mt-2 max-w-md text-sm leading-6 text-stone-600">Refleksi akan muncul di sini saat siswa memilih untuk membagikannya.</p>
            </section>
        @endforelse

        <div class="pt-1">
            {{ $reflections->links() }}
        </div>
    </div>
</x-app-layout>
