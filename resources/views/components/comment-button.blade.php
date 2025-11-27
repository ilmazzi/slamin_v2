@props([
    'itemId',
    'itemType',
    'commentsCount' => 0,
    'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = [
    'sm' => 'w-5 h-5',
    'md' => 'w-6 h-6',
    'lg' => 'w-7 h-7',
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];

$textSizeClasses = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
$textSize = $textSizeClasses[$size] ?? $textSizeClasses['md'];
@endphp

<div {{ $attributes->only(['class']) }}>
    <button type="button"
            @click="$dispatch('open-comments', { id: {{ $itemId }}, type: '{{ $itemType }}' })"
            class="flex items-center gap-1 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-all duration-300 group cursor-pointer">
        <svg class="{{ $iconSize }} group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <span class="font-medium {{ $textSize }}">{{ $commentsCount }}</span>
    </button>
</div>

