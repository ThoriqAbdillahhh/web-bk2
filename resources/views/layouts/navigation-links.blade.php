@php
    $user = Auth::user();
    $mode = $mode ?? 'desktop';
    $menu = [];

    if ($user->hasRole('admin')) {
        $menu = [
            ['items' => [
                ['Dashboard', 'admin.dashboard', 'admin.dashboard', 'home'],
                ['Kelas', 'admin.classrooms.index', 'admin.classrooms.*', 'class'],
                ['Akun', 'admin.users.index', 'admin.users.*', 'people'],
                ['Misi', 'admin.missions.index', 'admin.missions.*', 'flag'],
                ['Checklist uji fungsi', 'admin.checks.index', 'admin.checks.*', 'survey'],
            ]],
        ];
    } elseif ($user->hasRole('guru')) {
        $menu = [
            ['items' => [
                ['Dashboard', 'guru.dashboard', 'guru.dashboard', 'home'],
                ['Refleksi siswa', 'guru.reflections.index', 'guru.reflections.*', 'reflection'],
                ['Progres per kelas', 'guru.progress.index', 'guru.progress.*', 'progress'],
                ['Observasi', 'guru.observations.index', 'guru.observations.*', 'observe'],
                ['Rekap angket', 'guru.survey.index', 'guru.survey.*', 'survey'],
                ['Konsultasi', 'guru.consultations.index', 'guru.consultations.*', 'chat'],
            ]],
        ];
    } elseif ($user->hasRole('siswa')) {
        $menu = [
            ['items' => [
                ['Dashboard', 'siswa.dashboard', 'siswa.dashboard', 'home'],
                ['Petunjuk', 'siswa.guide', 'siswa.guide', 'guide'],
                ['Peta petualangan', 'siswa.missions.map', 'siswa.missions.*', 'map'],
                ['Ringkasan', 'siswa.progress.index', 'siswa.progress.*', 'progress'],
                ['Angket respons', 'siswa.survey.show', 'siswa.survey.*', 'survey'],
                ['Konsultasi', 'siswa.consultations.index', 'siswa.consultations.*', 'chat'],
                ['Profil', 'siswa.profile.edit', 'siswa.profile.*', 'people'],
            ]],
        ];
    }

    $isDesktop = $mode === 'desktop';
@endphp

<nav aria-label="Navigasi utama" class="{{ $isDesktop ? 'overflow-x-auto' : '' }}">
    @foreach ($menu as $group)
        <ul class="{{ $isDesktop ? 'flex min-w-max items-center gap-4 py-0' : 'space-y-0.5' }}">
            @foreach ($group['items'] as [$label, $route, $pattern, $icon])
                @php $active = request()->routeIs($pattern); @endphp
                <li>
                    <a href="{{ route($route) }}"
                       @if ($active) aria-current="page" @endif
                       class="group flex min-h-11 items-center gap-2 border-b-2 px-2.5 text-xs font-medium transition-colors {{ $isDesktop ? 'whitespace-nowrap' : 'w-full border-l-2 border-b-0 py-2.5 text-sm' }} {{ $active ? ($isDesktop ? 'border-brand-700 text-brand-900' : 'border-brand-700 bg-stone-50 text-brand-900') : ($isDesktop ? 'border-transparent text-stone-600 hover:border-stone-300 hover:text-stone-900' : 'border-transparent text-stone-600 hover:bg-stone-50 hover:text-stone-900') }}">
                        <x-adventure-icon :name="$icon" class="h-4 w-4 shrink-0 {{ $active ? 'text-brand-700' : 'text-stone-400 group-hover:text-stone-600' }}" />
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach
</nav>
