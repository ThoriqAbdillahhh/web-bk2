<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-stone-900 leading-tight">
            {{ $classroom->exists ? 'Edit' : 'Tambah' }} Kelas
        </h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-2">
        <form method="POST"
              action="{{ $classroom->exists ? route('admin.classrooms.update', $classroom) : route('admin.classrooms.store') }}"
              class="bg-white border border-stone-200 shadow-sm rounded-2xl p-6 sm:p-8">
            @csrf
            @if ($classroom->exists) @method('PUT') @endif

            <div>
                <label for="name" class="block text-sm font-semibold text-stone-700 mb-1">Nama Kelas (mis. VII-1)</label>
                <input id="name" name="name" value="{{ old('name', $classroom->name) }}" required
                       class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6 pt-4 flex items-center gap-4 border-t border-stone-100">
                <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                    Simpan
                </button>
                <a href="{{ route('admin.classrooms.index') }}" class="text-sm font-medium text-stone-500 hover:text-stone-800 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>