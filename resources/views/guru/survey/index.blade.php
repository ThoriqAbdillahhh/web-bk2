<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Rekap angket anonim</h1>
                <p class="mt-1 text-sm text-stone-600">Respons disajikan secara agregat dan tidak terhubung ke akun siswa.</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-brand-200 bg-brand-50 p-5">
            <p class="font-semibold text-stone-900">Jumlah respons: {{ $responseCount }}</p>
            <p class="mt-1 text-sm leading-6 text-stone-700">Rekap ini adalah deskripsi respons prototipe, bukan klaim efektivitas atau penilaian siswa.</p>
        </section>

        <section class="space-y-4" aria-label="Distribusi jawaban per pernyataan">
            @foreach ($summary as $number => $item)
                @php $validCount = array_sum($item['counts']); @endphp
                <article class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <h2 class="font-semibold leading-6 text-stone-900">{{ $number }}. {{ $item['statement'] }}</h2>
                    <p class="mt-1 text-sm text-stone-600">{{ $validCount }} jawaban valid</p>
                    <dl class="mt-4 grid gap-3 sm:grid-cols-3">
                        @foreach ($choices as $key => $label)
                            <div class="rounded-xl border border-stone-200 p-4">
                                <dt class="text-sm font-medium text-stone-600">{{ $key }} — {{ $label }}</dt>
                                <dd class="mt-1 text-xl font-bold text-stone-900">{{ $item['counts'][$key] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </article>
            @endforeach
        </section>

        <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm" aria-labelledby="suggestions-title">
            <div class="border-b border-stone-200 bg-stone-50 px-6 py-5">
                <h2 id="suggestions-title" class="font-bold text-stone-900">Saran terbuka</h2>
                <p class="mt-1 text-sm text-stone-600">Isian tidak memuat nama akun. Jangan salin informasi pribadi siswa ke tempat lain.</p>
            </div>
            @forelse ($suggestions as $response)
                <article class="border-b border-stone-100 p-6 last:border-b-0">
                    <p class="whitespace-pre-line text-sm leading-6 text-stone-800">{{ $response->suggestion }}</p>
                </article>
            @empty
                <p class="p-6 text-sm text-stone-600">Belum ada saran terbuka.</p>
            @endforelse
        </section>

        {{ $suggestions->links() }}
    </div>
</x-app-layout>
