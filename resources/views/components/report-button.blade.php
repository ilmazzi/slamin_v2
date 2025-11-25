@props([
    'itemId',
    'itemType',
    'isReported' => false,
    'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
];
$iconSize = $sizeClasses[$size] ?? $sizeClasses['md'];

$textSizeClasses = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
$textSize = $textSizeClasses[$size] ?? $textSizeClasses['md'];
@endphp

<div x-data="{ 
    reported: {{ $isReported ? 'true' : 'false' }},
    
    openReportModal() {
        @guest
            this.$dispatch('notify', { 
                message: '{{ __('report.login_required') }}', 
                type: 'warning' 
            });
            return;
        @endguest
        
        if (this.reported) {
            this.$dispatch('notify', { 
                message: '{{ __('report.already_reported') }}', 
                type: 'info' 
            });
            return;
        }
        
        // Dispatch event per aprire modal
        this.$dispatch('open-report-modal', {
            itemId: {{ $itemId }},
            itemType: '{{ $itemType }}'
        });
    }
}" {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    <button type="button"
            @click="openReportModal()"
            :disabled="reported"
            :title="reported ? '{{ __('report.already_reported') }}' : '{{ __('report.report_content') }}'"
            class="flex items-center gap-1.5 transition-all duration-300 group cursor-pointer hover:opacity-80"
            :class="{ 'opacity-50 cursor-not-allowed': reported }">
        <svg class="{{ $iconSize }} transition-all duration-300" 
             :class="{ 'text-red-500': reported, 'text-neutral-500 group-hover:text-red-500': !reported }"
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
        </svg>
        <span class="font-medium {{ $textSize }}" 
              :class="{ 'text-red-500': reported, 'text-neutral-500 group-hover:text-red-500': !reported }"
              x-show="!reported">
            {{ __('report.report') }}
        </span>
        <span class="font-medium {{ $textSize }} text-red-500" 
              x-show="reported">
            {{ __('report.reported') }}
        </span>
    </button>
</div>

