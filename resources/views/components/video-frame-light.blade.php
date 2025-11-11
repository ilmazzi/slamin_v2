@props([
    'video',
    'index' => 0,
    'size' => 'normal' // 'normal', 'small', 'large'
])

<?php
$tilt = rand(-2, 2);
$sizeClasses = [
    'small' => 'w-64',
    'normal' => 'w-80 md:w-96',
    'large' => 'w-96 md:w-[28rem]'
];
?>

<div class="group cursor-pointer {{ $sizeClasses[$size] }}"
     onclick="Livewire.dispatch('openVideoModal', { videoId: {{ $video->id }} })"
     x-data="{ visible: false }" 
     x-intersect.once="visible = true">
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         style="transition-delay: {{ $index * 100 }}ms">
        
        <div class="video-frame-light" style="transform: rotate({{ $tilt }}deg);">
            <!-- Mini Perforations Left -->
            <div class="video-perf-left">
                @for($h = 0; $h < 5; $h++)
                <div class="video-perf-hole"></div>
                @endfor
            </div>
            
            <!-- Mini Perforations Right -->
            <div class="video-perf-right">
                @for($h = 0; $h < 5; $h++)
                <div class="video-perf-hole"></div>
                @endfor
            </div>
            
            <!-- Frame Number Top-Left -->
            <div class="video-frame-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
            
            <!-- Video Content -->
            <div class="relative aspect-[4/3] overflow-hidden bg-black">
                <img src="{{ $video->thumbnail_url }}" 
                     alt="{{ $video->title }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>

                {{-- Play Icon --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>

                {{-- Title Overlay --}}
                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/90 to-transparent">
                    <h4 class="text-white font-bold text-sm md:text-base line-clamp-2 mb-1" style="font-family: 'Crimson Pro', serif;">
                        {{ $video->title }}
                    </h4>
                    @if($video->user)
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-white/80">{{ $video->user->name }}</span>
                            <span class="text-white/60">• {{ number_format($video->view_count ?? 0) }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Video Frame Light - Minimal Film Border */
    .video-frame-light {
        position: relative;
        padding: 8px;
        background: 
            /* Film texture */
            linear-gradient(135deg, 
                rgba(120, 80, 50, 0.9) 0%,
                rgba(100, 65, 40, 0.92) 50%,
                rgba(120, 80, 50, 0.9) 100%
            );
        border-radius: 4px;
        box-shadow: 
            0 4px 12px rgba(0, 0, 0, 0.3),
            inset 0 1px 2px rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .video-frame-light:hover {
        transform: translateY(-4px) scale(1.02) !important;
        box-shadow: 
            0 8px 20px rgba(0, 0, 0, 0.4),
            inset 0 1px 2px rgba(255, 255, 255, 0.1);
    }
    
    /* Mini Perforations */
    .video-perf-left,
    .video-perf-right {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
        padding: 0.5rem 0;
        background: rgba(80, 55, 35, 0.95);
    }
    
    .video-perf-left {
        left: 0;
    }
    
    .video-perf-right {
        right: 0;
    }
    
    .video-perf-hole {
        width: 6px;
        height: 10px;
        background: #f0ebe8;
        border-radius: 1px;
        flex-shrink: 0;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.4);
    }
    
    .dark .video-perf-hole {
        background: #1a1a1a;
    }
    
    /* Frame Number */
    .video-frame-num {
        position: absolute;
        top: 0.5rem;
        left: 1rem;
        color: rgba(255, 255, 255, 0.35);
        font-size: 0.7rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6);
        z-index: 3;
    }
</style>

