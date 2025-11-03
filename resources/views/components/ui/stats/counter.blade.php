@props([
    'number' => 0,
    'label' => '',
    'icon' => null,
    'suffix' => '',
])

@php
// Estrai il numero puro per l'animazione
$cleanNumber = (int)filter_var($number, FILTER_SANITIZE_NUMBER_INT);
$hasSuffix = str_contains($number, 'k') || str_contains($number, '+') || str_contains($number, '%');
$displaySuffix = $suffix ?: ($hasSuffix ? substr($number, -1) : '');
@endphp

<div class="text-center group"
     x-data="{ 
         count: 0, 
         target: {{ $cleanNumber }}, 
         started: false 
     }"
     x-intersect.once="started = true; 
         let duration = 2000;
         let start = Date.now();
         let animate = () => {
             let now = Date.now();
             let progress = Math.min((now - start) / duration, 1);
             count = Math.floor(progress * target);
             if (progress < 1) requestAnimationFrame(animate);
         };
         animate();"
     {{ $attributes }}>
    
    <!-- Icon -->
    @if($icon)
    <div class="inline-flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-primary-100 dark:bg-primary-900/30 rounded-2xl md:rounded-3xl mb-3 md:mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
        <svg class="w-8 h-8 md:w-10 md:h-10 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
    </div>
    @endif
    
    <!-- Number -->
    <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-primary-700 dark:text-primary-400 mb-1 md:mb-2">
        <span x-text="count.toLocaleString()"></span><span>{{ $displaySuffix }}</span>
    </div>
    
    <!-- Label -->
    <div class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 font-medium">
        {{ $label }}
    </div>
</div>

