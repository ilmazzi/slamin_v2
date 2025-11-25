<div>
    @if($isOpen && $article)
    <!-- Modal Overlay -->
    <div x-data="{ show: @entangle('isOpen'), leftOpen: false, rightOpen: false }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden"
         @keydown.escape.window="$wire.closeModal()"
         x-effect="if (show) { leftOpen = false; rightOpen = false; requestAnimationFrame(() => { leftOpen = true; rightOpen = true; }); } else { leftOpen = false; rightOpen = false; }">
        
        <!-- Dark Backdrop -->
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm"
             @click="$wire.closeModal()"></div>
        
        <!-- Newspaper Container -->
        <div class="absolute inset-0 flex items-center justify-center p-4 md:p-8 overflow-y-auto overflow-x-hidden">
            
            <div class="article-newspaper-container"
                 x-show="show"
                 x-transition:enter="transition-all ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition-all ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button wire:click="closeModal"
                        class="absolute -top-4 -right-4 z-50 w-12 h-12 bg-white dark:bg-neutral-800 rounded-full shadow-2xl
                               hover:scale-110 hover:rotate-90 transition-all duration-300
                               flex items-center justify-center text-neutral-600 dark:text-neutral-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                
                <!-- Newspaper Opened (Desktop: Two Pages, Mobile: Single Page) -->
                <div class="article-newspaper-opened">
                    
                    <!-- Left Page (Desktop Only) -->
                    <div class="article-page article-page-left"
                         x-bind:class="leftOpen ? 'article-page-open-left' : 'article-page-closed-left'">
                        
                        <div class="article-page-content">
                            <!-- Newspaper Header -->
                            <div class="article-newspaper-header">
                                <div class="article-newspaper-masthead">
                                    <h1 class="article-newspaper-title">{{ __('articles.newspaper.title') }}</h1>
                                    <div class="article-newspaper-date-line">
                                        <span class="article-newspaper-date">{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                        <span class="article-newspaper-price">€ 2,50</span>
                                    </div>
                                </div>
                                <div class="article-newspaper-divider"></div>
                            </div>
                            
                            <!-- Author Info -->
                            <div class="article-left-meta">
                                <div class="article-author-info-left">
                                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 80) }}" 
                                         alt="{{ $article->user->name }}"
                                         class="article-author-avatar-left">
                                    <div>
                                        <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($article->user) }}" 
                                           class="article-author-name-left hover:underline transition-colors">
                                            {{ \App\Helpers\AvatarHelper::getDisplayName($article->user) }}
                                        </a>
                                        <div class="article-author-role-left">{{ __('articles.newspaper.reporter') }}</div>
                                    </div>
                                </div>
                                
                                <div class="article-left-stats">
                                    <div class="article-left-stat">
                                        <p class="count">{{ $article->views_count ?? 0 }}</p>
                                        <p class="label">{{ __('articles.newspaper.views') }}</p>
                                    </div>
                                    <div class="article-left-stat">
                                        <p class="count">{{ $article->likes_count ?? 0 }}</p>
                                        <p class="label">{{ __('articles.newspaper.likes') }}</p>
                                    </div>
                                </div>
                                
                                @if($article->featured_image_url)
                                <div class="article-featured-image-left">
                                    <img src="{{ $article->featured_image_url }}" 
                                         alt="{{ $article->title }}"
                                         class="article-image-left">
                                </div>
                                @endif
                                
                                @auth
                                    @if(auth()->id() === $article->user_id)
                                        <div class="article-owner-actions-left">
                                            <a href="{{ route('articles.edit', $article->slug) }}" class="article-owner-action">
                                                <svg class="article-owner-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5l3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                                <span>{{ __('articles.newspaper.edit_article') }}</span>
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Page -->
                    <div class="article-page article-page-right"
                         x-bind:class="rightOpen ? 'article-page-open-right' : 'article-page-closed-right'">
                        
                        <div class="article-page-content">
                            <!-- Article Title (Desktop - Right Page) -->
                            <div class="article-title-section">
                                <div class="article-category-badge">
                                    {{ $article->category->name ?? __('articles.category.uncategorized') }}
                                </div>
                                <h2 class="article-main-title">{{ $article->title }}</h2>
                                @if($article->excerpt)
                                <p class="article-subtitle">{{ $article->excerpt }}</p>
                                @endif
                            </div>
                            
                            <!-- Article Header (Mobile) -->
                            <div class="article-header-section">
                                <!-- Newspaper Header (Mobile Only) -->
                                <div class="article-newspaper-header-mobile">
                                    <div class="article-newspaper-masthead">
                                        <h1 class="article-newspaper-title">{{ __('articles.newspaper.title') }}</h1>
                                        <div class="article-newspaper-date-line">
                                            <span class="article-newspaper-date">{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                                            <span class="article-newspaper-price">€ 2,50</span>
                                        </div>
                                    </div>
                                    <div class="article-newspaper-divider"></div>
                                </div>
                                
                                <div class="article-category-badge">
                                    {{ $article->category->name ?? __('articles.category.uncategorized') }}
                                </div>
                                <h2 class="article-main-title">{{ $article->title }}</h2>
                                @if($article->excerpt)
                                <p class="article-subtitle">{{ $article->excerpt }}</p>
                                @endif
                                <div class="article-byline">
                                    <div class="article-author-info">
                                        <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 48) }}" 
                                             alt="{{ $article->user->name }}"
                                             class="article-author-avatar">
                                        <div>
                                            <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($article->user) }}" 
                                               class="article-author-name hover:underline transition-colors">
                                                {{ \App\Helpers\AvatarHelper::getDisplayName($article->user) }}
                                            </a>
                                            <div class="article-author-role">{{ __('articles.newspaper.reporter') }}</div>
                                        </div>
                                    </div>
                                    <div class="article-meta">
                                        <span>{{ $article->created_at->diffForHumans() }}</span>
                                        <span class="article-meta-divider">•</span>
                                        <span>{{ $article->views_count ?? 0 }} {{ __('articles.newspaper.views') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Featured Image -->
                            @if($article->featured_image_url)
                            <div class="article-featured-image">
                                <img src="{{ $article->featured_image_url }}" 
                                     alt="{{ $article->title }}"
                                     class="article-image">
                                @if($article->excerpt)
                                <div class="article-image-caption">{{ $article->excerpt }}</div>
                                @endif
                            </div>
                            @endif
                            
                            <!-- Article Body -->
                            <div class="article-body">
                                {!! $article->content !!}
                            </div>
                            
                            <!-- Article Footer -->
                            <div class="article-footer">
                                <div class="article-social-actions">
                                    <x-like-button 
                                        :itemId="$article->id"
                                        itemType="article"
                                        :isLiked="$article->is_liked ?? false"
                                        :likesCount="$article->likes_count ?? 0"
                                        size="md" />
                                    
                                    <x-comment-button 
                                        :itemId="$article->id"
                                        itemType="article"
                                        :commentsCount="$article->comments_count ?? 0"
                                        size="md" />
                                    
                                    <x-share-button 
                                        :itemId="$article->id"
                                        itemType="article"
                                        size="md" />
                                    
                                    <x-report-button 
                                        :itemId="$article->id"
                                        itemType="article"
                                        size="md" />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Newspaper Spine (Desktop Only) -->
                    <div class="article-newspaper-spine"></div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

