@props([
    'date' => null,
    'format' => 'd M',
])

@php
$formattedDate = $date ? $date->format($format) : now()->format($format);
$day = $date ? $date->format('d') : now()->format('d');
$month = $date ? $date->format('M') : now()->format('M');
@endphp

<div {{ $attributes->merge(['class' => 'bg-white/95 backdrop-blur-md px-4 py-3 rounded-xl shadow-lg transition-transform duration-300']) }}>
    <div class="text-2xl md:text-3xl font-bold text-primary-700">{{ $day }}</div>
    <div class="text-xs md:text-sm text-neutral-600 font-medium uppercase">{{ $month }}</div>
</div>

