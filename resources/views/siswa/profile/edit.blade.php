<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Profil Diri') }}
                </h2>
                <p class="text-sm text-stone-500 mt-1">Kenali dirimu, mulai dari ceritamu.</p>
            </div>
            <div class="text-sm font-medium text-stone-600 bg-white px-4 py-2 rounded-lg border border-stone-200 shadow-sm">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-2">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            {{-- Kolom Kiri: Form --}}
            <div class="lg:col-span-2 bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded bg-green-100 px-4 py-2 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded bg-red-100 px-4 py-2 text-red-800">
                        Profil belum dapat disimpan. Periksa kembali isianmu.
                    </div>
                @endif

                <form action="{{ route('siswa.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Kelas (Readonly) --}}
                    <div>
                        <label class="block text-sm font-medium text-stone-500 mb-1">Kelas</label>
                        <p class="text-base font-semibold text-stone-900">{{ $user->classroom?->name ?? '-' }}</p>
                    </div>

                    {{-- Nama Panggilan --}}
                    <div>
                        <label for="nickname" class="block text-sm font-medium text-stone-700 mb-2">Nama Panggilan</label>
                        <x-text-input id="nickname" name="nickname" type="text" class="w-full bg-stone-50" value="{{ old('nickname', $user->nickname ?? '') }}" required />
                    </div>

                    {{-- Tentang Diriku --}}
                    <div>
                        <label for="bio" class="block text-sm font-medium text-stone-700 mb-2">Tentang Diriku (singkat)</label>
                        <textarea id="bio" name="bio" rows="5" class="w-full rounded-md border-stone-300 bg-stone-50 text-base shadow-sm focus:border-brand-500 focus:ring-brand-500 placeholder-stone-400" placeholder="Ceritakan hal-hal sederhana tentang dirimu...">{{ old('bio', $user->bio ?? '') }}</textarea>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div>
                        <button type="submit" class="inline-flex justify-center items-center bg-[#2b8577] hover:bg-[#246c62] text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Kolom Kanan: Ilustrasi & Quote --}}
            <div class="space-y-4">
                {{-- Kotak Ilustrasi Daun --}}
                <div class="bg-[#faf9f6] border border-stone-200 rounded-2xl shadow-sm relative overflow-hidden h-48">
                    <div class="absolute inset-0 opacity-80 pointer-events-none flex items-center justify-center">
                        <x-leaf-decoration class="w-[150%] h-[150%] max-w-none" />
                    </div>
                </div>

                {{-- Kotak Quote --}}
                <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6 text-center">
                    <p class="text-base text-stone-800 font-medium leading-relaxed">
                        Ceritakan kisahmu dengan kata-katamu sendiri, kami siap mendengarkan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>