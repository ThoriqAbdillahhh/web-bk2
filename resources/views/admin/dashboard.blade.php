<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Dashboard Admin</h1>
                <p class="mt-1 text-sm text-stone-600">Ringkasan Learning Adventure dan pengelolaan prototipe.</p>
            </div>
            <div class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-700">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 p-4 text-sm text-stone-800" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">{{ session('error') }}</div>
        @endif

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold text-brand-800">Pusat Kendali</p>
            <h2 class="mt-1 text-xl font-bold text-stone-900">Kelola prototipe Learning Adventure</h2>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-600">Atur akun, kelas, isi misi, tantangan dan checklist uji fungsi. Aplikasi ini merupakan pendamping belajar, bukan alat diagnosis atau penilaian akademik.</p>
        </section>

        <section aria-label="Ringkasan data" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['label' => 'Jumlah siswa', 'value' => $totalSiswa],
                ['label' => 'Jumlah guru BK', 'value' => $totalGuru],
                ['label' => 'Jumlah kelas', 'value' => $totalKelas],
                ['label' => 'Jumlah misi', 'value' => $totalMisi],
                ['label' => 'Jumlah tantangan', 'value' => $totalTantangan],
                ['label' => 'Checklist belum diperiksa', 'value' => $checksPending],
            ] as $stat)
                <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-stone-600">{{ $stat['label'] }}</p>
                    <p class="mt-1 text-3xl font-bold text-stone-900">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-stone-900">Pengelolaan</h2>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-800 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kelola akun</a>
                <a href="{{ route('admin.classrooms.index') }}" class="rounded-xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-800 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kelola kelas</a>
                <a href="{{ route('admin.missions.index') }}" class="rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kelola misi dan tantangan</a>
                <a href="{{ route('admin.checks.index') }}" class="rounded-xl border border-stone-300 px-4 py-2.5 text-sm font-semibold text-stone-800 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Checklist uji fungsi</a>
            </div>
        </section>
    </div>
</x-app-layout>