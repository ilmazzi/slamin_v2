<div class="flex items-center {{ $layout === 'vertical' ? 'flex-col' : 'gap-6' }}">
    
    <!-- Like Button -->
    <button 
        wire:click="toggleLike"
        class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-red-600 dark:hover:text-red-500 transition-all duration-300 group {{ $layout === 'vertical' ? 'flex-col' : '' }}"
        @class([
            'text-red-600 dark:text-red-500' => $isLiked,
        ])>
        @if($isLiked)
            <!-- Filled Heart -->
            <svg class="group-hover:scale-125 transition-transform duration-300 {{ $size === 'small' ? 'w-4 h-4' : ($size === 'large' ? 'w-7 h-7' : 'w-5 h-5') }}" 
                 fill="currentColor" viewBox="0 0 24 24">
                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
            </svg>
        @else
            <!-- Outline Heart -->
            <svg class="group-hover:scale-125 transition-transform duration-300 {{ $size === 'small' ? 'w-4 h-4' : ($size === 'large' ? 'w-7 h-7' : 'w-5 h-5') }}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        @endif
        
        @if($showCounts)
            <span class="font-medium {{ $size === 'small' ? 'text-xs' : ($size === 'large' ? 'text-lg' : 'text-sm') }}">
                {{ $likesCount }}
            </span>
        @endif
    </button>

    <!-- Comments Button -->
    <button 
        wire:click="openComments"
        class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-all duration-300 group {{ $layout === 'vertical' ? 'flex-col' : '' }}">
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
        wire:click="share"
        class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 dark:hover:text-primary-500 transition-all duration-300 group {{ $layout === 'vertical' ? 'flex-col' : '' }}">
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

