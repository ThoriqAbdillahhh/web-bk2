<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('guru.journals.index') }}" class="text-stone-400 hover:text-stone-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-stone-900 leading-tight">
                Jurnal {{ $journal->user->nickname ?: $journal->user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-2 space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-[#dcfce7] text-[#166534] px-4 py-3 text-sm border border-[#bbf7d0]">{{ session('success') }}</div>
        @endif

        {{-- Kartu Isi Jurnal --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
            <div class="flex justify-between items-center border-b border-stone-100 pb-4 mb-6">
                <div>
                    <h3 class="font-bold text-stone-900 text-lg">Minggu ke-{{ $journal->week_no }}</h3>
                    <p class="text-sm text-stone-500 mt-1">Kelas: {{ $journal->user->classroom?->name ?? '-' }}</p>
                </div>
                <div class="text-xs text-stone-400">{{ $journal->created_at->format('d M Y') }}</div>
            </div>

            <div class="space-y-5">
                <div>
                    <p class="text-xs font-bold text-stone-400 uppercase tracking-wide">Apa yang aku pelajari tentang diriku?</p>
                    <p class="text-stone-800 mt-1">{{ $journal->q1 }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-stone-400 uppercase tracking-wide">Bagaimana kepribadianku tampak di situasi nyata?</p>
                    <p class="text-stone-800 mt-1">{{ $journal->q2 }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-stone-400 uppercase tracking-wide">Apa langkahku berikutnya?</p>
                    <p class="text-stone-800 mt-1">{{ $journal->q3 }}</p>
                </div>
            </div>
        </div>

        {{-- Form Umpan Balik --}}
        <form method="POST" action="{{ route('guru.journals.feedback', $journal) }}" class="bg-[#faf9f6] border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-40 h-40 opacity-40 pointer-events-none">
                <x-leaf-decoration class="w-full h-full" />
            </div>
            
            <div class="relative z-10">
                <h4 class="font-bold text-stone-800 mb-1">Beri Umpan Balik</h4>
                <p class="text-sm text-stone-500 mb-4">Berikan respons yang menguatkan dan terarah untuk siswa.</p>
                
                @csrf
                <textarea id="content" name="content" rows="4" required
                          class="block w-full rounded-xl border-stone-200 bg-white shadow-sm focus:border-[#2b8577] focus:ring-[#2b8577] text-sm placeholder-stone-400"
                          placeholder="Tulis umpan balikmu di sini...">{{ old('content', $journal->feedback?->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />

                <div class="mt-4 flex items-center justify-between">
                    <a href="{{ route('guru.journals.index') }}" class="text-sm font-medium text-stone-500 hover:text-stone-800">Batal</a>
                    <button type="submit" class="bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                        Simpan Umpan Balik
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>