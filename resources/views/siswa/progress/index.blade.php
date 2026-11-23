<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Ringkasan Perkembangan') }}
                </h2>
            </div>
            {{-- Tombol Cetak (Otomatis hilang saat di-print berkat class print:hidden di layout) --}}
            <button onclick="window.print()" class="inline-flex items-center gap-2 bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm text-sm print:hidden">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-2 space-y-4 print:mt-0">
        
        {{-- Baris 1: Kartu Nama --}}
        <div class="bg-[#f3e8ff] rounded-2xl p-6 sm:p-8 flex flex-col justify-center border border-purple-100">
            <h3 class="text-xl font-bold text-stone-900">{{ Auth::user()->name ?? 'siswabaru' }}</h3>
            <p class="text-stone-700 mt-1">Kelas X-2</p> {{-- Nanti bisa diganti $student->classroom->name --}}
        </div>

        {{-- Baris 2: Kekuatan & Minat --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Kekuatan --}}
            <div class="bg-[#ffedd5] rounded-2xl p-6 border border-orange-100">
                <h4 class="font-bold text-stone-800 mb-2">Kekuatan</h4>
                <ul class="list-disc list-inside text-stone-800 space-y-1 text-sm">
                    <li>aku pro bikin website</li>
                </ul>
            </div>
            {{-- Minat --}}
            <div class="bg-[#ecfccb] rounded-2xl p-6 border border-lime-200">
                <h4 class="font-bold text-stone-800 mb-2">Minat</h4>
                <ul class="list-disc list-inside text-stone-800 space-y-1 text-sm">
                    <li>aku juga suka gambar</li>
                </ul>
            </div>
        </div>

        {{-- Baris 3: Nilai Hidup & Peta Kepribadian --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Nilai Hidup --}}
            <div class="bg-white border border-stone-200 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-[#f0fdfa] text-[#0f766e] rounded-xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-stone-500">Nilai yang kuanggap penting</p>
                    <p class="text-base font-bold text-stone-900 mt-0.5">Keluarga</p>
                </div>
            </div>

            {{-- Peta Kepribadian --}}
            <div class="bg-white border border-stone-200 rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-[#f5f3ff] text-[#6d28d9] rounded-xl shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-stone-500">Peta Kepribadian</p>
                        <p class="text-base font-bold text-stone-900 mt-0.5">Sudah diisi</p>
                    </div>
                </div>
                <a href="{{ route('siswa.personality.index') ?? '#' }}" class="text-xs font-bold bg-[#2b8577] hover:bg-[#246c62] text-white px-3 py-2 rounded-lg transition-colors">Buka link</a>
            </div>
        </div>

        {{-- Baris 4: Perjalanan Mingguan (Jurnal) --}}
        <div class="bg-white border border-stone-200 rounded-2xl p-6 sm:p-8 shadow-sm">
            <h3 class="text-xl font-bold text-stone-900">Perjalanan dari Minggu ke Minggu</h3>
            <p class="text-sm text-stone-600 mt-1 mb-6">1 jurnal tertulis. Ini catatan perkembanganmu, bukan penilaian.</p>

            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-stone-200 before:to-transparent">
                
                {{-- Item Timeline 1 --}}
                <div class="relative flex items-start gap-4">
                    {{-- Dot --}}
                    <div class="flex items-center justify-center w-5 h-5 rounded-full bg-stone-200 z-10 shrink-0 mt-1">
                        <div class="w-2 h-2 rounded-full bg-stone-500"></div>
                    </div>
                    {{-- Konten --}}
                    <div>
                        <h4 class="font-bold text-stone-900">Minggu ke-1</h4>
                        <ul class="mt-2 space-y-3">
                            <li class="text-sm text-stone-700">
                                <span class="block font-semibold">Yang kupelajari tentang diriku</span>
                                <span class="text-stone-500">saya mendapat ilmu komputer baru</span>
                            </li>
                            <li class="text-sm text-stone-700">
                                <span class="block font-semibold">Langkah berikutnya</span>
                                <span class="text-stone-500">saya mau tidur</span>
                            </li>
                            <li class="text-sm text-stone-700">
                                <span class="block font-semibold">Umpan balik guru BK</span>
                                <span class="text-stone-500">jos</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>