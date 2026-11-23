<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                {{ __('Kekuatan & Minat') }}
            </h2>
            <p class="text-sm text-stone-500 mt-1">Catatan di halaman ini hanya bisa kamu lihat sendiri. Tidak ada nilai benar atau salah.</p>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- KOLOM KIRI: KEKUATAN --}}
            <div class="space-y-6">
                {{-- Kartu Daftar Kekuatan --}}
                <div class="bg-white border border-stone-200 rounded-2xl shadow-sm relative overflow-hidden">
                    {{-- Ilustrasi Daun di Pojok Kanan Atas --}}
                    <div class="absolute -right-8 -top-8 w-40 h-40 opacity-40 pointer-events-none">
                        <x-leaf-decoration class="w-full h-full" />
                    </div>

                    <div class="p-6 relative z-10">
                        <h3 class="text-xl font-bold text-stone-900 mb-4">Kekuatanku</h3>
                        
                        {{-- Contoh Item Kekuatan (Nanti di-looping pakai @foreach dari database) --}}
                        <div class="space-y-3">
                            <div class="bg-[#f2fbf9] border border-brand-100 rounded-xl p-4 relative group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-stone-800">aku pro bikin website</p>
                                        <p class="text-xs text-stone-500 mt-1">Contoh pengalaman nyata:</p>
                                        <p class="text-sm text-stone-700 mt-0.5">aku pernah magang di pt semen indonesia</p>
                                    </div>
                                    {{-- Tombol Hapus --}}
                                    <button class="text-sm font-medium text-stone-400 hover:text-red-500 transition-colors">Hapus</button>
                                </div>
                            </div>
                            
                            {{-- Kalau kosong, tampilkan pesan ini --}}
                            {{-- <p class="text-sm text-stone-500 text-center py-4">Belum ada kekuatan yang dicatat.</p> --}}
                        </div>
                    </div>
                </div>

                {{-- Form Tambah Kekuatan --}}
                <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6">
                    <h4 class="font-bold text-stone-800 mb-4">Tambah kekuatan</h4>
                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-text-input id="strength_name" name="name" type="text" class="w-full bg-stone-50" placeholder="Misal: Aku pandai menjelaskan sesuatu ke teman" required />
                        </div>
                        <div>
                            <textarea name="experience" rows="3" class="w-full rounded-md border-stone-300 bg-stone-50 text-base shadow-sm focus:border-brand-500 focus:ring-brand-500" placeholder="Contoh pengalaman nyata (boleh kosong)"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold py-2.5 rounded-lg transition-colors shadow-sm">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>

            {{-- KOLOM KANAN: MINAT --}}
            <div class="space-y-6">
                {{-- Kartu Daftar Minat --}}
                <div class="bg-white border border-stone-200 rounded-2xl shadow-sm relative overflow-hidden">
                    {{-- Ilustrasi Daun di Pojok Kanan Atas --}}
                    <div class="absolute -right-8 -top-8 w-40 h-40 opacity-40 pointer-events-none">
                        <x-leaf-decoration class="w-full h-full" />
                    </div>

                    <div class="p-6 relative z-10">
                        <h3 class="text-xl font-bold text-stone-900 mb-4">Minatku</h3>
                        
                        {{-- Contoh Item Minat --}}
                        <div class="space-y-3">
                            <div class="bg-[#f5f3ff] border border-purple-100 rounded-xl p-4 relative group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold text-stone-800">aku juga suka gambar</p>
                                        <p class="text-xs text-stone-500 mt-1">Contoh pengalaman nyata:</p>
                                        <p class="text-sm text-stone-700 mt-0.5">dulu waktu tk suka gambar gunung</p>
                                    </div>
                                    <button class="text-sm font-medium text-stone-400 hover:text-red-500 transition-colors">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Tambah Minat --}}
                <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6">
                    <h4 class="font-bold text-stone-800 mb-4">Tambah minat</h4>
                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <x-text-input id="interest_name" name="name" type="text" class="w-full bg-stone-50" placeholder="Misal: Aku suka menggambar" required />
                        </div>
                        <div>
                            <textarea name="experience" rows="3" class="w-full rounded-md border-stone-300 bg-stone-50 text-base shadow-sm focus:border-brand-500 focus:ring-brand-500" placeholder="Contoh pengalaman nyata (boleh kosong)"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold py-2.5 rounded-lg transition-colors shadow-sm">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>