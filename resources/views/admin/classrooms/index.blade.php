<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">Data Kelas</h2>
                <p class="text-sm text-stone-500 mt-1">Daftar kelas yang tersedia di sekolah.</p>
            </div>
            <a href="{{ route('admin.classrooms.create') }}" class="inline-flex items-center justify-center gap-2 bg-brand-700 hover:bg-brand-800 text-white font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kelas
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-2 space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-[#dcfce7] text-[#166534] px-4 py-3 text-sm border border-[#bbf7d0]">{{ session('success') }}</div>
        @endif

        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="divide-y divide-stone-100">
                @forelse ($classrooms as $c)
                    <div class="p-5 flex items-center justify-between hover:bg-stone-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-brand-50 text-brand-700 rounded-xl flex items-center justify-center font-bold text-lg shrink-0">
                                {{ substr($c->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-stone-900">{{ $c->name }}</h4>
                                <p class="text-sm text-stone-500">{{ $c->users_count }} Siswa terdaftar</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.classrooms.edit', $c) }}" class="text-sm font-semibold text-stone-600 hover:text-brand-700 transition-colors px-3 py-1.5 rounded-md hover:bg-stone-100">Edit</a>
                            <form method="POST" action="{{ route('admin.classrooms.destroy', $c) }}" class="inline" onsubmit="return confirm('Hapus kelas ini?')">
                                @csrf @method('DELETE')
                                <button class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors px-3 py-1.5 rounded-md hover:bg-red-50">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-stone-500 text-sm">Belum ada kelas.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>