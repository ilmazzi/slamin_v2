<div>
    @auth
        <button wire:click="toggleWishlist"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-bold transition-all duration-200 {{ $isInWishlist ? 'bg-accent-600 text-white hover:bg-accent-700' : 'bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600' }}"
                title="{{ $isInWishlist ? __('events.remove_from_wishlist') : __('events.add_to_wishlist') }}">
            <svg wire:loading.remove wire:target="toggleWishlist" 
                 class="w-5 h-5" 
                 fill="{{ $isInWishlist ? 'currentColor' : 'none' }}" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                @if($isInWishlist)
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                @endif
            </svg>
            <svg wire:loading wire:target="toggleWishlist" 
                 class="w-5 h-5 animate-spin" 
                 fill="none" 
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="toggleWishlist">
                {{ $isInWishlist ? __('events.in_wishlist') : __('events.add_to_wishlist') }}
            </span>
            <span wire:loading wire:target="toggleWishlist">
                {{ __('common.loading') }}
            </span>
        </button>
    @endauth
    @guest
        <a href="{{ route('login') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg font-bold bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-all duration-200"
           title="{{ __('events.must_login_to_add_wishlist') }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            {{ __('events.add_to_wishlist') }}
        </a>
    @endguest
</div>

