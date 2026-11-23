<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Halo, ' . Auth::user()->name) }} 👋
                </h2>
                <p class="text-sm text-stone-500 mt-1">Selamat datang kembali. Apa yang kamu pikirkan hari ini?</p>
            </div>
            <div class="text-sm font-medium text-stone-600 bg-stone-100 px-4 py-2 rounded-lg border border-stone-200/60 shadow-sm">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8 mt-2">
        
        {{-- Baris 1: Kartu Statistik (Gaya Bersih & Terang) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- Kartu 1 --}}
            <div class="bg-white border border-stone-200 p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] flex items-center gap-5 transition-all hover:border-brand-300">
                <div class="p-3.5 bg-brand-50 text-brand-600 rounded-xl shrink-0">
                    <x-icon name="jurnal" class="h-7 w-7" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-stone-500 tracking-wide">Jurnal Minggu Ini</p>
                    <p class="text-3xl font-bold text-stone-900 mt-1">3 <span class="text-base font-medium text-stone-400">entri</span></p>
                </div>
            </div>

            {{-- Kartu 2 --}}
            <div class="bg-white border border-stone-200 p-6 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] flex items-center gap-5 transition-all hover:border-brand-300">
                <div class="p-3.5 bg-stone-100 text-stone-600 rounded-xl shrink-0">
                    <x-icon name="konsultasi" class="h-7 w-7" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-stone-500 tracking-wide">Status Konsultasi</p>
                    <p class="text-xl font-bold text-stone-900 mt-1.5">Kosong</p>
                </div>
            </div>
        </div>

        {{-- Baris 2: Call to Action (Lebih menonjol) --}}
        <div class="bg-gradient-to-r from-brand-600 to-brand-500 rounded-2xl shadow-md overflow-hidden relative">
            <div class="p-7 sm:p-9 flex flex-col sm:flex-row sm:items-center justify-between gap-6 relative z-10">
                <div>
                    <h3 class="text-xl font-bold text-white">Mulai Refleksi Hari Ini</h3>
                    <p class="text-sm text-brand-50 mt-1.5 max-w-md leading-relaxed">Tulis apa yang kamu rasakan, pikirkan, atau pelajari hari ini. Jurnal membantumu mengenal diri lebih baik.</p>
                </div>
                <a href="{{ route('siswa.journals.create') }}" class="shrink-0 flex items-center justify-center gap-2 bg-white text-brand-700 hover:bg-stone-50 px-5 py-3 rounded-xl font-bold text-sm transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tulis Jurnal
                </a>
            </div>
        </div>

        {{-- Baris 3: Jurnal Terakhir --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100 flex justify-between items-center bg-stone-50/50">
                <h3 class="font-bold text-stone-800">Jurnal Terakhirmu</h3>
                <a href="{{ route('siswa.journals.index') }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700 transition-colors">Lihat Semua</a>
            </div>
            <div class="divide-y divide-stone-100">
                {{-- Item 1 --}}
                <div class="p-6 hover:bg-stone-50 transition-colors cursor-pointer group">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-stone-800 group-hover:text-brand-600 transition-colors">Perasaan hari ini</h4>
                        <span class="text-xs font-medium text-stone-400 bg-stone-100 px-2 py-1 rounded-md">Hari ini, 10:30</span>
                    </div>
                    <p class="text-sm text-stone-500 line-clamp-2 leading-relaxed">Hari ini aku merasa cukup senang karena nilai ulangan matematikaku bagus. Tapi tadi sempat deg-degan...</p>
                </div>
                {{-- Item 2 --}}
                <div class="p-6 hover:bg-stone-50 transition-colors cursor-pointer group">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-bold text-stone-800 group-hover:text-brand-600 transition-colors">Rencana besok</h4>
                        <span class="text-xs font-medium text-stone-400 bg-stone-100 px-2 py-1 rounded-md">Kemarin, 19:15</span>
                    </div>
                    <p class="text-sm text-stone-500 line-clamp-2 leading-relaxed">Besok mau mulai belajar lebih awal buat persiapan ujian akhir semester. Aku harus kurangi main HP...</p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>