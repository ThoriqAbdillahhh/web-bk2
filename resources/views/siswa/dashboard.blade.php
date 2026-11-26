<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold leading-tight text-slate-900">
                Halo, {{ $user->display_name }}!
            </h1>
            <p class="mt-1 text-sm text-slate-600">Setiap langkah kecil adalah bagian dari kemajuanmu.</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-screen-xl space-y-5 px-4 py-5 sm:px-6 lg:px-8">
        <section class="relative isolate overflow-hidden rounded-xl bg-gradient-to-r from-orange-100 via-orange-50 to-[#fff4e8] px-6 py-6 sm:px-8 sm:py-7" aria-labelledby="welcome-title">
            <div class="relative z-10 max-w-xl">
                <h2 id="welcome-title" class="max-w-lg text-2xl font-bold leading-tight text-slate-900 sm:text-[27px]">
                    Petualangan belajar dimulai dari langkahmu.
                </h2>
                <p class="mt-2 max-w-lg text-sm leading-6 text-slate-700">
                    Kenali cara belajarmu, hadapi tantangan, dan temukan langkah yang cocok untukmu.
                </p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <a href="{{ route('siswa.missions.map') }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 text-xs font-bold text-white shadow-sm transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        Lanjutkan petualangan <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('siswa.guide') }}" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-stone-200 bg-white px-4 text-xs font-bold text-slate-800 transition hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        Baca petunjuk
                    </a>
                </div>
                <p class="mt-4 max-w-xl text-[10px] leading-4 text-slate-500">{{ $disclaimer }}</p>
            </div>

            <svg class="pointer-events-none absolute -bottom-4 right-0 hidden h-56 w-[48%] max-w-lg sm:block" viewBox="0 0 460 220" fill="none" aria-hidden="true">
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
                <path d="M395 88c2-16 10-28 25-35 0 14-6 26-18 36 14-9 26-11 36-5-12 10-26 13-43 9Z" fill="#A4B591"/>
            </svg>
        </section>

        <section class="grid gap-4 lg:grid-cols-[1.55fr_1fr]" aria-label="Ringkasan petualangan">
            <article class="min-w-0 rounded-xl border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Perjalanan belajarmu</h2>
                        <p class="mt-1 text-xs text-slate-600">Pelan-pelan, satu misi dalam satu waktu.</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-800">
                        {{ $completedCount }} dari {{ $totalMissions }} misi selesai
                    </span>
                </div>

                @php
                    $progressPercent = $totalMissions > 0
                        ? (int) round(($completedCount / $totalMissions) * 100)
                        : 0;
                @endphp
                <div class="mt-6 overflow-x-auto pb-2">
                    <ol class="flex min-w-max items-start">
                        @foreach ($journeyMissions as $item)
                            @php
                                $isComplete = $item['status'] === 'completed';
                                $isCurrent = $currentMission && $item['mission']->is($currentMission);
                            @endphp
                            <li class="relative flex w-24 flex-col items-center text-center">
                                @if (! $loop->first)
                                    <span class="absolute right-1/2 top-4 h-px w-full {{ $isComplete || $isCurrent ? 'bg-brand-300' : 'bg-stone-200' }}" aria-hidden="true"></span>
                                @endif
                                <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 text-[10px] font-bold {{ $isCurrent ? 'border-brand-600 bg-white text-brand-700 ring-4 ring-brand-50' : ($isComplete ? 'border-brand-600 bg-brand-600 text-white' : 'border-stone-200 bg-stone-50 text-slate-500') }}">
                                    {{ $item['mission']->sequence }}
                                </span>
                                <span class="mt-2 line-clamp-2 px-1 text-[10px] leading-4 {{ $isCurrent ? 'font-bold text-slate-900' : 'text-slate-600' }}">
                                    {{ $item['mission']->title }}
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="mt-4 border-t border-stone-100 pt-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-orange-50 text-brand-700">
                            <x-adventure-icon name="flag" class="h-4 w-4" />
                        </span>
                        <div>
                            <p class="text-xs font-bold text-brand-700">Langkah kecil tetap berarti.</p>
                            <p class="mt-1 text-[10px] text-slate-500">Kemajuanmu tercatat untuk perjalananmu sendiri.</p>
                        </div>
                    </div>
                </div>
                <div class="sr-only" role="progressbar" aria-label="Kemajuan petualanganmu" aria-valuemin="0" aria-valuemax="{{ max($totalMissions, 1) }}" aria-valuenow="{{ $completedCount }}">
                    {{ $progressPercent }}%
                </div>
            </article>

            <article class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
                <p class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Misi aktif</p>
                @if ($currentMission)
                    <h2 class="mt-1.5 text-base font-bold text-slate-900">{{ $currentMission->title }}</h2>
                    <span class="mt-2 inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-800">
                        {{ $currentProgress->status === 'in_progress' ? 'Sedang dikerjakan' : 'Siap dimulai' }}
                    </span>
                    <p class="mt-3 text-xs leading-5 text-slate-600">{{ $currentMission->description }}</p>
                    <div class="mt-4 flex items-center gap-2 border-t border-stone-100 pt-3 text-xs text-slate-600">
                        <x-adventure-icon name="flag" class="h-4 w-4 text-slate-500" />
                        {{ $currentMission->challenges_count }} tantangan bertahap
                    </div>
                    <a href="{{ route('siswa.missions.show', $currentMission) }}" class="mt-4 inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-lg bg-brand-600 px-4 text-xs font-bold text-white transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        {{ $currentProgress->status === 'in_progress' ? 'Lanjutkan misi' : 'Mulai misi' }} <span aria-hidden="true">→</span>
                    </a>
                @elseif ($totalMissions > 0)
                    <h2 class="mt-1.5 text-base font-bold text-slate-900">Semua misi selesai</h2>
                    <p class="mt-3 text-xs leading-5 text-slate-600">Kamu bisa melihat kembali catatan perjalananmu kapan saja.</p>
                    <a href="{{ route('siswa.progress.index') }}" class="mt-4 inline-flex min-h-10 w-full items-center justify-center rounded-lg bg-brand-600 px-4 text-xs font-bold text-white transition hover:bg-brand-700">Lihat ringkasan</a>
                @else
                    <h2 class="mt-1.5 text-base font-bold text-slate-900">Belum ada misi aktif</h2>
                    <p class="mt-3 text-xs leading-5 text-slate-600">Coba cek lagi nanti. Petualanganmu akan muncul di sini.</p>
                @endif
            </article>
        </section>

        <section class="rounded-xl border border-stone-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="last-step-title">
            <div class="flex items-start gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-emerald-800">
                    <x-icon name="clock" class="h-4 w-4" />
                </span>
                <div>
                    <h2 id="last-step-title" class="text-sm font-bold text-slate-900">Aktivitas terakhir</h2>
                    @if ($latestAnswer)
                        <p class="mt-1 text-xs leading-5 text-slate-600">
                            Kamu mencoba tantangan “{{ $latestAnswer->challenge->title }}” pada misi {{ $latestAnswer->challenge->mission->title }}.
                        </p>
                        <p class="mt-1 text-[10px] text-slate-500">{{ $latestAnswer->submitted_at?->translatedFormat('d F Y · H:i') }}</p>
                    @else
                        <p class="mt-1 text-xs leading-5 text-slate-600">Belum ada aktivitas. Mulai dari misi yang tersedia di peta petualangan.</p>
                    @endif
                </div>
            </div>
        </section>

        <p class="flex items-center gap-2 px-1 text-[10px] leading-4 text-slate-500">
            <x-icon name="info" class="h-4 w-4 shrink-0" />
            Media pendamping belajar, bukan alat diagnosis atau penilaian akademik.
        </p>
    </div>
</x-app-layout>
