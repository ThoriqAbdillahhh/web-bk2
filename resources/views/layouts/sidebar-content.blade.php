@php
    $user = Auth::user();
    $role = $user->roles->first()?->name;

    $menu = [];

    if ($user->hasRole('admin')) {
        $menu = [
            ['label' => null, 'items' => [
                ['Dashboard', 'admin.dashboard', 'admin.dashboard', 'dashboard'],
                ['Kelas', 'admin.classrooms.index', 'admin.classrooms.*', 'kelas'],
                ['Akun', 'admin.users.index', 'admin.users.*', 'akun'],
            ]],
        ];
    } elseif ($user->hasRole('guru')) {
        $menu = [
            ['label' => null, 'items' => [
                ['Dashboard', 'guru.dashboard', 'guru.dashboard', 'dashboard'],
                ['Jurnal Siswa', 'guru.journals.index', 'guru.journals.*', 'jurnal'],
                ['Konsultasi', 'guru.consultations.index', 'guru.consultations.*', 'konsultasi'],
            ]],
        ];
    } elseif ($user->hasRole('siswa')) {
        $menu = [
            ['label' => null, 'items' => [
                ['Dashboard', 'siswa.dashboard', 'siswa.dashboard', 'dashboard'],
                ['Jurnal', 'siswa.journals.index', 'siswa.journals.*', 'jurnal'],
                ['Ringkasan', 'siswa.progress.index', 'siswa.progress.*', 'ringkasan'],
                ['Konsultasi', 'siswa.consultations.index', 'siswa.consultations.*', 'konsultasi'],
            ]],
            ['label' => 'Isi Diriku', 'items' => [
                ['Profil Diri', 'siswa.profile.edit', 'siswa.profile.*', 'profil'],
                ['Kekuatan & Minat', 'siswa.strengths.index', 'siswa.strengths.*', 'kekuatan'],
                ['Peta Kepribadian', 'siswa.personality.index', 'siswa.personality.*', 'peta'],
                ['Nilai Hidup', 'siswa.life_values.index', 'siswa.life_values.*', 'nilai'],
            ]],
        ];
    }
@endphp

<div class="flex h-full flex-col">
    <!-- Nama aplikasi -->
    <a href="{{ route('dashboard') }}" class="flex h-16 shrink-0 items-center gap-2.5 border-b border-stone-200 px-5">
        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-brand-600 text-sm font-bold text-white">P</span>
        <span class="font-semibold text-stone-900">Pribadi ID</span>
    </a>

    <!-- Menu -->
    <nav class="flex-1 space-y-5 overflow-y-auto px-3 py-4">
        @foreach ($menu as $group)
            <div>
                @if ($group['label'])
                    <p class="mb-1 px-3 text-xs font-semibold uppercase tracking-wide text-stone-400">{{ $group['label'] }}</p>
                @endif

                <ul class="space-y-0.5">
                    @foreach ($group['items'] as [$label, $route, $pattern, $icon])
                        @php $active = request()->routeIs($pattern); @endphp
                        <li>
                            <a href="{{ route($route) }}"
                               class="flex items-center gap-3 rounded-md px-3 py-2.5 text-base font-medium transition-colors {{ $active ? 'bg-brand-50 text-brand-800' : 'text-stone-600 hover:bg-stone-100 hover:text-stone-900' }}">
                                <x-icon :name="$icon" class="h-5 w-5 shrink-0 {{ $active ? 'text-brand-600' : 'text-stone-400' }}" />
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <!-- Akun pengguna -->
    <div class="shrink-0 border-t border-stone-200 p-3">
        <div class="px-3 pb-2">
            <p class="truncate text-sm font-semibold text-stone-800">{{ $user->name }}</p>
            <p class="text-xs capitalize text-stone-500">{{ $role === 'guru' ? 'Guru BK' : $role }}</p>
        </div>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 rounded-md px-3 py-2.5 text-sm text-stone-600 hover:bg-stone-100">
            <x-icon name="kunci" class="h-5 w-5 text-stone-400" />
            Ganti Password
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-3 rounded-md px-3 py-2.5 text-sm text-stone-600 hover:bg-stone-100">
                <x-icon name="keluar" class="h-5 w-5 text-stone-400" />
                Keluar
            </button>
        </form>
    </div>
</div>