<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-bold text-2xl text-stone-900 leading-tight">Permintaan Konsultasi</h1>
                <p class="mt-1 text-sm text-stone-600">Kelola tindak lanjut permintaan siswa.</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Beranda</a>
        </div>
    </x-slot>

    <div class="mx-auto mt-2 max-w-5xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-xl border border-brand-300 bg-brand-50 px-4 py-3 text-sm text-stone-800" role="status">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                <p class="font-semibold">Periksa pilihan status:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Filter Tab --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <a href="{{ route('guru.consultations.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ !$filter ? 'bg-brand-700 text-white shadow-sm' : 'bg-white border border-stone-300 text-stone-700 hover:bg-stone-50' }}">Semua</a>
            @foreach (\App\Models\Consultation::STATUSES as $s)
                <a href="{{ route('guru.consultations.index', ['status' => $s]) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors capitalize {{ $filter === $s ? 'bg-brand-700 text-white shadow-sm' : 'bg-white border border-stone-300 text-stone-700 hover:bg-stone-50' }}">{{ $s }}</a>
            @endforeach
        </div>

        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-stone-100">
                @forelse ($consultations as $c)
                    <div class="p-6 hover:bg-stone-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1.5 flex-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-stone-900 text-lg">{{ $c->user->nickname ?: $c->user->name }}</h4>
                                <span class="text-xs font-semibold bg-stone-100 text-stone-700 px-2 py-0.5 rounded">{{ $c->user->classroom?->name ?? 'Kelas belum terdaftar' }}</span>
                            </div>
                            <p class="text-sm font-medium text-stone-600">{{ $c->created_at->translatedFormat('d F Y, H:i') }}</p>
                            <div class="bg-stone-50 border border-stone-200 p-3 rounded-lg mt-2">
                                <p class="whitespace-pre-line text-sm text-stone-800">{{ $c->topic }}</p>
                            </div>
                        </div>
                        
                        {{-- Dropdown Status --}}
                        <div class="flex shrink-0 flex-col gap-2">
                            <x-status-badge :status="$c->status" />
                            <form method="POST" action="{{ route('guru.consultations.update', $c) }}">
                                @csrf @method('PATCH')
                                <label for="consultation-status-{{ $c->id }}" class="sr-only">Ubah status konsultasi</label>
                                <select name="status" onchange="this.form.submit()"
                                        id="consultation-status-{{ $c->id }}"
                                        class="rounded-lg border border-stone-300 bg-white text-sm font-semibold py-2 pl-3 pr-8 focus:border-brand-700 focus:ring-brand-700 cursor-pointer text-stone-800">
                                    @foreach (\App\Models\Consultation::STATUSES as $s)
                                        <option value="{{ $s }}" @selected($c->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-stone-600 text-sm">Belum ada permintaan konsultasi.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $consultations->links() }}
        </div>
    </div>
</x-app-layout>