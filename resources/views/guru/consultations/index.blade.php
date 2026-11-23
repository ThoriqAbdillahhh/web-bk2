<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-stone-900 leading-tight">Permintaan Konsultasi</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-2 space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-[#dcfce7] text-[#166534] px-4 py-3 text-sm border border-[#bbf7d0]">{{ session('success') }}</div>
        @endif

        {{-- Filter Tab --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <a href="{{ route('guru.consultations.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ !$filter ? 'bg-[#2b8577] text-white shadow-sm' : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">Semua</a>
            @foreach (\App\Models\Consultation::STATUSES as $s)
                <a href="{{ route('guru.consultations.index', ['status' => $s]) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors capitalize {{ $filter === $s ? 'bg-[#2b8577] text-white shadow-sm' : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">{{ $s }}</a>
            @endforeach
        </div>

        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-stone-100">
                @forelse ($consultations as $c)
                    <div class="p-6 hover:bg-stone-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1.5 flex-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-stone-900 text-lg">{{ $c->user->nickname ?: $c->user->name }}</h4>
                                <span class="text-xs font-semibold bg-stone-100 text-stone-600 px-2 py-0.5 rounded">{{ $c->user->classroom?->name ?? '-' }}</span>
                            </div>
                            <p class="text-sm font-medium text-stone-500">{{ $c->created_at->format('d M Y') }}</p>
                            <div class="bg-[#faf9f6] border border-stone-200/60 p-3 rounded-lg mt-2">
                                <p class="text-sm text-stone-700 italic">"{{ $c->topic }}"</p>
                            </div>
                        </div>
                        
                        {{-- Dropdown Status --}}
                        <div class="shrink-0 bg-white rounded-lg border border-stone-200 p-1 shadow-sm">
                            <form method="POST" action="{{ route('guru.consultations.update', $c) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="bg-transparent border-none text-sm font-semibold py-1 pl-3 pr-8 focus:ring-0 cursor-pointer text-stone-700">
                                    @foreach (\App\Models\Consultation::STATUSES as $s)
                                        <option value="{{ $s }}" @selected($c->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-stone-500 text-sm">Belum ada permintaan konsultasi.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $consultations->links() }}
        </div>
    </div>
</x-app-layout>