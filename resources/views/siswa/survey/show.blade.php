<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Angket respons</h1>
                <p class="mt-1 text-sm text-stone-600">Ceritakan pengalamanmu menggunakan Learning Adventure.</p>
            </div>
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                Kembali ke beranda
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-brand-200 bg-brand-50 p-5 text-sm leading-6 text-stone-800">
            <p>Setelah mencoba prototipe Learning Adventure, pilih satu jawaban yang paling sesuai untuk setiap pernyataan.</p>
            <p class="mt-2">Jawaban angket disimpan tanpa nama, email, atau ID akun. Isian saran juga akan terlihat oleh guru BK dalam rekap, jadi jangan tulis nama atau informasi pribadi di sana.</p>
            <p class="mt-2 text-stone-700">Angket ini adalah draf awal dan perlu ditelaah sebelum digunakan.</p>
        </section>

        @if (session('survey_submitted') || $alreadySubmitted)
            <section class="rounded-2xl border border-brand-300 bg-brand-50 p-6" role="status">
                <h2 class="text-lg font-bold text-stone-900">Terima kasih sudah berbagi pendapat</h2>
                <p class="mt-2 text-sm leading-6 text-stone-700">Jawabanmu membantu tim memahami pengalaman menggunakan prototipe.</p>
            </section>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                <p class="font-semibold">Periksa isian angket:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @unless ($alreadySubmitted)
            <form method="POST" action="{{ route('siswa.survey.store') }}" class="space-y-5">
                @csrf

                @foreach ($statements as $number => $statement)
                    <fieldset class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                        <legend class="max-w-full px-1 text-sm font-semibold leading-6 text-stone-900">
                            {{ $number }}. {{ $statement }}
                        </legend>
                        <div class="mt-3 grid gap-2 sm:grid-cols-3">
                            @foreach ($choices as $value => $label)
                                <label for="answer-{{ $number }}-{{ $value }}" class="flex cursor-pointer items-center gap-3 rounded-xl border border-stone-300 p-3 text-sm text-stone-800">
                                    <input id="answer-{{ $number }}-{{ $value }}" type="radio" name="answers[{{ $number }}]" value="{{ $value }}" required @checked(old('answers.'.$number) === $value) class="border-stone-400 text-brand-700 focus:ring-brand-700">
                                    <span>{{ $value }} — {{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                @endforeach

                <section class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <label for="suggestion" class="block text-sm font-semibold text-stone-800">Bagian apa yang menurutmu perlu diperbaiki? (opsional)</label>
                    <textarea id="suggestion" name="suggestion" rows="4" maxlength="2000" class="mt-2 block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('suggestion') }}</textarea>
                </section>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        Kirim angket anonim
                    </button>
                    <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                        Beranda
                    </a>
                </div>
            </form>
        @else
            <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">
                Beranda
            </a>
        @endunless
    </div>
</x-app-layout>
