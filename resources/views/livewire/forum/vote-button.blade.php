<div class="flex flex-col items-center gap-2">
    <button wire:click="vote('upvote')" 
            class="vote-btn upvote {{ $currentVote === 'upvote' ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
        </svg>
    </button>

    <span class="vote-score {{ $score > 0 ? 'positive' : ($score < 0 ? 'negative' : '') }}">
        {{ $score }}
    </span>

    <button wire:click="vote('downvote')" 
            class="vote-btn downvote {{ $currentVote === 'downvote' ? 'active' : '' }}">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </button>
</div>

