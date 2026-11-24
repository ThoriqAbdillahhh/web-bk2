<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Catatan kemajuan</h1>
                <p class="mt-1 text-sm text-stone-600">Perjalananmu sendiri, bukan penilaian atau peringkat.</p>
            </div>
            <div class="flex flex-wrap gap-2 print:hidden">
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Beranda
                </a>
                <button type="button" onclick="window.print()" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Cetak / Simpan PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8 print:max-w-none print:px-0 print:py-0">
        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm print:shadow-none" aria-label="Informasi siswa">
            <h2 class="text-lg font-bold text-stone-900">{{ $user->display_name }}</h2>
            <p class="mt-1 text-sm text-stone-600">Kelas: {{ $user->classroom?->name ?? 'Belum terdaftar' }}</p>
            <p class="mt-3 text-sm text-stone-700">{{ $completedCount }} dari {{ $totalMissions }} misi selesai.</p>
            <p class="mt-1 text-sm text-stone-600">Tidak ada skor, peringkat, atau perbandingan dengan siswa lain.</p>
        </section>

        @forelse ($missionItems as $item)
            <article class="break-inside-avoid rounded-2xl border border-stone-200 bg-white p-6 shadow-sm print:shadow-none" aria-labelledby="progress-mission-{{ $item['mission']->id }}">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-brand-800">Misi {{ $item['mission']->sequence }}</p>
                        <h2 id="progress-mission-{{ $item['mission']->id }}" class="mt-1 text-lg font-bold text-stone-900">{{ $item['mission']->title }}</h2>
                        <p class="mt-2 text-sm leading-6 text-stone-600">{{ $item['mission']->description }}</p>
                    </div>
                    <x-status-badge :status="$item['status']" />
                </div>

                @if ($item['started_at'])
                    <p class="mt-3 text-sm text-stone-600">Dimulai: {{ $item['started_at']->translatedFormat('d F Y, H:i') }}</p>
                @endif
                @if ($item['completed_at'])
                    <p class="mt-1 text-sm text-stone-600">Selesai: {{ $item['completed_at']->translatedFormat('d F Y, H:i') }}</p>
                @endif

                @if ($item['challenges']->isNotEmpty())
                    <div class="mt-5 border-t border-stone-100 pt-4">
                        <h3 class="font-semibold text-stone-800">Tantangan yang dicoba</h3>
                        <ul class="mt-3 space-y-3">
                            @foreach ($item['challenges'] as $challengeItem)
                                <li class="rounded-xl border border-stone-200 p-4">
                                    <div class="flex flex-wrap items-center justify-between gap-3">
                                        <p class="font-medium text-stone-800">
                                            Tingkat {{ $challengeItem['challenge']->level }}: {{ $challengeItem['challenge']->title }}
                                        </p>
                                        <x-status-badge :status="$challengeItem['completed'] ? 'completed' : ($challengeItem['attempts'] ? 'in_progress' : 'locked')" />
                                    </div>
                                    <p class="mt-1 text-sm text-stone-600">
                                        {{ $challengeItem['attempts'] }} kali dicoba
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($item['reflections']->isNotEmpty())
                    <div class="mt-5 border-t border-stone-100 pt-4">
                        <h3 class="font-semibold text-stone-800">Refleksimu</h3>
                        <div class="mt-3 space-y-4">
                            @foreach ($item['reflections'] as $reflection)
                                <section class="rounded-xl border border-stone-200 p-4">
                                    <p class="text-sm text-stone-600">
                                        {{ $reflection->created_at->translatedFormat('d F Y, H:i') }}
                                        ·
                                        {{ $reflection->is_shared ? 'Dibagikan kepada guru BK' : 'Privat' }}
                                    </p>
                                    <dl class="mt-3 space-y-3 text-sm leading-6">
                                        <div>
                                            <dt class="font-semibold text-stone-800">Yang kupelajari</dt>
                                            <dd class="whitespace-pre-line text-stone-700">{{ $reflection->what_learned }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-semibold text-stone-800">Bagian yang terasa sulit</dt>
                                            <dd class="whitespace-pre-line text-stone-700">{{ $reflection->difficult_part }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-semibold text-stone-800">Langkah berikutnya</dt>
                                            <dd class="whitespace-pre-line text-stone-700">{{ $reflection->next_step }}</dd>
                                        </div>
                                    </dl>

                                    @if ($reflection->feedback->isNotEmpty())
                                        <div class="mt-4 border-t border-stone-100 pt-3">
                                            <h4 class="text-sm font-semibold text-stone-800">Umpan balik guru BK</h4>
                                            @foreach ($reflection->feedback as $feedback)
                                                <p class="mt-2 whitespace-pre-line text-sm leading-6 text-stone-700">{{ $feedback->content }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                </section>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>
        @empty
            <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <h2 class="font-bold text-stone-900">Belum ada catatan kemajuan</h2>
                <p class="mt-2 text-sm leading-6 text-stone-600">Saat kamu mencoba misi, catatan prosesnya akan tampil di sini.</p>
            </section>
        @endforelse
    </div>
</x-app-layout>
