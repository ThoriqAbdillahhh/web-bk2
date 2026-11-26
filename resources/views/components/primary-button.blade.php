<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-lg border border-transparent bg-brand-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-700 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
