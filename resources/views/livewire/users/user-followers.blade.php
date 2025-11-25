<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-accent-50/20 dark:from-neutral-900 dark:via-primary-950/50 dark:to-accent-950/30 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('user.show', $user) }}" 
                   class="p-2 hover:bg-white/50 dark:hover:bg-neutral-800/50 rounded-lg transition-colors">
                    <svg class="w-6 h-6 text-neutral-700 dark:text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white">
                        {{ __('follow.followers_title', ['name' => $user->name]) }}
                    </h1>
                    <p class="text-neutral-600 dark:text-neutral-400 mt-1">
                        {{ __('follow.followers_count', ['count' => $followers->total()]) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Followers List --}}
        @if($followers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($followers as $follower)
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            {{-- Avatar --}}
                            <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($follower) }}" 
                               class="flex-shrink-0">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($follower, 64) }}" 
                                     alt="{{ $follower->name }}"
                                     class="w-16 h-16 rounded-full object-cover ring-2 ring-primary-200 dark:ring-primary-800">
                            </a>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($follower) }}" 
                                   class="block">
                                    <h3 class="font-semibold text-neutral-900 dark:text-white truncate hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                                        {{ $follower->name }}
                                    </h3>
                                    @if($follower->nickname)
                                        <p class="text-sm text-neutral-500 dark:text-neutral-400 truncate">
                                            {{ '@' . $follower->nickname }}
                                        </p>
                                    @endif
                                </a>

                                {{-- Stats --}}
                                <div class="flex items-center gap-4 mt-2 text-xs text-neutral-600 dark:text-neutral-400">
                                    <span>{{ $follower->poems_count }} {{ __('common.poems_count', ['count' => $follower->poems_count]) }}</span>
                                    <span>•</span>
                                    <span>{{ $follower->articles_count }} {{ __('common.articles_count', ['count' => $follower->articles_count]) }}</span>
                                </div>

                                {{-- Follow Button --}}
                                @auth
                                    @if(Auth::id() !== $follower->id)
                                        <div class="mt-3">
                                            <livewire:components.follow-button :userId="$follower->id" size="sm" variant="outline" />
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $followers->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-12 text-center">
                <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="text-lg font-semibold text-neutral-900 dark:text-white mb-2">
                    {{ __('follow.no_followers') }}
                </p>
                <p class="text-neutral-600 dark:text-neutral-400">
                    {{ __('follow.followers_count', ['count' => 0]) }}
                </p>
            </div>
        @endif
    </div>
</div>
