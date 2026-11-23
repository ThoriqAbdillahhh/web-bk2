@props(['status', 'label' => null])

@php
    $statusKey = is_string($status) ? strtolower($status) : (string) $status;

    $statuses = [
        'locked' => [
            'label' => 'Belum terbuka',
            'classes' => 'border-stone-300 bg-stone-100 text-stone-800',
        ],
        'available' => [
            'label' => 'Siap dimulai',
            'classes' => 'border-sky-300 bg-sky-50 text-sky-900',
        ],
        'in_progress' => [
            'label' => 'Sedang dikerjakan',
            'classes' => 'border-amber-300 bg-amber-50 text-amber-900',
        ],
        'completed' => [
            'label' => 'Selesai',
            'classes' => 'border-emerald-300 bg-emerald-50 text-emerald-900',
        ],
        'menunggu' => [
            'label' => 'Menunggu',
            'classes' => 'border-amber-300 bg-amber-50 text-amber-900',
        ],
        'diproses' => [
            'label' => 'Diproses',
            'classes' => 'border-sky-300 bg-sky-50 text-sky-900',
        ],
        'selesai' => [
            'label' => 'Selesai',
            'classes' => 'border-emerald-300 bg-emerald-50 text-emerald-900',
        ],
        'belum_diperiksa' => [
            'label' => 'Belum diperiksa',
            'classes' => 'border-stone-300 bg-stone-100 text-stone-800',
        ],
        'berfungsi' => [
            'label' => 'Berfungsi',
            'classes' => 'border-emerald-300 bg-emerald-50 text-emerald-900',
        ],
        'perlu_revisi' => [
            'label' => 'Perlu revisi',
            'classes' => 'border-rose-300 bg-rose-50 text-rose-900',
        ],
    ];

    $variant = $statuses[$statusKey] ?? [
        'label' => \Illuminate\Support\Str::of($statusKey)->replace(['_', '-'], ' ')->title(),
        'classes' => 'border-stone-300 bg-stone-100 text-stone-800',
    ];

    $displayLabel = $label ?? $variant['label'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-semibold leading-4',
    $variant['classes'],
]) }} role="status">
    {{ $displayLabel }}
</span>
