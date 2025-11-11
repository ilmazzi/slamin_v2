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
            <!-- SOLO frame number, NO perforazioni -->
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
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/95 to-transparent">
                    <h4 class="text-white font-bold text-sm md:text-base line-clamp-2 mb-2" style="font-family: 'Crimson Pro', serif;">
                        {{ $video->title }}
                    </h4>
                    @if($video->user)
                        <div class="flex items-center gap-2 text-xs mb-2">
                            <span class="text-white/80">{{ $video->user->name }}</span>
                            <span class="text-white/60">• {{ number_format($video->view_count ?? 0) }}</span>
                        </div>
                    @endif
                    
                    {{-- Social Buttons --}}
                    <div class="flex items-center gap-2.5">
                        <x-like-button 
                            :itemId="$video->id"
                            itemType="video"
                            :isLiked="false"
                            :likesCount="$video->like_count ?? 0"
                            size="sm"
                            class="[&_span]:!text-white/90 [&_svg]:!text-white/90 [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs" />
                        
                        <x-comment-button 
                            :itemId="$video->id"
                            itemType="video"
                            :commentsCount="$video->comment_count ?? 0"
                            size="sm"
                            class="[&_button]:!text-white/90 [&_span]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs" />
                        
                        <x-share-button 
                            :itemId="$video->id"
                            itemType="video"
                            size="sm"
                            class="[&_button]:!text-white/90 [&_svg]:!stroke-white [&_svg]:w-3.5 [&_svg]:h-3.5" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Video Frame Light - ESSENZIALE */
    .video-frame-light {
        position: relative;
        background: transparent;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 
            0 4px 16px rgba(0, 0, 0, 0.15),
            0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .video-frame-light:hover {
        transform: translateY(-6px) scale(1.03) !important;
        box-shadow: 
            0 8px 24px rgba(0, 0, 0, 0.2),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Frame Number - Badge minimal */
    .video-frame-num {
        position: absolute;
        top: 1rem;
        left: 1rem;
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        z-index: 3;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        padding: 0.35rem 0.65rem;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

