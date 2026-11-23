<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Checklist uji fungsi</h1>
                <p class="mt-1 text-sm text-stone-600">Catat status pemeriksaan 10 fungsi prototipe.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 p-4 text-sm text-stone-800" role="status">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                <p class="font-semibold">Periksa isian checklist:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.checks.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            @foreach (\Database\Seeders\FunctionCheckSeeder::ITEMS as $number => $title)
                @php
                    $check = $checks->get($number);
                    $status = old("checks.{$number}.status", $check?->status ?? 'belum_diperiksa');
                    $notes = old("checks.{$number}.notes", $check?->notes);
                @endphp
                <section class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm" aria-labelledby="check-title-{{ $number }}">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <h2 id="check-title-{{ $number }}" class="font-semibold leading-6 text-stone-900">{{ $number }}. {{ $title }}</h2>
                        <x-status-badge :status="$status" />
                    </div>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="check-status-{{ $number }}" class="mb-2 block text-sm font-semibold text-stone-800">Status pemeriksaan</label>
                            <select id="check-status-{{ $number }}" name="checks[{{ $number }}][status]" required class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                                <option value="belum_diperiksa" @selected($status === 'belum_diperiksa')>Belum diperiksa</option>
                                <option value="berfungsi" @selected($status === 'berfungsi')>Berfungsi</option>
                                <option value="perlu_revisi" @selected($status === 'perlu_revisi')>Perlu revisi</option>
                            </select>
                        </div>
                        <div>
                            <label for="check-notes-{{ $number }}" class="mb-2 block text-sm font-semibold text-stone-800">Catatan (opsional)</label>
                            <input id="check-notes-{{ $number }}" name="checks[{{ $number }}][notes]" type="text" maxlength="2000" value="{{ $notes }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                        </div>
                    </div>
                    @if ($check?->checked_at)
                        <p class="mt-3 text-sm text-stone-600">Diperiksa {{ $check->checked_at->translatedFormat('d F Y, H:i') }} oleh {{ $check->checker?->name ?? 'akun yang sudah tidak tersedia' }}.</p>
                    @endif
                </section>
            @endforeach

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Simpan checklist</button>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">Beranda</a>
            </div>
        </form>
    </div>
</x-app-layout>
