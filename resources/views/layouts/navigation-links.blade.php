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
            ]],
        ];
    }

    $isDesktop = $mode === 'desktop';
@endphp

<nav aria-label="Navigasi utama" class="px-3 {{ $isDesktop ? 'py-1' : 'py-0' }}">
    @foreach ($menu as $group)
        <ul class="space-y-1">
            @foreach ($group['items'] as [$label, $route, $pattern, $icon])
                @php $active = request()->routeIs($pattern); @endphp
                <li>
                    <a href="{{ route($route) }}"
                       @if ($active) aria-current="page" @endif
                       class="group flex min-h-10 items-center gap-3 rounded-lg px-2.5 text-xs font-medium transition-colors {{ $active ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-stone-50 hover:text-slate-900' }}">
                        <x-adventure-icon :name="$icon" class="h-[18px] w-[18px] shrink-0 {{ $active ? 'text-brand-600' : 'text-slate-500 group-hover:text-slate-700' }}" />
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endforeach
</nav>
