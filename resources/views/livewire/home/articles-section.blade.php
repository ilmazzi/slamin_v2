<div>
    @if($articles && $articles->count() > 0)
    {{-- Articles - Horizontal Scroll with Desktop Navigation --}}
    <div class="relative" x-data="{ 
        scroll(direction) {
            const container = this.$refs.scrollContainer;
            const cards = container.children;
            if (cards.length === 0) return;
            
            const containerRect = container.getBoundingClientRect();
            const scrollLeft = container.scrollLeft;
            
            // Find current visible card
            let targetCard = null;
            for (let i = 0; i < cards.length; i++) {
                const card = cards[i];
                const cardRect = card.getBoundingClientRect();
                const cardLeft = card.offsetLeft;
                
                if (direction > 0) {
                    // Scroll right: find first card that's partially or fully off-screen to the right
                    if (cardLeft > scrollLeft + containerRect.width - 100) {
                        targetCard = card;
                        break;
                    }
                } else {
                    // Scroll left: find card to the left of current view
                    if (cardLeft < scrollLeft - 50) {
                        targetCard = card;
                    }
                }
            }
            
            if (targetCard) {
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            }
        }
    }">
        <!-- Left Arrow (Desktop Only) - OUTSIDE content -->
        <button @click="scroll(-1)" 
                class="hidden md:flex absolute -left-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
            <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        
        <!-- Right Arrow (Desktop Only) - OUTSIDE content -->
        <button @click="scroll(1)" 
                class="hidden md:flex absolute -right-16 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/95 dark:bg-neutral-800/95 backdrop-blur-sm rounded-full shadow-xl hover:scale-110 transition-all duration-300 items-center justify-center text-neutral-900 dark:text-white group">
            <svg class="w-6 h-6 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        
            <!-- Mobile Scroll Indicator -->
            <div class="md:hidden relative mb-4">
                <div class="flex items-center justify-center gap-2 text-neutral-600 dark:text-neutral-400 text-sm">
                    <svg class="w-5 h-5 animate-bounce-horizontal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                    </svg>
                    <span>Scorri per vedere altro</span>
                </div>
            </div>
            
            <div x-ref="scrollContainer" class="flex gap-6 overflow-x-auto pb-12 pt-20 px-8 md:px-12 scrollbar-hide"
                 style="-webkit-overflow-scrolling: touch; overflow-y: visible;">
        @foreach($articles->take(3) as $i => $article)
        <?php
            // Random positioning for magazine covers
            $rotation = rand(-3, 3);
            $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
            $pinRotation = rand(-15, 15);
        ?>
        <article class="w-80 md:w-96 flex-shrink-0 magazine-article-wrapper fade-scale-item" 
                 x-data 
                 x-intersect.once="$el.classList.add('animate-fade-in')" 
                 style="animation-delay: {{ $i * 0.1 }}s">
            
            {{-- Thumbtack/Puntina --}}
            <div class="thumbtack" 
                 style="background: {{ $pinColor }}; transform: rotate({{ $pinRotation }}deg);">
                <div class="thumbtack-needle"></div>
            </div>
            
            {{-- Magazine Cover --}}
            <div class="magazine-cover" style="transform: rotate({{ $rotation }}deg);">
                
                <div onclick="Livewire.dispatch('openArticleModal', { articleId: {{ $article->id }} })" class="magazine-inner group cursor-pointer">
                    
                    {{-- Magazine Header --}}
                    <div class="magazine-header">
                        <div class="magazine-logo">SLAMIN</div>
                        <div class="magazine-issue">Vol. {{ date('Y') }} · N.{{ str_pad($article->id, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    
                    {{-- Category Badge --}}
                    <div class="magazine-category">
                        Cultura
                    </div>
                    
                    {{-- Featured Image --}}
                    @if($article->featured_image_url)
                    <div class="magazine-image">
                        <img src="{{ $article->featured_image_url }}" 
                             alt="{{ $article->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    </div>
                    @endif
                    
                    {{-- Article Title --}}
                    <h3 class="magazine-title">
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
                             class="magazine-avatar">
                        <div class="magazine-author-info">
                            <a href="{{ \App\Helpers\AvatarHelper::getUserProfileUrl($article->user) }}" 
                               class="magazine-author-name hover:underline transition-colors">
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
    </div>

    {{-- CTA - Simple Text --}}
    <div class="text-center mt-10">
        <a href="{{ route('articles.index') }}" 
           class="inline-block text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300"
           style="font-family: 'Crimson Pro', serif;">
            → {{ __('home.all_articles_button') }}
        </a>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fade-in 0.6s ease-out forwards; opacity: 0; }
        
        /* ============================================
           LITERARY MAGAZINE WALL
           ============================================ */
        
        .magazine-article-wrapper {
            position: relative;
            padding-top: 0;
        }
        
        /* Thumbtack/Puntina colorata - PINNED INTO CARD */
        .thumbtack {
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            z-index: 100;
            box-shadow: 
                0 3px 6px rgba(0, 0, 0, 0.35),
                0 1px 3px rgba(0, 0, 0, 0.25),
                inset 0 -6px 10px rgba(0, 0, 0, 0.25),
                inset 0 6px 10px rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .thumbtack-needle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 4px;
            height: 4px;
            background: #1a1a1a;
            border-radius: 50%;
            box-shadow: 
                0 1px 3px rgba(0, 0, 0, 0.6),
                inset 0 1px 1px rgba(255, 255, 255, 0.2);
        }
        
        /* Magazine Cover - Copertina Rivista */
        .magazine-cover {
            position: relative;
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(0, 0, 0, 0.08),
                0 12px 24px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Hover on wrapper - pin moves with card! */
        .magazine-article-wrapper:hover .magazine-cover {
            transform: translateY(-8px) scale(1.02) !important;
            box-shadow: 
                0 12px 20px rgba(0, 0, 0, 0.18),
                0 20px 36px rgba(0, 0, 0, 0.12),
                0 28px 48px rgba(0, 0, 0, 0.08);
        }
        
        .magazine-article-wrapper:hover .thumbtack {
            transform: translateX(-50%) translateY(-8px);
        }
        
        :is(.dark .magazine-cover) {
            background: #2a2724;
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .magazine-inner {
            display: block;
            padding: 1.5rem;
            text-decoration: none;
        }
        
        /* Magazine Header - Testata */
        .magazine-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #000;
        }
        
        :is(.dark .magazine-header) {
            border-bottom-color: #fff;
        }
        
        .magazine-logo {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: 0.15em;
            color: #000;
        }
        
        :is(.dark .magazine-logo) {
            color: #fff;
        }
        
        .magazine-issue {
            font-family: 'Crimson Pro', serif;
            font-size: 0.625rem;
            font-weight: 600;
            color: #666;
            letter-spacing: 0.05em;
        }
        
        :is(.dark .magazine-issue) {
            color: #aaa;
        }
        
        /* Category Badge */
        .magazine-category {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #10b981;
            color: #fff;
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }
        
        /* Featured Image */
        .magazine-image {
            position: relative;
            aspect-ratio: 16/10;
            overflow: hidden;
            margin-bottom: 1rem;
            background: #000;
        }
        
        /* Title */
        .magazine-title {
            font-family: 'Crimson Pro', serif;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.3;
            color: #1a1a1a;
            margin-bottom: 0.75rem;
            transition: color 0.3s ease;
        }
        
        .group:hover .magazine-title {
            color: #10b981;
        }
        
        :is(.dark .magazine-title) {
            color: #f5f5f5;
        }
        
        :is(.dark .group:hover .magazine-title) {
            color: #34d399;
        }
        
        /* Excerpt */
        .magazine-excerpt {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            line-height: 1.6;
            color: #4a4a4a;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        :is(.dark .magazine-excerpt) {
            color: #c5c5c5;
        }
        
        /* Author section with avatar */
        .magazine-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        :is(.dark .magazine-author) {
            border-top-color: rgba(255, 255, 255, 0.1);
        }
        
        .magazine-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #10b981;
            flex-shrink: 0;
        }
        
        .magazine-author-info {
            flex: 1;
        }
        
        .magazine-author-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        :is(.dark .magazine-author-name) {
            color: #f5f5f5;
        }
        
        .magazine-author-date {
            font-size: 0.75rem;
            color: #666;
        }
        
        :is(.dark .magazine-author-date) {
            color: #999;
        }
        
        /* Social Actions */
        .magazine-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        :is(.dark .magazine-actions) {
            background: rgba(42, 39, 36, 0.9);
            border-top-color: rgba(255, 255, 255, 0.1);
        }
    </style>
    @endif
    
    {{-- Article Modal --}}
    <livewire:articles.article-modal />
</div>
