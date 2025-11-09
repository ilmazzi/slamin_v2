@props([
    'label' => '',
    'color' => 'primary', // primary, success, warning, error, info
])

@php
$colorClasses = match($color) {
    'primary' => 'bg-primary-600 text-white',
    'success' => 'bg-success text-white',
    'warning' => 'bg-warning text-white',
    'error' => 'bg-error text-white',
    'info' => 'bg-info text-white',
    default => 'bg-primary-600 text-white',
};

$content = $label ?: $slot;
$hasContent = !empty(trim($content));
@endphp

@if($hasContent)
<span {{ $attributes->merge(['class' => "px-3 md:px-4 py-1.5 md:py-2 rounded-full text-xs font-bold uppercase tracking-wider shadow-lg {$colorClasses}"]) }}>
    {{ $content }}
</span>
@endif

