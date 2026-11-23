<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    {{ __('Dashboard Guru BK') }}
                </h2>
                <p class="text-sm text-stone-500 mt-1">Pantau aktivitas jurnal dan konsultasi siswa.</p>
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
                <h3 class="text-xl font-bold text-stone-900">Selamat datang, Bapak/Ibu Guru.</h3>
                <p class="text-sm text-stone-600 mt-1 max-w-md">Terima kasih telah menjadi pendengar yang baik untuk para siswa hari ini.</p>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-[#e0f5f0] text-[#2b8577] rounded-xl shrink-0">
                    <x-icon name="jurnal" class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Jurnal Belum Dibaca</p>
                    <p class="text-2xl font-bold text-stone-900 mt-0.5">5 <span class="text-sm font-normal text-stone-500">jurnal</span></p>
                </div>
            </div>

            <div class="bg-white border border-stone-200 p-5 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-stone-100 text-stone-600 rounded-xl shrink-0">
                    <x-icon name="konsultasi" class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm font-medium text-stone-500">Jadwal Konsultasi Hari Ini</p>
                    <p class="text-2xl font-bold text-stone-900 mt-0.5">2 <span class="text-sm font-normal text-stone-500">siswa</span></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>