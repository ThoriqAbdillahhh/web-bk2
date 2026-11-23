<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">Progres agregat per kelas</h1>
                <p class="mt-1 text-sm text-stone-600">Ringkasan ini tidak menampilkan nama siswa dan bukan peringkat.</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        <section class="rounded-2xl border border-brand-200 bg-brand-50 p-5 text-sm leading-6 text-stone-800">
            Angka menunjukkan jumlah siswa di kelas yang menyelesaikan setiap misi. Gunakan untuk melihat kebutuhan fasilitasi kelas, bukan membandingkan kelas atau siswa.
        </section>

        @forelse ($classroomItems as $item)
            <section class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm" aria-labelledby="class-{{ $item['classroom']->id }}">
                <div class="border-b border-stone-200 px-6 py-5">
                    <h2 id="class-{{ $item['classroom']->id }}" class="text-lg font-bold text-stone-900">{{ $item['classroom']->name }}</h2>
                    <p class="mt-1 text-sm text-stone-600">{{ $item['students_count'] }} siswa terdaftar</p>
                </div>
                @if ($missions->isNotEmpty())
                    <ul class="divide-y divide-stone-100">
                        @foreach ($item['missions'] as $missionItem)
                            <li class="flex flex-col gap-2 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                                <span class="font-medium text-stone-800">Misi {{ $missionItem['mission']->sequence }}: {{ $missionItem['mission']->title }}</span>
                                <span class="text-sm text-stone-700">
                                    {{ $missionItem['completed_count'] }} dari {{ $item['students_count'] }} siswa menyelesaikan
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-6 text-sm text-stone-600">Belum ada misi aktif.</p>
                @endif
            </section>
        @empty
            <section class="rounded-2xl border border-stone-200 bg-white p-6">
                <h2 class="font-bold text-stone-900">Belum ada kelas</h2>
                <p class="mt-2 text-sm text-stone-600">Data ringkasan akan muncul setelah kelas dan siswa tersedia.</p>
            </section>
        @endforelse
    </div>
</x-app-layout>
