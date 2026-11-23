<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Jurnal Siswa') }}
                </h2>
                <p class="text-sm text-stone-500 mt-1">Tinjau dan berikan umpan balik untuk jurnal yang dibagikan.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-2">
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-stone-100">
                @forelse ($journals as $j)
                    <div class="p-6 hover:bg-stone-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="font-bold text-stone-900 text-lg">{{ $j->user->nickname ?: $j->user->name }}</h4>
                                <span class="text-xs font-semibold bg-stone-100 text-stone-600 px-2 py-0.5 rounded">{{ $j->user->classroom?->name ?? '-' }}</span>
                                <span class="text-xs font-semibold bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100">Minggu ke-{{ $j->week_no }}</span>
                            </div>
                            
                            <div class="mt-2 flex items-center gap-2">
                                @if($j->feedback)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold bg-[#dcfce7] text-[#166534] px-2 py-1 rounded-md border border-[#bbf7d0]">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Sudah direspons
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold bg-[#fef9c3] text-[#a16207] px-2 py-1 rounded-md border border-[#fef08a]">
                                        Belum direspons
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="shrink-0">
                            <a href="{{ route('guru.journals.show', $j) }}" class="inline-flex items-center justify-center bg-white border border-stone-300 hover:bg-stone-50 hover:border-stone-400 text-stone-700 font-semibold px-5 py-2.5 rounded-lg transition-colors text-sm shadow-sm w-full sm:w-auto">
                                Buka Jurnal &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center">
                        <p class="text-stone-500 text-sm">Belum ada jurnal yang dibagikan siswa.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $journals->links() }}
        </div>
    </div>
</x-app-layout>