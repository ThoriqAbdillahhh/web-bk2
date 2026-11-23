<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Dashboard Guru BK</h1>
                <p class="mt-1 text-sm text-stone-600">Dampingi proses belajar siswa sebagai fasilitator.</p>
            </div>
            <p class="text-sm font-medium text-stone-600">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-xl font-bold text-stone-900">Selamat datang, {{ Auth::user()->nickname ?: 'Guru BK' }}.</h2>
            <p class="mt-2 max-w-3xl text-sm leading-6 text-stone-600">Learning Adventure adalah prototipe pendamping belajar, bukan alat diagnosis atau penilaian akademik. Gunakan catatan untuk mendukung langkah siswa, bukan membandingkan mereka.</p>
        </section>

        <section class="grid gap-5 sm:grid-cols-2" aria-label="Ringkasan tindak lanjut">
            <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-stone-600">Refleksi yang dibagikan dan belum mendapat umpan balik</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">{{ $sharedReflectionsToReview }}</p>
                <a href="{{ route('guru.reflections.index') }}" class="mt-4 inline-flex items-center text-sm font-semibold text-brand-800 underline hover:text-brand-900">
                    Buka refleksi yang dibagikan
                </a>
            </article>
            <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-semibold text-stone-600">Permintaan konsultasi menunggu</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">{{ $pendingConsultations }}</p>
                <a href="{{ route('guru.consultations.index', ['status' => 'menunggu']) }}" class="mt-4 inline-flex items-center text-sm font-semibold text-brand-800 underline hover:text-brand-900">
                    Tinjau konsultasi
                </a>
            </article>
        </section>

        <section class="rounded-2xl border border-brand-200 bg-brand-50 p-6" aria-labelledby="teacher-links-title">
            <h2 id="teacher-links-title" class="font-bold text-stone-900">Perangkat fasilitator</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('guru.progress.index') }}" class="inline-flex items-center justify-center rounded-xl border border-brand-700 bg-white px-4 py-2.5 text-sm font-semibold text-brand-900 hover:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Progres agregat per kelas</a>
                <a href="{{ route('guru.observations.index') }}" class="inline-flex items-center justify-center rounded-xl border border-brand-700 bg-white px-4 py-2.5 text-sm font-semibold text-brand-900 hover:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Lembar observasi</a>
                <a href="{{ route('guru.survey.index') }}" class="inline-flex items-center justify-center rounded-xl border border-brand-700 bg-white px-4 py-2.5 text-sm font-semibold text-brand-900 hover:bg-brand-100 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Rekap angket anonim</a>
            </div>
        </section>
    </div>
</x-app-layout>
