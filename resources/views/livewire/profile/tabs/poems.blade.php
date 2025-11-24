{{-- Poems Tab - con riferimento grafico Paper Sheet e animazioni --}}
<div class="space-y-6" 
     x-data="{ mounted: false }"
     x-init="mounted = true">
    
    {{-- Header con Paper Sheet animato --}}
    <div class="flex items-center gap-4 mb-6"
         x-show="mounted"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-x-4"
         x-transition:enter-end="opacity-100 translate-x-0">
        <div class="hero-paper-wrapper group cursor-pointer transform transition-all duration-500 hover:scale-110 hover:rotate-3" style="width: 80px; height: 80px;">
            <div class="hero-paper-sheet">
                <div class="flex items-center justify-center h-full">
                    <svg class="w-8 h-8 text-neutral-700 dark:text-neutral-300 transform transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                {{ __('profile.poems.title') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.poems.subtitle', ['count' => $stats['poems']]) }}</p>
        </div>
    </div>

    {{-- Poems Grid con animazioni e stile simile alla home --}}
    @if($poems->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($poems as $i => $poem)
                <div class="poetry-card-container fade-scale-item group cursor-pointer"
                     style="animation-delay: {{ $i * 0.1 }}s;"
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     onclick="Livewire.dispatch('openPoemModal', { poemId: {{ $poem->id }} })">
                    
                    <?php
                        $paperRotation = rand(-2, 2);
                    ?>
                    
                    {{-- Paper Sheet on Desk --}}
                    <div class="paper-sheet-wrapper" style="transform: rotate({{ $paperRotation }}deg);">
                        <div class="paper-sheet">
                            
                            {{-- Author Avatar & Name --}}
                            <div class="paper-author-info">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($poem->user, 80) }}" 
                                     alt="{{ $poem->user->name }}"
                                     class="paper-avatar transform transition-transform duration-300 group-hover:scale-110">
                                <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($poem->user) }}" 
                                   class="paper-author-name hover:underline transition-colors"
                                   onclick="event.stopPropagation();">
                                    {{ \App\Helpers\AvatarHelper::getDisplayName($poem->user) }}
                                </a>
                            </div>
                            
                            {{-- Poem Title --}}
                            <h3 class="paper-title transform transition-transform duration-300 group-hover:scale-105">
                                "{{ $poem->title ?: __('poems.untitled') }}"
                            </h3>
                            
                            {{-- Poem Content --}}
                            <div class="paper-content">
                                {{ $poem->description ?? Str::limit(strip_tags($poem->content), 180) }}
                            </div>
                            
                            {{-- Read more hint --}}
                            <div class="paper-readmore transform transition-all duration-300 group-hover:translate-x-2">
                                {{ __('common.read_more') }} →
                            </div>
                            
                            {{-- Social Actions - Inside Paper --}}
                            <div class="paper-actions-integrated" @click.stop>
                                <x-like-button 
                                    :itemId="$poem->id"
                                    itemType="poem"
                                    :isLiked="$poem->is_liked ?? false"
                                    :likesCount="$poem->like_count ?? 0"
                                    size="sm" />
                                
                                <x-comment-button 
                                    :itemId="$poem->id"
                                    itemType="poem"
                                    :commentsCount="$poem->comment_count ?? 0"
                                    size="sm" />
                                
                                <x-share-button 
                                    :itemId="$poem->id"
                                    itemType="poem"
                                    size="sm" />
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($poems->hasPages())
        <div class="mt-6">
            {{ $poems->links() }}
        </div>
        @endif
    @else
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-12 text-center border border-neutral-200 dark:border-neutral-700"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-600 mx-auto mb-4 transform transition-transform duration-300 hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.poems.empty') }}</p>
        </div>
    @endif
</div>

