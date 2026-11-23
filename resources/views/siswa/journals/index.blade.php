<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Jurnal Refleksi') }}
                </h2>
                <p class="text-sm text-stone-500 mt-1">Tinjau dan renungkan perjalanan belajarmu.</p>
            </div>
            {{-- Tombol Tulis Jurnal di Header --}}
            <a href="{{ route('siswa.journals.create') ?? '#' }}" class="inline-flex items-center gap-2 bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tulis Jurnal
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-2">
        {{-- Kontainer Utama --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm relative overflow-hidden">
            
            {{-- Ilustrasi Daun di Kanan Atas --}}
            <div class="absolute -right-6 -top-6 w-48 h-48 opacity-80 pointer-events-none">
                <x-leaf-decoration class="w-full h-full" />
            </div>

            <div class="p-6 sm:p-8 relative z-10">
                
                {{-- Header Jurnal (Minggu ke-1) --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-stone-100 pb-5 mb-6">
                    <h3 class="text-xl font-bold text-stone-900">Minggu ke-1</h3>
                    
                    {{-- Badge Status (Contoh: Dibagikan) --}}
                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                        Dibagikan ke guru BK
                    </span>
                </div>

                {{-- Isi Jurnal (Pertanyaan & Jawaban) --}}
                <div class="space-y-6">
                    {{-- Pertanyaan 1 --}}
                    <div>
                        <p class="font-bold text-stone-800 text-base">Apa yang aku pelajari tentang diriku?</p>
                        <p class="text-stone-600 mt-1">saya mendapat ilmu komputer baru</p>
                    </div>

                    {{-- Pertanyaan 2 --}}
                    <div>
                        <p class="font-bold text-stone-800 text-base">Bagaimana kepribadianku tampak di situasi nyata?</p>
                        <p class="text-stone-600 mt-1">saya terlihat bahagia</p>
                    </div>

                    {{-- Pertanyaan 3 --}}
                    <div>
                        <p class="font-bold text-stone-800 text-base">Apa langkahku berikutnya?</p>
                        <p class="text-stone-600 mt-1">saya mau tidur</p>
                    </div>
                </div>

                {{-- Kotak Umpan Balik Guru --}}
                <div class="mt-8 bg-[#f2fbf9] border border-brand-100 rounded-xl p-5">
                    <p class="text-xs font-bold text-brand-700 uppercase tracking-wide mb-1">Umpan balik guru BK</p>
                    <p class="text-stone-800">jos</p>
                </div>

                {{-- Tombol Aksi (Edit & Hapus) --}}
                <div class="mt-6 flex items-center gap-4">
                    <a href="#" class="text-sm font-semibold text-stone-600 hover:text-stone-900 transition-colors">Edit</a>
                    <button class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                </div>

            </div>
        </div>

        {{-- Contoh Kartu Jurnal Minggu Sebelumnya (Bisa dihapus/di-looping) --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm mt-6 p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-stone-100 pb-5 mb-6">
                <h3 class="text-xl font-bold text-stone-900">Minggu ke-2</h3>
                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-stone-100 text-stone-500 border border-stone-200">
                    Pribadi
                </span>
            </div>
            <div class="space-y-6">
                <div>
                    <p class="font-bold text-stone-800 text-base">Apa yang aku pelajari tentang diriku?</p>
                    <p class="text-stone-600 mt-1">Saya belajar kalau saya lebih fokus kalau belajar sambil dengar musik.</p>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-4">
                <a href="#" class="text-sm font-semibold text-stone-600 hover:text-stone-900 transition-colors">Edit</a>
                <button class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors">Hapus</button>
            </div>
        </div>

    </div>
</x-app-layout>