@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md border-stone-300 text-base shadow-sm focus:border-brand-500 focus:ring-brand-500']) !!}>