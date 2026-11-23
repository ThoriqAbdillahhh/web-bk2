<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Kelola misi dan tantangan</h1>
                <p class="mt-1 text-sm text-stone-600">Perbarui instruksi, pilihan, dan alasan umpan balik.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
                <a href="{{ route('admin.missions.create') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Tambah misi</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-5 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 p-4 text-sm text-stone-800" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">{{ session('error') }}</div>
        @endif

        @forelse ($missions as $mission)
            <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-brand-800">Misi {{ $mission->sequence }}</span>
                            <x-status-badge :status="$mission->is_active ? 'berfungsi' : 'locked'" :label="$mission->is_active ? 'Aktif' : 'Nonaktif'" />
                        </div>
                        <h2 class="mt-1 text-lg font-bold text-stone-900">{{ $mission->title }}</h2>
                        <p class="mt-2 text-sm leading-6 text-stone-600">{{ $mission->description }}</p>
                        <p class="mt-2 text-xs text-stone-600">Slug: {{ $mission->slug }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.missions.edit', $mission) }}" class="inline-flex items-center rounded-lg border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50">Edit misi</a>
                        <a href="{{ route('admin.challenges.create', $mission) }}" class="inline-flex items-center rounded-lg bg-brand-700 px-3 py-2 text-sm font-semibold text-white hover:bg-brand-800">Tambah tantangan</a>
                        <form method="POST" action="{{ route('admin.missions.destroy', $mission) }}" onsubmit="return confirm('Hapus misi ini? Data misi yang sudah memiliki progres siswa tidak dapat dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-lg border border-rose-300 px-3 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Hapus misi</button>
                        </form>
                    </div>
                </div>

                <div class="mt-5 border-t border-stone-100 pt-4">
                    <h3 class="font-semibold text-stone-800">Tantangan ({{ $mission->challenges->count() }})</h3>
                    @forelse ($mission->challenges as $challenge)
                        <div class="mt-3 rounded-xl border border-stone-200 p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <p class="font-semibold text-stone-900">Tingkat {{ $challenge->level }} · {{ $challenge->title }}</p>
                                    <p class="mt-1 text-sm leading-6 text-stone-600">{{ $challenge->prompt }}</p>
                                    <p class="mt-1 text-xs text-stone-600">{{ $challenge->challenge_type === 'ordering' ? 'Susun urutan' : 'Pilihan' }} · {{ $challenge->options->count() }} pilihan</p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.challenges.edit', [$mission, $challenge]) }}" class="inline-flex items-center rounded-lg border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50">Edit tantangan/pilihan</a>
                                    <form method="POST" action="{{ route('admin.challenges.destroy', [$mission, $challenge]) }}" onsubmit="return confirm('Hapus tantangan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-lg border border-rose-300 px-3 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            @if ($challenge->options->isNotEmpty())
                                <ul class="mt-3 space-y-2 border-t border-stone-100 pt-3">
                                    @foreach ($challenge->options as $option)
                                        <li class="rounded-lg bg-stone-50 p-3 text-sm">
                                            <p class="font-medium text-stone-800">{{ $option->position }}. {{ $option->label }}</p>
                                            <p class="mt-1 text-stone-600">Umpan balik: {{ $option->feedback }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @empty
                        <p class="mt-2 text-sm text-stone-600">Belum ada tantangan.</p>
                    @endforelse
                </div>
            </article>
        @empty
            <section class="rounded-2xl border border-stone-200 bg-white p-8 text-center">
                <h2 class="font-bold text-stone-900">Belum ada misi</h2>
                <p class="mt-2 text-sm text-stone-600">Tambahkan misi atau jalankan seeder misi.</p>
            </section>
        @endforelse

        {{ $missions->links() }}
    </div>
</x-app-layout>
