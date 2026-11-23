<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Halo, ' . Auth::user()->name) }} 👋
                </h2>
                <p class="text-sm text-stone-500 mt-1">Selamat datang kembali. Apa yang kamu pikirkan hari ini?</p>
            </div>
            <div class="text-sm font-medium text-stone-600 bg-white px-4 py-2 rounded-lg border border-stone-200 shadow-sm">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6 mt-2">
        
        {{-- Hero Card (Dengan Ilustrasi Daun) --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden relative min-h-[160px] flex items-center">
            {{-- Ilustrasi Daun di Kanan --}}
            <div class="absolute -right-4 -top-4 w-64 h-64 opacity-90 hidden sm:block">
                <x-leaf-decoration class="w-full h-full" />
            </div>
            
            <div class="p-6 sm:p-8 relative z-10 max-w-lg">
                <h3 class="text-2xl font-bold text-stone-900">Ruang untuk mengenal dirimu.</h3>
                <p class="text-sm text-stone-600 mt-2 leading-relaxed">Tulis apa yang kamu rasakan, pikirkan, atau pelajari hari ini. Jurnal membantumu mengenal diri lebih baik.</p>
                <x-primary-button class="mt-5 flex items-center gap-2 bg-[#2b8577] hover:bg-[#246c62] text-white px-5 py-2.5 rounded-lg shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tulis Jurnal
                </x-primary-button>
            </div>
        </div>

        {{-- Baris Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- Kartu Jurnal --}}
            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-[#e0f5f0] text-[#2b8577] rounded-xl shrink-0">
                    <x-icon name="jurnal" class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Jurnal Minggu Ini</p>
                    <p class="text-2xl font-bold text-stone-900 mt-0.5">3 <span class="text-sm font-normal text-stone-500">entri</span></p>
                </div>
            </div>

            {{-- Kartu Konsultasi --}}
            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-stone-100 text-stone-600 rounded-xl shrink-0">
                    <x-icon name="konsultasi" class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Status Konsultasi</p>
                    <p class="text-lg font-bold text-stone-900 mt-1">Kosong</p>
                </div>
            </div>
        </div>

        {{-- Baris Konten Bawah --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- List Jurnal (Kiri) --}}
            <div class="lg:col-span-2 bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="px-5 py-4 border-b border-stone-100 flex justify-between items-center bg-stone-50/30">
                    <h3 class="font-bold text-stone-800">Jurnal Terakhirmu</h3>
                    <a href="#" class="text-sm font-semibold text-[#2b8577] hover:text-[#246c62]">Lihat Semua</a>
                </div>
                <div class="divide-y divide-stone-100 flex-1">
                    <div class="p-5 hover:bg-stone-50 transition-colors cursor-pointer group">
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-semibold text-stone-900 group-hover:text-[#2b8577] transition-colors">Perasaan hari ini</h4>
                            <span class="text-xs font-medium text-stone-400 bg-stone-100 px-2 py-1 rounded-md">Hari ini, 10:30</span>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2 leading-relaxed">Hari ini aku merasa cukup senang karena nilai ulangan matematikaku bagus. Tapi tadi sempat deg-degan...</p>
                    </div>
                    <div class="p-5 hover:bg-stone-50 transition-colors cursor-pointer group">
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-semibold text-stone-900 group-hover:text-[#2b8577] transition-colors">Rencana besok</h4>
                            <span class="text-xs font-medium text-stone-400 bg-stone-100 px-2 py-1 rounded-md">Kemarin, 19:15</span>
                        </div>
                        <p class="text-sm text-stone-500 line-clamp-2 leading-relaxed">Besok mau mulai belajar lebih awal buat persiapan ujian akhir semester. Aku harus kurangi main HP...</p>
                    </div>
                </div>
            </div>

            {{-- Tips (Kanan) --}}
            <div class="space-y-4">
                <div class="bg-white border border-stone-200 rounded-2xl p-5 shadow-sm relative overflow-hidden">
                    <h3 class="font-bold text-stone-800 text-sm">Private reflection tip</h3>
                    <p class="text-xs text-stone-500 mt-2 leading-relaxed relative z-10">
                        Tulis apa yang kamu rasakan, pikirkan, atau pelajari hari ini. Jurnal membantumu mengenal diri.
                    </p>
                    {{-- Aksen daun kecil di pojok --}}
                    <div class="absolute -bottom-4 -right-4 w-20 h-20 opacity-50">
                        <x-leaf-decoration class="w-full h-full" />
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>