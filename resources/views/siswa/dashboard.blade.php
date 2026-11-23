<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">
                    Halo, {{ $user->nickname ?: $user->name }}!
                </h1>
                <p class="mt-1 text-sm text-stone-600">Kita mulai dengan satu langkah kecil yang bisa kamu coba.</p>
            </div>
            <p class="text-sm font-medium text-stone-600">
                {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-brand-200 bg-brand-50 p-6 sm:p-8" aria-labelledby="welcome-title">
            <p class="text-sm font-semibold text-brand-800">Learning Adventure</p>
            <h2 id="welcome-title" class="mt-2 text-xl font-bold text-stone-900">Petualangan belajar dimulai dari langkahmu</h2>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-stone-700">{{ $disclaimer }}</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <a href="{{ route('siswa.guide') }}" class="inline-flex items-center justify-center rounded-xl border border-brand-700 bg-white px-4 py-2.5 text-sm font-semibold text-brand-800 hover:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Baca petunjuk
                </a>
                <a href="{{ route('siswa.missions.map') }}" class="inline-flex items-center justify-center rounded-xl border border-brand-700 bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Lihat peta misi
                </a>
            </div>
        </section>

        <section class="grid gap-5 md:grid-cols-2" aria-label="Ringkasan petualangan">
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-stone-600">Catatan kemajuanmu</p>
                <p class="mt-2 text-2xl font-bold text-stone-900">
                    {{ $completedCount }} dari {{ $totalMissions }} misi selesai
                </p>
                @php
                    $progressPercent = $totalMissions > 0
                        ? (int) round(($completedCount / $totalMissions) * 100)
                        : 0;
                @endphp
                <div class="mt-4 h-3 overflow-hidden rounded-full bg-stone-200"
                     role="progressbar"
                     aria-label="Kemajuan petualanganmu"
                     aria-valuemin="0"
                     aria-valuemax="{{ max($totalMissions, 1) }}"
                     aria-valuenow="{{ $completedCount }}">
                    <div class="h-full rounded-full bg-brand-700" style="width: {{ $progressPercent }}%"></div>
                </div>
                <p class="mt-2 text-sm text-stone-600">Ini catatan perjalananmu, bukan nilai atau peringkat.</p>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-stone-600">Langkah berikutnya</p>
                @if ($currentMission)
                    <div class="mt-3 flex flex-wrap items-center gap-2">
                        <h2 class="text-xl font-bold text-stone-900">{{ $currentMission->title }}</h2>
                        <x-status-badge :status="$currentProgress->status" />
                    </div>
                    <p class="mt-2 text-sm leading-6 text-stone-600">{{ $currentMission->description }}</p>
                    <a href="{{ route('siswa.missions.show', $currentMission) }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        {{ $currentProgress->status === 'in_progress' ? 'Lanjutkan misi' : 'Mulai misi' }}
                    </a>
                @elseif ($totalMissions > 0)
                    <div class="mt-3">
                        <x-status-badge status="completed" label="Semua misi selesai" />
                    </div>
                    <p class="mt-3 text-sm leading-6 text-stone-600">Kamu bisa melihat kembali catatan perjalananmu kapan saja.</p>
                @else
                    <p class="mt-3 text-sm leading-6 text-stone-600">Belum ada misi aktif. Coba cek lagi nanti.</p>
                @endif
            </div>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm" aria-labelledby="last-step-title">
            <h2 id="last-step-title" class="text-lg font-bold text-stone-900">Langkah terakhir</h2>
            @if ($latestAnswer)
                <p class="mt-2 text-sm leading-6 text-stone-700">
                    Kamu mencoba tantangan “{{ $latestAnswer->challenge->title }}”
                    pada misi “{{ $latestAnswer->challenge->mission->title }}”.
                </p>
                <p class="mt-1 text-sm text-stone-600">
                    {{ $latestAnswer->submitted_at?->translatedFormat('d F Y, H:i') }}
                </p>
            @else
                <p class="mt-2 text-sm leading-6 text-stone-600">Belum ada tantangan yang kamu kerjakan. Mulai dari misi yang tersedia di peta.</p>
            @endif
        </section>
    </div>
</x-app-layout>
