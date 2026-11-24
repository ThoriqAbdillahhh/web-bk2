<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-stone-900 leading-tight">
            {{ $user->exists ? 'Edit' : 'Tambah' }} Akun
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-2">
        <form method="POST"
              action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
              class="bg-white border border-stone-200 shadow-sm rounded-2xl p-6 sm:p-8 space-y-5">
            @csrf
            <input type="hidden" name="back_role" value="{{ old('back_role', request('role')) }}">
            <input type="hidden" name="back_page" value="{{ old('back_page', request('page')) }}">
            @if ($user->exists) @method('PUT') @endif

            <div>
                <label for="name" class="block text-sm font-semibold text-stone-700 mb-1">Nama Lengkap</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="nickname" class="block text-sm font-semibold text-stone-700 mb-1">Nama Panggilan (wajib untuk siswa, yang ditampilkan ke guru)</label>
                <input id="nickname" name="nickname" value="{{ old('nickname', $user->nickname) }}"
                       class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                @error('nickname') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-stone-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                       class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-stone-700 mb-1">
                    Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <input id="password" name="password" type="password" {{ $user->exists ? '' : 'required' }}
                       class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            @php $currentRole = old('role', $user->roles->first()?->name ?? 'siswa'); @endphp

            <div>
                <label for="role" class="block text-sm font-semibold text-stone-700 mb-1">Role</label>
                <select id="role" name="role" class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                    <option value="siswa" @selected($currentRole === 'siswa')>Siswa</option>
                    <option value="guru" @selected($currentRole === 'guru')>Guru</option>
                </select>
                @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="classroom_id" class="block text-sm font-semibold text-stone-700 mb-1">Kelas (wajib untuk siswa)</label>
                <select id="classroom_id" name="classroom_id" class="w-full rounded-xl border-stone-200 bg-stone-50 shadow-sm focus:border-brand-700 focus:ring-brand-700 text-sm">
                    <option value="">- Pilih kelas -</option>
                    @foreach ($classrooms as $c)
                        <option value="{{ $c->id }}" @selected(old('classroom_id', $user->classroom_id) == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('classroom_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 flex items-center gap-4 border-t border-stone-100">
                <button type="submit" class="bg-brand-700 hover:bg-brand-800 text-white font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm text-sm">
                    Simpan
                </button>
                <a href="{{ route('admin.users.index', array_filter(['role' => old('back_role', request('role')), 'page' => old('back_page', request('page'))])) }}" class="text-sm font-medium text-stone-500 hover:text-stone-800 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>