<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Peta Kepribadian</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded bg-green-100 text-green-800 px-4 py-2">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="rounded bg-red-100 text-red-800 px-4 py-2">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <p class="text-sm text-gray-500">
                Tidak ada jawaban benar atau salah, dan tidak ada nilai. Ini gambaran dirimu saat ini,
                bukan label permanen. Kamu bisa mengubahnya kapan saja. Catatan ini hanya bisa kamu lihat sendiri.
            </p>

            <form method="POST" action="{{ route('siswa.personality.update') }}" class="space-y-6">
                @csrf @method('PUT')

                @foreach ($dimensions as $dimKey => $dim)
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">{{ $dim['label'] }}</h3>

                        @foreach ($dim['statements'] as $id => $text)
                            <div class="mb-4">
                                <p class="text-gray-800">{{ $text }}</p>
                                <div class="mt-1 flex gap-4 text-sm text-gray-700">
                                    @foreach ($options as $opt)
                                        <label class="inline-flex items-center gap-1">
                                            <input type="radio" name="answers[{{ $id }}]" value="{{ $opt }}"
                                                   @checked(old("answers.$id", $answers[$id] ?? null) === $opt)>
                                            {{ ucfirst($opt) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <label class="block text-sm text-gray-700">Penjelasan dengan kata-katamu sendiri (boleh kosong)</label>
                        <textarea name="notes[{{ $dimKey }}]" rows="2" maxlength="500"
                                  class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old("notes.$dimKey", $notes[$dimKey] ?? '') }}</textarea>
                    </div>
                @endforeach

                <button class="px-4 py-2 bg-gray-800 text-white rounded text-sm">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>