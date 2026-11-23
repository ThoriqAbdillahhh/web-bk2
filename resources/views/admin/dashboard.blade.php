<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
                <p class="text-sm text-stone-500 mt-1">Ringkasan data sistem Pribadi ID.</p>
            </div>
            <div class="text-sm font-medium text-stone-600 bg-white px-4 py-2 rounded-lg border border-stone-200 shadow-sm">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6 mt-2">
        {{-- Hero Card --}}
        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden relative min-h-[140px] flex items-center">
            <div class="absolute -right-4 -top-4 w-56 h-56 opacity-80 pointer-events-none hidden sm:block">
                <x-leaf-decoration class="w-full h-full" />
            </div>
            <div class="p-6 sm:p-8 relative z-10">
                <h3 class="text-xl font-bold text-stone-900">Pusat Kendali Admin</h3>
                <p class="text-sm text-stone-600 mt-1 max-w-md">Kelola akun pengguna, data kelas, dan pantau aktivitas sistem dari sini.</p>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-[#e0f5f0] text-[#2b8577] rounded-xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-stone-900 mt-0.5">124</p>
                </div>
            </div>

            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-[#f5f3ff] text-[#6d28d9] rounded-xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Total Guru BK</p>
                    <p class="text-2xl font-bold text-stone-900 mt-0.5">8</p>
                </div>
            </div>

            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-[#ffedd5] text-[#c2410c] rounded-xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Total Kelas</p>
                    <p class="text-2xl font-bold text-stone-900 mt-0.5">12</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>