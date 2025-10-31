@php
    $baseClasses = 'bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden';
    $hoverClasses = $hover ? 'transition-all hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600' : '';
    $classes = $baseClasses . ' ' . $hoverClasses;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            {{ $header }}
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>
