<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Nilai Hidup') }}
                </h2>
            </div>
            <div class="text-sm font-medium text-stone-600 bg-white px-4 py-2 rounded-lg border border-stone-200 shadow-sm">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-2">
        
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
            <p class="text-stone-700 mb-8 max-w-3xl">
                Centang nilai-nilai yang paling berarti buatmu. Tidak ada jawaban benar atau salah, tidak ada urutan atau peringkat. Kamu bisa mengubahnya kapan saja. Catatan ini hanya bisa kamu lihat sendiri.
            </p>

            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    Pilihan nilai hidup tidak valid. Silakan coba lagi.
                </div>
            @endif

            <form action="{{ route('siswa.life_values.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($items as $key => $value)
                        <label class="block cursor-pointer group">
                            {{-- Input Asli (disembunyikan) --}}
                            <input type="checkbox" name="selected[]" value="{{ $key }}" class="hidden" @checked(in_array($key, $selected, true))>
                            
                            {{-- Kotak Visual --}}
                            <div class="flex items-center gap-3 p-4 rounded-xl border border-stone-200 bg-[#faf9f6] transition-all 
                                        group-has-[:checked]:bg-[#e0f5f0] 
                                        group-has-[:checked]:border-[#2b8577] 
                                        group-hover:bg-stone-100">
                                
                                {{-- Kotak Centang Kustom (Ikon) --}}
                                <div class="w-5 h-5 rounded border border-stone-300 bg-white flex items-center justify-center shrink-0 transition-colors
                                            group-has-[:checked]:bg-[#2b8577] 
                                            group-has-[:checked]:border-[#2b8577]">
                                    
                                    {{-- Ikon Centang Putih --}}
                                    <svg class="w-3.5 h-3.5 text-white hidden group-has-[:checked]:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                
                                <span class="font-medium text-sm text-stone-700 group-has-[:checked]:text-[#1e4842]">{{ $value }}</span>
                            </div>
                        </label>
                    @endforeach

                </div>

                {{-- Tombol Simpan --}}
                <div class="mt-8 pt-6 border-t border-stone-100 flex items-center justify-between">
                    <button type="submit" class="inline-flex justify-center items-center bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                        Simpan
                    </button>

                    {{-- Tips Kecil di Kanan --}}
                    <div class="items-center gap-3 text-sm text-stone-500 hidden sm:flex">
                        <div class="w-8 h-8 opacity-60">
                            <x-leaf-decoration class="w-full h-full" />
                        </div>
                        <p class="leading-tight">Pilihanmu bersifat pribadi.<br>Hanya kamu yang bisa melihatnya.</p>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>