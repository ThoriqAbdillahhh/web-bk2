<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Konsultasi dengan guru BK</h1>
                <p class="mt-1 text-sm text-stone-600">Kamu boleh meminta waktu untuk membicarakan hal yang ingin disampaikan.</p>
            </div>
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                Kembali ke beranda
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 p-4 text-sm font-medium text-stone-800" role="status">
                {{ session('success') }}
            </div>
        @endif

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="text-xl font-bold text-stone-900">Ajukan konsultasi</h2>
                <p class="mt-2 text-sm leading-6 text-stone-600">Tuliskan topik singkat yang ingin kamu bicarakan. Hanya guru BK yang dapat melihat permintaanmu.</p>

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                        <p class="font-semibold">Periksa isianmu:</p>
                        <ul class="mt-2 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('siswa.consultations.store') }}" method="POST" class="mt-5 space-y-5">
                    @csrf
                    <div>
                        <label for="topic" class="mb-2 block text-sm font-semibold text-stone-800">Topik yang ingin dibicarakan</label>
                        <textarea id="topic" name="topic" rows="4" maxlength="255" required aria-describedby="topic-help"
                            class="block w-full rounded-xl border-stone-300 bg-white text-base text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700"
                            placeholder="Contoh: aku ingin membicarakan cara mengatur waktu belajar">{{ old('topic') }}</textarea>
                        <p id="topic-help" class="mt-2 text-sm text-stone-600">Tuliskan sampai 255 karakter. Kamu tidak perlu menuliskan hal yang belum siap kamu ceritakan.</p>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        Ajukan konsultasi
                    </button>
                </form>
            </div>

            <aside class="rounded-2xl border border-amber-300 bg-amber-50 p-6 sm:p-8" aria-labelledby="privacy-title">
                <h2 id="privacy-title" class="text-lg font-bold text-amber-950">Tentang privasi dan dukungan</h2>
                <p class="mt-3 text-sm leading-6 text-amber-950">Permintaan ini hanya dapat dilihat oleh guru BK untuk membantu mengatur tindak lanjut. Guru BK mungkin perlu mengikuti prosedur sekolah jika ada informasi yang berkaitan dengan keselamatanmu.</p>
                <p class="mt-3 text-sm leading-6 text-amber-950">Kalau kamu membutuhkan bantuan segera, sampaikan langsung kepada orang dewasa yang kamu percaya di sekolah atau di rumah.</p>
            </aside>
        </section>

        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm" aria-labelledby="consultation-history-title">
            <div class="border-b border-stone-200 bg-stone-50 px-6 py-5">
                <h2 id="consultation-history-title" class="font-bold text-stone-900">Riwayat permintaanmu</h2>
            </div>

            @forelse ($consultations as $consultation)
                <article class="flex flex-col gap-3 border-b border-stone-100 p-6 last:border-b-0 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="whitespace-pre-line font-medium leading-6 text-stone-900">{{ $consultation->topic }}</p>
                        <p class="mt-2 text-sm text-stone-600">Diajukan {{ $consultation->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <x-status-badge :status="$consultation->status" />
                </article>
            @empty
                <div class="p-6">
                    <p class="text-sm leading-6 text-stone-600">Kamu belum mengajukan konsultasi.</p>
                </div>
            @endforelse
        </section>
    </div>
</x-app-layout>
