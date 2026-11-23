<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $journal->exists ? 'Edit' : 'Tulis' }} Jurnal
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST"
                  action="{{ $journal->exists ? route('siswa.journals.update', $journal) : route('siswa.journals.store') }}"
                  class="bg-white shadow-sm rounded-lg p-6 space-y-4">
                @csrf
                @if ($journal->exists) @method('PUT') @endif

                <div>
                    <x-input-label for="week_no" value="Minggu ke-" />
                    <x-text-input id="week_no" name="week_no" type="number" min="1" max="52"
                                  class="mt-1 block w-32" :value="old('week_no', $journal->week_no)" required />
                    <x-input-error :messages="$errors->get('week_no')" class="mt-2" />
                </div>

                @foreach ([
                    'q1' => 'Apa yang aku pelajari tentang diriku minggu ini?',
                    'q2' => 'Bagaimana kepribadianku tampak di situasi nyata?',
                    'q3' => 'Apa langkahku berikutnya?',
                ] as $field => $label)
                    <div>
                        <x-input-label :for="$field" :value="$label" />
                        <textarea id="{{ $field }}" name="{{ $field }}" rows="4" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old($field, $journal->$field) }}</textarea>
                        <x-input-error :messages="$errors->get($field)" class="mt-2" />
                    </div>
                @endforeach

                <label class="flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_shared" value="1"
                           class="mt-1 rounded border-gray-300"
                           @checked(old('is_shared', $journal->is_shared))>
                    <span>Bagikan jurnal ini ke guru BK. Kalau tidak dicentang, jurnal hanya bisa dilihat olehmu.</span>
                </label>

                <div class="flex gap-3 items-center">
                    <x-primary-button>Simpan</x-primary-button>
                    <a href="{{ route('siswa.journals.index') }}" class="text-sm text-gray-600">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>