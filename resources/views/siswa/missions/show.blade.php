<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-brand-800">Misi {{ $mission->sequence }}</p>
                <h1 class="mt-1 text-2xl font-bold leading-tight text-stone-900">{{ $mission->title }}</h1>
                <p class="mt-1 text-sm text-stone-600">{{ $mission->description }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('siswa.missions.map') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Kembali ke peta
                </a>
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Beranda
                </a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm" aria-labelledby="mission-instructions-title">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 id="mission-instructions-title" class="text-lg font-bold text-stone-900">Petunjuk misi</h2>
                <x-status-badge :status="$progress->status" />
            </div>
            <p class="mt-3 leading-7 text-stone-700">{{ $mission->instructions }}</p>
        </section>

        @if (is_array($feedback))
            <section id="umpan-balik" class="rounded-2xl border {{ $feedback['is_correct'] ? 'border-brand-300 bg-brand-50' : 'border-amber-300 bg-amber-50' }} p-6" role="status" aria-labelledby="feedback-title">
                <div class="flex flex-wrap items-center gap-3">
                    <x-status-badge :status="$feedback['status']" :label="$feedback['label']" />
                    <h2 id="feedback-title" class="font-bold text-stone-900">{{ $feedback['challenge_title'] }}</h2>
                </div>
                <p class="mt-3 leading-7 text-stone-800">{{ $feedback['message'] }}</p>
                @if ($feedback['mission_complete'])
                    <p class="mt-3 text-sm font-semibold text-stone-800">Misi selesai. Misi berikutnya sekarang terbuka di peta.</p>
                @elseif ($feedback['awaiting_reflection'])
                    <p class="mt-3 text-sm font-semibold text-stone-800">Tantangan misi ini selesai. Langkah berikutnya adalah mengisi refleksi.</p>
                @endif
            </section>
        @endif

        @if (session('reflection_saved'))
            <section class="rounded-2xl border border-brand-300 bg-brand-50 p-5" role="status">
                <h2 class="font-bold text-stone-900">Refleksi tersimpan</h2>
                <p class="mt-1 text-sm leading-6 text-stone-700">
                    Refleksimu berstatus {{ session('reflection_status') }}. Kamu dapat melihat catatanmu di ringkasan kemajuan.
                </p>
            </section>
        @endif

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm" aria-labelledby="challenge-progress-title">
            <h2 id="challenge-progress-title" class="text-lg font-bold text-stone-900">Tahapan tantangan</h2>
            <ol class="mt-4 space-y-3">
                @foreach ($challengeStates as $state)
                    <li class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-stone-200 p-4">
                        <div>
                            <p class="font-semibold text-stone-800">Tingkat {{ $state['challenge']->level }}: {{ $state['challenge']->title }}</p>
                            @if ($state['attempt_count'] > 0)
                                <p class="mt-1 text-sm text-stone-600">{{ $state['attempt_count'] }} kali dicoba</p>
                            @endif
                        </div>
                        <x-status-badge :status="$state['status']" />
                    </li>
                @endforeach
            </ol>
        </section>

        @if ($currentChallenge)
            <section id="tantangan" class="scroll-mt-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="challenge-title">
                <p class="text-sm font-semibold text-brand-800">Tingkat {{ $currentChallenge->level }}</p>
                <h2 id="challenge-title" class="mt-1 text-xl font-bold text-stone-900">{{ $currentChallenge->title }}</h2>
                <p class="mt-3 leading-7 text-stone-800">{{ $currentChallenge->prompt }}</p>
                @if ($currentChallenge->instructions)
                    <p class="mt-2 text-sm leading-6 text-stone-600">{{ $currentChallenge->instructions }}</p>
                @endif

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                        <p class="font-semibold">Periksa pilihanmu:</p>
                        <ul class="mt-2 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (is_array($feedback) && (int) $feedback['challenge_id'] === (int) $currentChallenge->id && ! $feedback['is_correct'])
                    <form method="POST" action="{{ route('siswa.missions.retry', [$mission, $currentChallenge]) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                            Coba tantangan ini lagi
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('siswa.missions.answer', [$mission, $currentChallenge]) }}" class="mt-6 space-y-5">
                        @csrf

                        @if ($currentChallenge->challenge_type === 'ordering')
                            <fieldset class="space-y-4">
                                <legend class="text-sm font-semibold text-stone-800">Pilih langkah untuk setiap urutan</legend>
                                @foreach ($currentChallenge->options as $index => $option)
                                    <div>
                                        <label for="answer-order-{{ $index }}" class="mb-2 block text-sm font-semibold text-stone-700">
                                            Urutan ke-{{ $index + 1 }}
                                        </label>
                                        <select id="answer-order-{{ $index }}" name="answer_order[]" required class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                                            <option value="">Pilih langkah</option>
                                            @foreach ($currentChallenge->options as $choice)
                                                <option value="{{ $choice->id }}" @selected((string) old('answer_order.'.$index) === (string) $choice->id)>
                                                    {{ $choice->label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endforeach
                            </fieldset>
                        @else
                            <fieldset class="space-y-3">
                                <legend class="text-sm font-semibold text-stone-800">Pilih satu jawaban</legend>
                                @foreach ($currentChallenge->options as $option)
                                    <div class="rounded-xl border border-stone-200 p-4">
                                        <label for="option-{{ $option->id }}" class="flex cursor-pointer items-start gap-3">
                                            <input id="option-{{ $option->id }}" name="selected_option_id" type="radio" value="{{ $option->id }}" required @checked((string) old('selected_option_id') === (string) $option->id) class="mt-1 border-stone-400 text-brand-700 focus:ring-brand-700">
                                            <span class="leading-6 text-stone-800">{{ $option->label }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </fieldset>
                        @endif

                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                            Lihat umpan balik
                        </button>
                    </form>
                @endif
            </section>
        @elseif ($allChallengesComplete)
            <section class="rounded-2xl border border-brand-200 bg-brand-50 p-6" role="status">
                <h2 class="text-lg font-bold text-stone-900">Semua tantangan di misi ini sudah kamu coba</h2>
                @if ($mission->slug === 'refleksi')
                    @if ($progress->status === 'completed')
                        <p class="mt-2 leading-6 text-stone-700">
                            Refleksimu sudah tersimpan sebagai {{ session('reflection_status', 'privat') }}.
                            Kamu dapat melihat catatanmu di ringkasan kemajuan.
                        </p>
                        <a href="{{ route('siswa.progress.index') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                            Buka ringkasan kemajuan
                        </a>
                    @else
                        <p class="mt-2 leading-6 text-stone-700">Lengkapi refleksi tentang hal yang kamu pelajari, bagian yang terasa sulit, dan langkah berikutnya.</p>
                        <p class="mt-3 rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm leading-6 text-amber-950">
                            {{ config('adventure.reflection_privacy_notice') }}
                        </p>
                        <form method="POST" action="{{ route('siswa.reflections.store', $mission) }}" class="mt-5 space-y-5">
                            @csrf

                            @if ($errors->any())
                                <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                                    <p class="font-semibold">Periksa isianmu:</p>
                                    <ul class="mt-2 list-inside list-disc space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div>
                                <label for="what_learned" class="mb-2 block text-sm font-semibold text-stone-800">Apa yang kamu pelajari?</label>
                                <textarea id="what_learned" name="what_learned" rows="3" required maxlength="3000" class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('what_learned') }}</textarea>
                            </div>

                            <div>
                                <label for="difficult_part" class="mb-2 block text-sm font-semibold text-stone-800">Bagian mana yang terasa sulit?</label>
                                <textarea id="difficult_part" name="difficult_part" rows="3" required maxlength="3000" class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('difficult_part') }}</textarea>
                            </div>

                            <div>
                                <label for="next_step" class="mb-2 block text-sm font-semibold text-stone-800">Apa langkah berikutnya yang ingin kamu coba?</label>
                                <textarea id="next_step" name="next_step" rows="3" required maxlength="3000" class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('next_step') }}</textarea>
                            </div>

                            <div class="rounded-xl border border-stone-300 p-4">
                                <label for="is_shared" class="flex items-start gap-3">
                                    <input id="is_shared" name="is_shared" type="checkbox" value="1" @checked(old('is_shared')) class="mt-1 rounded border-stone-400 text-brand-700 focus:ring-brand-700">
                                    <span>
                                        <span class="block text-sm font-semibold text-stone-800">Bagikan refleksi ini kepada guru BK</span>
                                        <span class="mt-1 block text-sm leading-6 text-stone-600">Jika tidak dicentang, refleksi hanya terlihat oleh kamu. Jika dicentang, guru BK dapat membaca dan memberi umpan balik.</span>
                                    </span>
                                </label>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                                Simpan refleksi
                            </button>
                        </form>
                    @endif
                @else
                    <p class="mt-2 leading-6 text-stone-700">Misi ini selesai. Kamu bisa membuka peta untuk melihat langkah berikutnya.</p>
                @endif
                <a href="{{ route('siswa.missions.map') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Kembali ke peta
                </a>
            </section>
        @else
            <section class="rounded-2xl border border-stone-200 bg-white p-6" role="status">
                <h2 class="font-bold text-stone-900">Belum ada tantangan aktif</h2>
                <p class="mt-2 text-sm leading-6 text-stone-600">Tantangan untuk misi ini belum tersedia. Kamu bisa kembali ke peta dan mencoba lagi nanti.</p>
                <a href="{{ route('siswa.missions.map') }}" class="mt-4 inline-flex items-center justify-center rounded-xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                    Kembali ke peta
                </a>
            </section>
        @endif
    </div>
</x-app-layout>
