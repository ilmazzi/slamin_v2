{{-- Articles Tab - con riferimento grafico Magazine e animazioni --}}
<div class="space-y-6" 
     x-data="{ mounted: false }"
     x-init="mounted = true">
    
    {{-- Header con Magazine animato --}}
    <div class="flex items-center gap-4 mb-6"
         x-show="mounted"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-x-4"
         x-transition:enter-end="opacity-100 translate-x-0">
        <div class="hero-magazine-wrapper-large group cursor-pointer transform transition-all duration-500 hover:scale-110 hover:rotate-3" style="width: 80px; height: 80px;">
            <div class="hero-magazine-cover-large">
                <div class="hero-magazine-inner-large">
                    <div class="text-xs font-bold text-neutral-900 dark:text-white">SLAMIN</div>
                    <div class="h-px bg-gradient-to-r from-neutral-900 dark:from-neutral-100 via-neutral-400 to-neutral-900 dark:to-neutral-100 my-1"></div>
                    <div class="text-xs text-neutral-700 dark:text-neutral-300">ART</div>
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white" style="font-family: 'Playfair Display', serif;">
                {{ __('profile.articles.title') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.articles.subtitle', ['count' => $stats['articles']]) }}</p>
        </div>
    </div>

    {{-- Articles List con stile Magazine --}}
    @if($articles->count() > 0)
        <div class="space-y-6">
            @foreach($articles as $i => $article)
                <?php
                    $rotation = rand(-3, 3);
                    $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
                    $pinRotation = rand(-15, 15);
                ?>
                <article class="magazine-article-wrapper fade-scale-item group cursor-pointer"
                         style="animation-delay: {{ $i * 0.1 }}s;"
                         x-intersect.once="$el.classList.add('animate-fade-in')"
                         onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $article->id }} })">
                    
                    {{-- Thumbtack/Puntina --}}
                    <div class="thumbtack" 
                         style="background: {{ $pinColor }}; transform: rotate({{ $pinRotation }}deg);">
                        <div class="thumbtack-needle"></div>
                    </div>
                    
                    {{-- Magazine Cover --}}
                    <div class="magazine-cover" style="transform: rotate({{ $rotation }}deg);">
                        <div class="magazine-inner">
                            
                            {{-- Magazine Header --}}
                            <div class="magazine-header">
                                <div class="magazine-logo">SLAMIN</div>
                                <div class="magazine-issue">Vol. {{ date('Y') }} · N.{{ str_pad($article->id, 2, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            
                            {{-- Category Badge --}}
                            @if($article->category)
                            <div class="magazine-category">
                                {{ $article->category->name }}
                            </div>
                            @endif
                            
                            {{-- Featured Image --}}
                            @if($article->featured_image_url)
                            <div class="magazine-image">
                                <img src="{{ $article->featured_image_url }}" 
                                     alt="{{ $article->title }}"
                                     class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                            </div>
                            @endif
                            
                            {{-- Article Title --}}
                            <h3 class="magazine-title transform transition-colors duration-300 group-hover:text-primary-600 dark:group-hover:text-primary-400">
                                {{ $article->title }}
                            </h3>
                            
                            {{-- Excerpt --}}
                            <p class="magazine-excerpt">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                            </p>
                            
                            {{-- Author Info with Avatar --}}
                            <div class="magazine-author">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 80) }}" 
                                     alt="{{ $article->user->name }}"
                                     class="magazine-avatar transform transition-transform duration-300 group-hover:scale-110">
                                <div class="magazine-author-info">
                                    <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($article->user) }}" 
                                       class="magazine-author-name hover:underline transition-colors"
                                       onclick="event.stopPropagation();">
                                        {{ \App\Helpers\AvatarHelper::getDisplayName($article->user) }}
                                    </a>
                                    <div class="magazine-author-date">{{ $article->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                            
                        </div>
                        
                        {{-- Social Actions --}}
                        <div class="magazine-actions" @click.stop>
                            <x-like-button 
                                :itemId="$article->id"
                                itemType="article"
                                :isLiked="$article->is_liked ?? false"
                                :likesCount="$article->like_count ?? 0"
                                size="sm" />
                            
                            <x-comment-button 
                                :itemId="$article->id"
                                itemType="article"
                                :commentsCount="$article->comment_count ?? 0"
                                size="sm" />
                            
                            <x-share-button 
                                :itemId="$article->id"
                                itemType="article"
                                size="sm" />
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
        <div class="mt-6">
            {{ $articles->links() }}
        </div>
        @endif
    @else
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-12 text-center border border-neutral-200 dark:border-neutral-700"
             x-show="mounted"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">
            <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-600 mx-auto mb-4 transform transition-transform duration-300 hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.articles.empty') }}</p>
        </div>
    @endif
</div>

