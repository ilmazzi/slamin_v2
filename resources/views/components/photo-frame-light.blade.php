@props([
    'photo',
    'index' => 0,
    'size' => 'normal' // 'normal', 'small', 'large'
])

<?php
$rotation = rand(-3, 3);
$tapeWidth = rand(60, 90);
$tapeRotation = rand(-8, 8);
$sizeClasses = [
    'small' => 'w-full',
    'normal' => 'w-full',
    'large' => 'w-full'
];
?>

<div class="group cursor-pointer {{ $sizeClasses[$size] }}"
     onclick="Livewire.dispatch('openPhotoModal', { photoId: {{ $photo->id }} })"
     x-data="{ visible: false }" 
     x-intersect.once="visible = true">
    <div x-show="visible"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         style="transition-delay: {{ $index * 100 }}ms">
        
        <div class="photo-polaroid-wrapper">
            <!-- Washi Tape bianco trasparente -->
            <div class="photo-tape-white" 
                 style="width: {{ $tapeWidth }}px; 
                        transform: translateX(-50%) rotate({{ $tapeRotation }}deg);"></div>
            
            <div class="photo-polaroid-card" style="transform: rotate({{ $rotation }}deg);">
                <div class="photo-polaroid-photo">
                    <img src="{{ $photo->image_url }}" 
                         alt="{{ $photo->title ?? __('media.untitled') }}"
                         class="photo-polaroid-img">
                </div>
                
                <div class="photo-polaroid-caption">
                    <div class="text-base font-bold text-neutral-900 line-clamp-2 mb-1" style="font-family: 'Crimson Pro', serif;">
                        {{ $photo->title ?? __('media.untitled') }}
                    </div>
                    @if($photo->user)
                        <div class="text-xs text-neutral-600 mb-1">{{ $photo->user->name }}</div>
                        <div class="text-xs text-neutral-500 mb-2">{{ number_format($photo->view_count ?? 0) }} views</div>
                    @endif
                    
                    {{-- Social Buttons --}}
                    <div class="flex items-center justify-center gap-2.5 mt-1" @click.stop>
                        <x-like-button 
                            :itemId="$photo->id"
                            itemType="photo"
                            :isLiked="false"
                            :likesCount="$photo->like_count ?? 0"
                            size="sm"
                            class="[&_span]:!text-neutral-700 [&_svg]:!text-neutral-700 [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs" />
                        
                        <x-comment-button 
                            :itemId="$photo->id"
                            itemType="photo"
                            :commentsCount="$photo->comment_count ?? 0"
                            size="sm"
                            class="[&_button]:!text-neutral-700 [&_span]:!text-neutral-700 [&_svg]:!stroke-neutral-700 [&_svg]:w-3.5 [&_svg]:h-3.5 [&_span]:text-xs" />
                        
                        <x-share-button 
                            :itemId="$photo->id"
                            itemType="photo"
                            size="sm"
                            class="[&_button]:!text-neutral-700 [&_svg]:!stroke-neutral-700 [&_svg]:w-3.5 [&_svg]:h-3.5" />
                        
                        <x-report-button 
                            :itemId="$photo->id"
                            itemType="photo"
                            size="sm" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Photo Polaroid Light - Minimal Style */
    .photo-polaroid-wrapper {
        position: relative;
        padding-top: 20px;
    }
    
    .photo-tape-white {
        position: absolute;
        top: -8px;
        left: 50%;
        height: 30px;
        background: rgba(255, 255, 255, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        z-index: 10;
        transition: all 0.3s ease;
        clip-path: polygon(
            0% 0%, 2% 5%, 0% 10%, 2% 15%, 0% 20%, 2% 25%, 0% 30%, 2% 35%, 
            0% 40%, 2% 45%, 0% 50%, 2% 55%, 0% 60%, 2% 65%, 0% 70%, 2% 75%, 
            0% 80%, 2% 85%, 0% 90%, 2% 95%, 0% 100%,
            100% 100%,
            98% 95%, 100% 90%, 98% 85%, 100% 80%, 98% 75%, 100% 70%, 98% 65%, 
            100% 60%, 98% 55%, 100% 50%, 98% 45%, 100% 40%, 98% 35%, 100% 30%, 
            98% 25%, 100% 20%, 98% 15%, 100% 10%, 98% 5%, 100% 0%
        );
        backdrop-filter: blur(1px);
    }
    
    .photo-polaroid-card {
        display: block;
        position: relative;
        background: #ffffff;
        padding: 16px 16px 90px 16px;
        box-shadow: 
            0 2px 4px rgba(0, 0, 0, 0.1),
            0 4px 8px rgba(0, 0, 0, 0.08),
            0 8px 16px rgba(0, 0, 0, 0.06),
            0 16px 32px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        border-radius: 2px;
    }
    
    .dark .photo-polaroid-card {
        background: #fafafa;
    }
    
    .photo-polaroid-card:hover {
        transform: translateY(-8px) scale(1.02) !important;
        box-shadow: 
            0 4px 8px rgba(0, 0, 0, 0.12),
            0 8px 16px rgba(0, 0, 0, 0.1),
            0 16px 32px rgba(0, 0, 0, 0.08),
            0 32px 64px rgba(0, 0, 0, 0.06);
    }
    
    .photo-polaroid-photo {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        background: #f5f5f5;
        border-radius: 1px;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
    }
    
    .photo-polaroid-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%);
        transition: all 0.5s ease;
    }
    
    .photo-polaroid-card:hover .photo-polaroid-img {
        filter: grayscale(0%);
        transform: scale(1.05);
    }
    
    .photo-polaroid-caption {
        text-align: center;
        padding-top: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
    }
</style>

