<div>
    <button wire:click="toggleNegotiation" 
            class="relative px-4 py-2 rounded-xl bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-900 dark:text-blue-100 font-medium transition-colors">
        💬 {{ __('negotiations.negotiate') }}
        
        @if($unreadCount > 0)
            <span class="absolute -top-2 -right-2 flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 rounded-full">
                {{ $unreadCount }}
            </span>
        @endif
    </button>
</div>

