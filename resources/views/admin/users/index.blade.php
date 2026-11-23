<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">Data Akun</h2>
                <p class="text-sm text-stone-500 mt-1">Kelola akun siswa dan guru BK.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 bg-brand-700 hover:bg-brand-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Akun
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-2 space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-[#dcfce7] text-[#166534] px-4 py-3 text-sm border border-[#bbf7d0]">{{ session('success') }}</div>
        @endif

        {{-- Filter Tab --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ !$filter ? 'bg-brand-700 text-white shadow-sm' : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">Semua</a>
            <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $filter === 'siswa' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">Siswa</a>
            <a href="{{ route('admin.users.index', ['role' => 'guru']) }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $filter === 'guru' ? 'bg-brand-700 text-white shadow-sm' : 'bg-white border border-stone-200 text-stone-600 hover:bg-stone-50' }}">Guru</a>
        </div>

        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-stone-100">
                @forelse ($users as $u)
                    <div class="p-5 hover:bg-stone-50 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h4 class="font-bold text-stone-900">{{ $u->name }}</h4>
                                <span class="text-xs font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $u->roles->first()?->name === 'guru' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $u->roles->first()?->name }}
                                </span>
                            </div>
                            <p class="text-sm text-stone-500">{{ $u->email }}</p>
                            <p class="text-xs text-stone-400">Panggilan: {{ $u->nickname ?? '-' }} &bull; Kelas: {{ $u->classroom?->name ?? '-' }}</p>
                        </div>
                        
                        <div class="shrink-0 flex items-center gap-2 border-t md:border-t-0 pt-3 md:pt-0 border-stone-100">
                            <a href="{{ route('admin.users.edit', [$u, 'role' => $filter, 'page' => $users->currentPage()]) }}" class="text-sm font-semibold text-stone-600 hover:text-brand-700 transition-colors px-3 py-1.5 rounded-md hover:bg-stone-100">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Hapus akun ini?')">
                                @csrf @method('DELETE')
                                <button class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors px-3 py-1.5 rounded-md hover:bg-red-50">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-stone-500 text-sm">Belum ada akun.</div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</x-app-layout>