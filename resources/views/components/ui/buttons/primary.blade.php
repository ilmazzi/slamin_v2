@props([
    'href' => null,
    'type' => 'button',
    'size' => 'md', // sm, md, lg
    'variant' => 'solid', // solid, outline, ghost
    'icon' => null,
])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 font-bold rounded-xl transition-all duration-300 hover:scale-105 shadow-md';

$sizeClasses = match($size) {
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 md:px-10 py-4 md:py-5 text-base md:text-lg',
    default => 'px-6 py-3 text-base',
};

$variantClasses = match($variant) {
    'solid' => 'bg-primary-600 hover:bg-primary-700 text-white',
    'outline' => 'bg-transparent border-2 border-primary-600 text-primary-600 hover:bg-primary-50',
    'ghost' => 'bg-transparent text-primary-600 hover:bg-primary-50',
    default => 'bg-primary-600 hover:bg-primary-700 text-white',
};

$classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
        @endif
        {{ $slot }}
    </button>
@endif

