<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Lembar observasi uji pengguna</h1>
                <p class="mt-1 text-sm text-stone-600">Catat pengalaman penggunaan secara umum, tanpa nama atau data pribadi siswa.</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 p-4 text-sm text-stone-800" role="status">{{ session('success') }}</div>
        @endif

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-lg font-bold text-stone-900">Catat satu sesi observasi</h2>
            <p class="mt-2 text-sm leading-6 text-stone-600">Catat aktivitas dan hal yang dapat diperbaiki. Jangan tulis nama, email, diagnosis, atau informasi pribadi siswa.</p>

            @if ($errors->any())
                <div class="mt-5 rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                    <p class="font-semibold">Periksa isian:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('guru.observations.store') }}" class="mt-5 grid gap-5 md:grid-cols-2">
                @csrf
                <div>
                    <label for="classroom_id" class="mb-2 block text-sm font-semibold text-stone-800">Kelas</label>
                    <select id="classroom_id" name="classroom_id" required class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                        <option value="">Pilih kelas</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" @selected((string) old('classroom_id') === (string) $classroom->id)>{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="observed_at" class="mb-2 block text-sm font-semibold text-stone-800">Tanggal observasi</label>
                    <input id="observed_at" name="observed_at" type="date" required max="{{ now()->toDateString() }}" value="{{ old('observed_at', now()->toDateString()) }}" class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                </div>
                <div>
                    <label for="activity" class="mb-2 block text-sm font-semibold text-stone-800">Aktivitas yang diamati</label>
                    <input id="activity" name="activity" type="text" maxlength="255" required value="{{ old('activity') }}" class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700" placeholder="Contoh: memahami petunjuk atau membuka misi">
                </div>
                <div>
                    <label for="result" class="mb-2 block text-sm font-semibold text-stone-800">Hasil observasi</label>
                    <select id="result" name="result" required class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                        <option value="">Pilih hasil</option>
                        @foreach ($results as $result)
                            <option value="{{ $result }}" @selected(old('result') === $result)>{{ str_replace('_', ' ', ucfirst($result)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="notes" class="mb-2 block text-sm font-semibold text-stone-800">Catatan umum (opsional)</label>
                    <textarea id="notes" name="notes" rows="4" maxlength="3000" class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('notes') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Simpan observasi</button>
                </div>
            </form>
        </section>

        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm" aria-labelledby="observations-title">
            <div class="border-b border-stone-200 bg-stone-50 px-6 py-5">
                <h2 id="observations-title" class="font-bold text-stone-900">Riwayat observasi</h2>
            </div>
            @forelse ($observations as $observation)
                <article class="border-b border-stone-100 p-6 last:border-b-0">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-stone-900">{{ $observation->activity }}</h3>
                            <p class="mt-1 text-sm text-stone-600">{{ $observation->classroom?->name ?? 'Kelas tidak tersedia' }} · {{ $observation->observed_at?->translatedFormat('d F Y') }}</p>
                        </div>
                        <x-status-badge :status="$observation->result ?? 'belum_diperiksa'" />
                    </div>
                    @if ($observation->notes)
                        <p class="mt-3 whitespace-pre-line text-sm leading-6 text-stone-700">{{ $observation->notes }}</p>
                    @endif
                    @if ((int) $observation->observer_id === (int) Auth::id())
                        <form method="POST" action="{{ route('guru.observations.destroy', $observation) }}" class="mt-4" onsubmit="return confirm('Hapus catatan observasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-lg border border-rose-300 px-3 py-2 text-sm font-semibold text-rose-900 hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-700 focus:ring-offset-2">Hapus catatan</button>
                        </form>
                    @endif
                </article>
            @empty
                <p class="p-6 text-sm text-stone-600">Belum ada catatan observasi.</p>
            @endforelse
        </section>

        {{ $observations->links() }}
    </div>
</x-app-layout>
