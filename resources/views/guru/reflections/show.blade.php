<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Refleksi siswa</h1>
                <p class="mt-1 text-sm text-stone-600">{{ $reflection->mission->title }} · {{ $reflection->created_at->translatedFormat('d F Y, H:i') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('guru.reflections.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kembali ke refleksi</a>
                <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 p-4 text-sm text-stone-800" role="status">{{ session('success') }}</div>
        @endif

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-stone-900">{{ $reflection->user->nickname ?: $reflection->user->name }}</h2>
            <p class="mt-1 text-sm text-stone-600">{{ $reflection->user->classroom?->name ?? 'Kelas belum terdaftar' }}</p>
            <p class="mt-3 rounded-xl border border-brand-200 bg-brand-50 p-3 text-sm text-stone-800">Siswa memilih untuk membagikan refleksi ini kepada guru BK.</p>
            <dl class="mt-5 space-y-5">
                <div>
                    <dt class="font-semibold text-stone-800">Apa yang dipelajari</dt>
                    <dd class="mt-1 whitespace-pre-line leading-6 text-stone-700">{{ $reflection->what_learned }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-stone-800">Bagian yang terasa sulit</dt>
                    <dd class="mt-1 whitespace-pre-line leading-6 text-stone-700">{{ $reflection->difficult_part }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-stone-800">Langkah berikutnya</dt>
                    <dd class="mt-1 whitespace-pre-line leading-6 text-stone-700">{{ $reflection->next_step }}</dd>
                </div>
            </dl>
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-stone-900">Umpan balik guru BK</h2>
            @if ($reflection->feedback->isNotEmpty())
                <ul class="mt-4 space-y-4">
                    @foreach ($reflection->feedback as $feedback)
                        <li class="rounded-xl border border-stone-200 p-4">
                            <p class="whitespace-pre-line leading-6 text-stone-700">{{ $feedback->content }}</p>
                            <p class="mt-2 text-sm text-stone-600">{{ $feedback->teacher?->nickname ?: $feedback->teacher?->name ?: 'Guru BK' }} · {{ $feedback->created_at->translatedFormat('d F Y, H:i') }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif

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

            <form method="POST" action="{{ route('guru.reflections.feedback', $reflection) }}" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label for="content" class="mb-2 block text-sm font-semibold text-stone-800">Tulis umpan balik yang menguatkan strategi atau langkah berikutnya</label>
                    <textarea id="content" name="content" rows="4" maxlength="3000" required class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('content') }}</textarea>
                </div>
                <p class="text-sm leading-6 text-stone-600">Fokus pada strategi dan langkah yang bisa dicoba; hindari memberi label atau diagnosis.</p>
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kirim umpan balik</button>
            </form>
        </section>
    </div>
</x-app-layout>
