<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-tight text-stone-900">{{ $mission->exists ? 'Edit misi' : 'Tambah misi' }}</h1>
                <p class="mt-1 text-sm text-stone-600">Tulis instruksi dengan jelas dan ramah untuk siswa.</p>
            </div>
            <a href="{{ route('admin.missions.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kembali ke misi</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
        <form method="POST" action="{{ $mission->exists ? route('admin.missions.update', $mission) : route('admin.missions.store') }}" class="space-y-5 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            @csrf
            @if ($mission->exists)
                @method('PUT')
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-rose-300 bg-rose-50 p-4 text-sm text-rose-950" role="alert">
                    <p class="font-semibold">Periksa isian:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="title" class="mb-2 block text-sm font-semibold text-stone-800">Nama misi</label>
                <input id="title" name="title" type="text" maxlength="255" required value="{{ old('title', $mission->title) }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
            </div>
            <div>
                <label for="slug" class="mb-2 block text-sm font-semibold text-stone-800">Slug unik (huruf, angka, tanda hubung)</label>
                <input id="slug" name="slug" type="text" maxlength="100" required value="{{ old('slug', $mission->slug) }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
            </div>
            <div>
                <label for="sequence" class="mb-2 block text-sm font-semibold text-stone-800">Urutan misi</label>
                <input id="sequence" name="sequence" type="number" min="1" max="65535" required value="{{ old('sequence', $mission->sequence) }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
            </div>
            <div>
                <label for="description" class="mb-2 block text-sm font-semibold text-stone-800">Deskripsi singkat</label>
                <textarea id="description" name="description" rows="3" maxlength="3000" required class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('description', $mission->description) }}</textarea>
            </div>
            <div>
                <label for="instructions" class="mb-2 block text-sm font-semibold text-stone-800">Petunjuk</label>
                <textarea id="instructions" name="instructions" rows="4" maxlength="3000" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('instructions', $mission->instructions) }}</textarea>
            </div>
            <div>
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $mission->exists ? $mission->is_active : true)) class="rounded border-stone-400 text-brand-700 focus:ring-brand-700">
                    <span class="text-sm font-semibold text-stone-800">Misi aktif</span>
                </label>
            </div>
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Simpan misi</button>
                <a href="{{ route('admin.missions.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
