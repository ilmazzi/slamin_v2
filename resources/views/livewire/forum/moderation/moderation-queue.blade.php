<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('forum.moderation_queue') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('forum.moderation_queue_description') }}
                </p>
            </div>

            {{-- Tabs --}}
            <div class="bg-white dark:bg-neutral-900 rounded-t-xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex">
                    <button wire:click="$set('activeTab', 'posts')" 
                            class="flex-1 px-6 py-4 font-semibold transition-all {{ $activeTab === 'posts' ? 'text-orange-500 border-b-2 border-orange-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-800' }}">
                        {{ __('forum.pending_posts') }} ({{ $pendingPostsCount }})
                    </button>
                    <button wire:click="$set('activeTab', 'comments')" 
                            class="flex-1 px-6 py-4 font-semibold transition-all {{ $activeTab === 'comments' ? 'text-orange-500 border-b-2 border-orange-500' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-neutral-800' }}">
                        {{ __('forum.pending_comments') }} ({{ $pendingCommentsCount }})
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="bg-white dark:bg-neutral-900 rounded-b-xl p-6">
                @if($activeTab === 'posts')
                    {{-- Pending Posts --}}
                    <div class="space-y-4">
                        @forelse($pendingPosts as $post)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                            {{ $post->title }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-sm text-gray-500">
                                            <span>r/{{ $post->subreddit->name }}</span>
                                            <span>•</span>
                                            <span>by u/{{ $post->user->name }}</span>
                                            <span>•</span>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs font-semibold rounded-full">
                                        {{ __('forum.pending') }}
                                    </span>
                                </div>

                                @if($post->type === 'text' && $post->content)
                                    <p class="text-gray-700 dark:text-gray-300 mb-3 line-clamp-3">{{ $post->content }}</p>
                                @elseif($post->type === 'image' && $post->image_path)
                                    <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="max-w-xs rounded-lg mb-3">
                                @elseif($post->type === 'link' && $post->url)
                                    <a href="{{ $post->url }}" target="_blank" class="text-orange-500 hover:underline mb-3 inline-block">
                                        {{ $post->url }}
                                    </a>
                                @endif

                                <div class="flex gap-2">
                                    <button wire:click="approvePost({{ $post->id }})" 
                                            class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-all">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ __('forum.approve') }}
                                    </button>
                                    <button wire:click="removePost({{ $post->id }})" 
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        {{ __('forum.remove') }}
                                    </button>
                                    <a href="{{ route('forum.post.show', [$post->subreddit, $post]) }}" 
                                       wire:navigate
                                       class="px-4 py-2 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-all">
                                        {{ __('forum.view_full') }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 text-lg">{{ __('forum.no_pending_posts') }}</p>
                            </div>
                        @endforelse
                    </div>
                @else
                    {{-- Pending Comments --}}
                    <div class="space-y-4">
                        @forelse($pendingComments as $comment)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                                            <span>Comment on</span>
                                            <a href="{{ route('forum.post.show', [$comment->post->subreddit, $comment->post]) }}" 
                                               wire:navigate
                                               class="text-orange-500 hover:underline font-semibold">
                                                {{ $comment->post->title }}
                                            </a>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-500">
                                            <span>by u/{{ $comment->user->name }}</span>
                                            <span>•</span>
                                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs font-semibold rounded-full">
                                        {{ __('forum.pending') }}
                                    </span>
                                </div>

                                <p class="text-gray-700 dark:text-gray-300 mb-3 whitespace-pre-line">{{ $comment->content }}</p>

                                <div class="flex gap-2">
                                    <button wire:click="approveComment({{ $comment->id }})" 
                                            class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-all">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ __('forum.approve') }}
                                    </button>
                                    <button wire:click="removeComment({{ $comment->id }})" 
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        {{ __('forum.remove') }}
                                    </button>
                                    <a href="{{ route('forum.post.show', [$comment->post->subreddit, $comment->post]) }}" 
                                       wire:navigate
                                       class="px-4 py-2 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-all">
                                        {{ __('forum.view_context') }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500 text-lg">{{ __('forum.no_pending_comments') }}</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

