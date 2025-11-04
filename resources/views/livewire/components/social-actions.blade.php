<div class="flex items-center {{ $layout === 'vertical' ? 'flex-col' : 'gap-6' }}" 
     x-data="{ 
        testClick() { 
            console.log('Button clicked!'); 
            alert('Click funziona! Livewire: ' + (typeof @this !== 'undefined' ? 'OK' : 'NO'));
        } 
     }">
    
    <!-- Like Button -->
    <button 
        type="button"
        wire:click="toggleLike"
        @click="console.log('Like clicked!', $wire)"
        class="flex items-center gap-2 transition-all duration-300 group {{ $layout === 'vertical' ? 'flex-col' : '' }} cursor-pointer relative z-10">
        <img src="{{ asset('assets/icon/new/like.svg') }}" 
             alt="Like" 
             class="group-hover:scale-125 transition-transform duration-300 {{ $size === 'small' ? 'w-4 h-4' : ($size === 'large' ? 'w-7 h-7' : 'w-5 h-5') }}"
             style="{{ $isLiked 
                ? 'filter: brightness(0) saturate(100%) invert(27%) sepia(98%) saturate(2618%) hue-rotate(346deg) brightness(94%) contrast(97%);' 
                : 'filter: brightness(0) saturate(100%) invert(60%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(89%) contrast(86%);' }}">
        
        @if($showCounts)
            <span class="font-medium {{ $size === 'small' ? 'text-xs' : ($size === 'large' ? 'text-lg' : 'text-sm') }}" 
                  style="color: {{ $isLiked ? '#dc2626' : '#525252' }};">
                {{ $likesCount }}
            </span>
        @endif
    </button>

    <!-- Comments Button -->
    <button 
        type="button"
        wire:click="openComments"
        class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-all duration-300 group {{ $layout === 'vertical' ? 'flex-col' : '' }} cursor-pointer">
        <svg class="group-hover:scale-110 transition-transform duration-200 {{ $size === 'small' ? 'w-4 h-4' : ($size === 'large' ? 'w-7 h-7' : 'w-5 h-5') }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        
        @if($showCounts)
            <span class="font-medium {{ $size === 'small' ? 'text-xs' : ($size === 'large' ? 'text-lg' : 'text-sm') }}">
                {{ $commentsCount }}
            </span>
        @endif
    </button>

    <!-- Share Button -->
    <button 
        type="button"
        wire:click="share"
        class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-all duration-300 group {{ $layout === 'vertical' ? 'flex-col' : '' }} cursor-pointer">
        <svg class="group-hover:scale-110 group-hover:rotate-12 transition-all duration-200 {{ $size === 'small' ? 'w-4 h-4' : ($size === 'large' ? 'w-7 h-7' : 'w-5 h-5') }}" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
        </svg>
        
        @if($showCounts && $layout !== 'horizontal')
            <span class="font-medium {{ $size === 'small' ? 'text-xs' : ($size === 'large' ? 'text-lg' : 'text-sm') }}">
                {{ __('common.share') }}
            </span>
        @endif
    </button>

    <!-- Views (if available) -->
    @if($viewsCount > 0)
        <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-500 {{ $layout === 'vertical' ? 'flex-col' : '' }}">
            <svg class="{{ $size === 'small' ? 'w-4 h-4' : ($size === 'large' ? 'w-7 h-7' : 'w-5 h-5') }}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            
            @if($showCounts)
                <span class="font-medium {{ $size === 'small' ? 'text-xs' : ($size === 'large' ? 'text-lg' : 'text-sm') }}">
                    {{ $viewsCount }}
                </span>
            @endif
        </div>
    @endif

</div>

