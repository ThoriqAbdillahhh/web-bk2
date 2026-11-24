<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-brand-800">{{ $mission->title }}</p>
                <h1 class="mt-1 text-2xl font-bold leading-tight text-stone-900">{{ $challenge->exists ? 'Edit tantangan' : 'Tambah tantangan' }}</h1>
            </div>
            <a href="{{ route('admin.missions.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Kembali ke misi</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
        <form method="POST" action="{{ $challenge->exists ? route('admin.challenges.update', [$mission, $challenge]) : route('admin.challenges.store', $mission) }}" class="space-y-6 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
            @csrf
            @if ($challenge->exists)
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

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-stone-800">Nama tantangan</label>
                    <input id="title" name="title" type="text" maxlength="255" required value="{{ old('title', $challenge->title) }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                </div>
                <div>
                    <label for="challenge_type" class="mb-2 block text-sm font-semibold text-stone-800">Jenis tantangan</label>
                    <select id="challenge_type" name="challenge_type" required x-data x-on:change="$dispatch('challenge-type-change', $event.target.value)" @disabled($optionsLocked) class="block w-full rounded-xl border-stone-300 bg-white text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                        <option value="choice" @selected(old('challenge_type', $challenge->challenge_type ?: 'choice') === 'choice')>Pilih strategi</option>
                        <option value="ordering" @selected(old('challenge_type', $challenge->challenge_type) === 'ordering')>Susun urutan</option>
                    </select>
                    @if ($optionsLocked)
                        <input type="hidden" name="challenge_type" value="{{ $challenge->challenge_type }}">
                    @endif
                </div>
                <div>
                    <label for="level" class="mb-2 block text-sm font-semibold text-stone-800">Tingkat tantangan</label>
                    <input id="level" name="level" type="number" min="1" max="20" required value="{{ old('level', $challenge->level ?: 1) }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                </div>
                <div>
                    <label for="position" class="mb-2 block text-sm font-semibold text-stone-800">Urutan pada tingkat ini</label>
                    <input id="position" name="position" type="number" min="1" max="65535" required value="{{ old('position', $challenge->position ?: 1) }}" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                </div>
            </div>

            <div>
                <label for="prompt" class="mb-2 block text-sm font-semibold text-stone-800">Skenario atau pertanyaan</label>
                <textarea id="prompt" name="prompt" rows="4" maxlength="3000" required class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('prompt', $challenge->prompt) }}</textarea>
            </div>
            <div>
                <label for="instructions" class="mb-2 block text-sm font-semibold text-stone-800">Instruksi tambahan (opsional)</label>
                <textarea id="instructions" name="instructions" rows="3" maxlength="3000" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">{{ old('instructions', $challenge->instructions) }}</textarea>
            </div>

            <section x-data="{
                type: @js(old('challenge_type', $challenge->challenge_type ?: 'choice')),
                options: @js(array_values($options)).map((option, index) => ({ ...option, key: option.key || 'option-' + index })),
                nextKey: 0,
                addOption() {
                    if (this.options.length < 6) {
                        this.options.push({ key: 'new-' + this.nextKey++, label: '', feedback: '', is_correct: false, correct_position: null });
                    }
                },
                removeOption(index) {
                    if (this.options.length > 2) {
                        this.options.splice(index, 1);
                    }
                },
                moveOption(index, direction) {
                    const target = index + direction;
                    if (target >= 0 && target < this.options.length) {
                        [this.options[index], this.options[target]] = [this.options[target], this.options[index]];
                    }
                }
            }" x-on:challenge-type-change.window="type = $event.detail" class="space-y-4 border-t border-stone-200 pt-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-stone-900">Pilihan dan umpan balik</h2>
                        <p class="mt-1 text-sm leading-6 text-stone-600">Setiap pilihan perlu alasan yang membantu siswa menentukan langkah berikutnya. Maksimal enam pilihan.</p>
                    </div>
                    <button type="button" x-on:click="addOption()" x-bind:disabled="options.length >= 6 || {{ $optionsLocked ? 'true' : 'false' }}" class="rounded-lg border border-stone-300 px-3 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-50 disabled:cursor-not-allowed disabled:opacity-60">Tambah pilihan</button>
                </div>

                @if ($optionsLocked)
                    <p class="rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm leading-6 text-amber-950">Pilihan dikunci karena tantangan ini sudah memiliki jawaban siswa. Kamu tetap dapat mengubah judul, skenario, instruksi, dan status aktif.</p>
                @endif

                <fieldset @disabled($optionsLocked) class="space-y-4">
                    <template x-for="(option, index) in options" :key="option.key">
                        <div class="space-y-4 rounded-xl border border-stone-200 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="font-semibold text-stone-900" x-text="'Pilihan ' + (index + 1)"></h3>
                                <div class="flex gap-2">
                                    <button type="button" x-on:click="moveOption(index, -1)" x-bind:disabled="index === 0" class="rounded-lg border border-stone-300 px-2.5 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-50 disabled:cursor-not-allowed disabled:opacity-50">Naik</button>
                                    <button type="button" x-on:click="moveOption(index, 1)" x-bind:disabled="index === options.length - 1" class="rounded-lg border border-stone-300 px-2.5 py-1.5 text-xs font-semibold text-stone-700 hover:bg-stone-50 disabled:cursor-not-allowed disabled:opacity-50">Turun</button>
                                    <button type="button" x-on:click="removeOption(index)" x-bind:disabled="options.length <= 2" class="rounded-lg border border-rose-300 px-2.5 py-1.5 text-xs font-semibold text-rose-900 hover:bg-rose-50 disabled:cursor-not-allowed disabled:opacity-50">Hapus pilihan</button>
                                </div>
                            </div>
                            <div>
                                <label x-bind:for="'option-label-' + index" class="mb-2 block text-sm font-semibold text-stone-800">Teks pilihan</label>
                                <textarea x-bind:id="'option-label-' + index" x-bind:name="'options[' + index + '][label]'" x-model="option.label" rows="2" maxlength="1000" required class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700"></textarea>
                            </div>
                            <div>
                                <label x-bind:for="'option-feedback-' + index" class="mb-2 block text-sm font-semibold text-stone-800">Alasan umpan balik untuk pilihan ini</label>
                                <textarea x-bind:id="'option-feedback-' + index" x-bind:name="'options[' + index + '][feedback]'" x-model="option.feedback" rows="3" maxlength="2000" required class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700"></textarea>
                            </div>
                            <label x-show="type === 'choice'" x-bind:for="'option-correct-' + index" class="inline-flex items-center gap-3">
                                <input x-bind:id="'option-correct-' + index" x-bind:name="'options[' + index + '][is_correct]'" type="checkbox" value="1" x-model="option.is_correct" class="rounded border-stone-400 text-brand-700 focus:ring-brand-700">
                                <span class="text-sm font-semibold text-stone-800">Pilihan ini merupakan strategi yang sesuai</span>
                            </label>
                            <div x-show="type === 'ordering'">
                                <label x-bind:for="'option-position-' + index" class="mb-2 block text-sm font-semibold text-stone-800">Urutan benar</label>
                                <input x-bind:id="'option-position-' + index" x-bind:name="'options[' + index + '][correct_position]'" x-model="option.correct_position" type="number" min="1" max="6" x-bind:required="type === 'ordering'" class="block w-full rounded-xl border-stone-300 text-stone-900 shadow-sm focus:border-brand-700 focus:ring-brand-700">
                            </div>
                        </div>
                    </template>
                </fieldset>
            </section>

            <label class="inline-flex items-center gap-3">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $challenge->exists ? $challenge->is_active : true)) class="rounded border-stone-400 text-brand-700 focus:ring-brand-700">
                <span class="text-sm font-semibold text-stone-800">Tantangan aktif</span>
            </label>

            <div class="flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2">Simpan tantangan</button>
                <a href="{{ route('admin.missions.index') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
