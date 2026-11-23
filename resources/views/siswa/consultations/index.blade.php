<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-stone-900 leading-tight">
                {{ __('Kamu tidak harus sendiri.') }}
            </h2>
            <p class="text-sm font-semibold text-stone-500 mt-1">Konsultasi</p>
            <p class="text-base text-stone-600 mt-2">Mari kita bicarakan apa yang ada di pikiranmu.</p>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-4 space-y-6">
        
        {{-- Baris Atas: Form & Ilustrasi --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
            
            {{-- Kolom Kiri: Form Pengajuan --}}
            <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
                <h3 class="text-xl font-bold text-stone-900 mb-5">Ajukan konsultasi</h3>
                
                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="topic" class="block text-sm font-semibold text-stone-700 mb-2">Topik yang ingin dibicarakan</label>
                        <textarea id="topic" name="topic" rows="4" required
                            class="w-full rounded-xl border-stone-200 bg-stone-50 text-base shadow-sm focus:border-[#2b8577] focus:ring-[#2b8577] placeholder-stone-400"
                            placeholder="Apa yang ingin kamu ceritakan?"></textarea>
                        <p class="text-xs text-stone-500 mt-2">Permintaan ini hanya bisa dilihat oleh guru BK.</p>
                    </div>
                    
                    <button type="submit" class="inline-flex justify-center items-center bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                        Ajukan Konsultasi
                    </button>
                </form>
            </div>

            {{-- Kolom Kanan: Ilustrasi & Privasi --}}
            <div class="bg-[#faf9f6] border border-stone-200 rounded-2xl shadow-sm relative overflow-hidden flex flex-col items-center justify-center p-8 text-center min-h-[300px]">
                {{-- Background Ilustrasi Daun Besar (Diperbesar) --}}
                <div class="absolute inset-0 opacity-40 pointer-events-none flex items-center justify-center">
                    <x-leaf-decoration class="w-[120%] h-[120%] max-w-none" />
                </div>

                {{-- Ikon Kecil Tengah --}}
                <div class="relative z-10 bg-white p-3 rounded-full shadow-sm mb-4">
                    <svg class="w-8 h-8 text-[#2b8577]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>

                <h4 class="relative z-10 text-lg font-bold text-stone-800">Privasi Anda terjaga bersama guru BK.</h4>
                <p class="relative z-10 text-stone-600 mt-2 text-sm">Ceritakan dengan aman.</p>
            </div>
        </div>

        {{-- Baris Bawah: Riwayat Permintaan --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-stone-100 bg-stone-50/50">
                <h3 class="font-bold text-stone-800">Riwayat Permintaan</h3>
            </div>
            
            <div class="divide-y divide-stone-100">
                {{-- Item Riwayat 1 --}}
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-stone-50 transition-colors">
                    <div>
                        <p class="font-semibold text-stone-900 text-base">saya ingin membicarakan tentang perkuliahan</p>
                        <p class="text-sm text-stone-500 mt-1">22 Nov 2026</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-bold bg-[#fef9c3] text-[#a16207] border border-[#fef08a] shrink-0">
                        Menunggu
                    </span>
                </div>

                {{-- Item Riwayat 2 (Contoh Status Selesai) --}}
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-stone-50 transition-colors">
                    <div>
                        <p class="font-semibold text-stone-900 text-base">Masalah pertemanan di kelas</p>
                        <p class="text-sm text-stone-500 mt-1">10 Nov 2026</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-bold bg-[#dcfce7] text-[#166534] border border-[#bbf7d0] shrink-0">
                        Selesai
                    </span>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>