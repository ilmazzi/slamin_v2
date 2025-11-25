<div>
    @auth
        @if(Auth::id() !== $userId)
            <button wire:click="toggleFollow" 
                    wire:loading.attr="disabled"
                    class="follow-button follow-button-{{ $size }} follow-button-{{ $variant }} {{ $isFollowing ? 'following' : '' }}"
                    :class="{ 'opacity-50 cursor-not-allowed': $wire.__instance?.effects?.loading }">
                <span wire:loading.remove wire:target="toggleFollow">
                    @if($isFollowing)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('follow.following') }}
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('follow.follow') }}
                    @endif
                </span>
                <span wire:loading wire:target="toggleFollow" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('common.loading') }}
                </span>
            </button>
        @endif
    @endauth
</div>

