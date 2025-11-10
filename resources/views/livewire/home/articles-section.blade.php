<div>
    @if($articles && $articles->count() > 0)
    {{-- Articles - Native Horizontal Scroll --}}
    <div class="flex gap-6 md:gap-12 lg:gap-16 overflow-x-auto pb-4 pt-12 scrollbar-hide snap-x snap-mandatory"
         style="-webkit-overflow-scrolling: touch;">
        @foreach($articles->take(3) as $i => $article)
        <?php
            // Random positioning for magazine covers
            $rotation = rand(-3, 3);
            $pinColor = ['#e53e3e', '#3182ce', '#38a169', '#d69e2e', '#805ad5'][rand(0, 4)];
            $pinRotation = rand(-15, 15);
        ?>
        <article class="w-[85vw] md:w-[calc(50%-1.5rem)] lg:w-[calc(33.333%-2rem)] flex-shrink-0 magazine-article-wrapper fade-scale-item snap-center" 
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
                
                {{-- Magazine Header --}}
                <div class="magazine-header">
                    <div class="magazine-logo">SLAMIN</div>
                    <div class="magazine-issue">Vol. {{ date('Y') }} . N.{{ 18 + $i }}</div>
                </div>
                
                {{-- Horizontal Line --}}
                <div style="width: 100%; height: 1px; background: #1a1a1a; margin-bottom: 0.75rem;"></div>
                
                {{-- Category Badge --}}
                <div class="magazine-category">
                    Cultura
                </div>
                
                {{-- Featured Image --}}
                @if($article->image)
                <div class="magazine-image">
                    <img src="{{ $article->image }}" 
                         alt="{{ $article->title }}"
                         class="w-full h-full object-cover">
                </div>
                @endif
                
                {{-- Article Title --}}
                <h3 class="magazine-title">
                    {{ $article->title }}
                </h3>
                
                {{-- Article Excerpt --}}
                <p class="magazine-excerpt">
                    {{ Str::limit(strip_tags($article->excerpt ?? $article->content), 120) }}
                </p>
                
                {{-- Author Info with Avatar --}}
                <div class="magazine-author">
                    <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($article->user, 80) }}" 
                         alt="{{ $article->user->name }}"
                         class="magazine-avatar">
                    <div class="magazine-author-info">
                        <div class="magazine-author-name">{{ $article->user->name }}</div>
                        <div class="magazine-author-date">{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</div>
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

    <div class="text-center mt-10">
        <x-ui.buttons.primary :href="route('articles.index')" size="md" icon="M9 5l7 7-7 7">
            {{ __('home.all_articles_button') }}
        </x-ui.buttons.primary>
    </div>
    @endif
</div>

<style>
    /* MAGAZINE WALL STYLING 
       ============================================ */
    
    .magazine-article-wrapper {
        position: relative;
        padding-top: 0;
        min-height: 500px;
    }
    
    /* Thumbtack */
    .thumbtack {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        box-shadow: 
            0 2px 4px rgba(0, 0, 0, 0.2),
            inset 0 1px 2px rgba(255, 255, 255, 0.3);
        z-index: 30;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .thumbtack-needle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 3px;
        height: 3px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    /* Magazine Cover */
    .magazine-cover {
        background: white;
        padding: 1.5rem;
        box-shadow: 
            0 4px 12px rgba(0, 0, 0, 0.15),
            0 8px 24px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 20;
    }
    
    :is(.dark .magazine-cover) {
        background: #2d3748;
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
    
    /* Magazine Header */
    .magazine-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .magazine-logo {
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: 0.05em;
        color: #1a1a1a;
    }
    
    :is(.dark .magazine-logo) {
        color: #e2e8f0;
    }
    
    .magazine-issue {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
    }
    
    :is(.dark .magazine-issue) {
        color: #a0aec0;
    }
    
    /* Category Badge */
    .magazine-category {
        display: inline-block;
        background: #10b981;
        color: white;
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }
    
    /* Feature Image */
    .magazine-image {
        width: 100%;
        aspect-ratio: 16/9;
        overflow: hidden;
        margin-bottom: 1rem;
        border-radius: 0.25rem;
    }
    
    /* Title */
    .magazine-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        font-family: 'Crimson Pro', serif;
    }
    
    :is(.dark .magazine-title) {
        color: #e2e8f0;
    }
    
    /* Excerpt */
    .magazine-excerpt {
        font-size: 0.875rem;
        color: #4a5568;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    :is(.dark .magazine-excerpt) {
        color: #cbd5e0;
    }
    
    /* Author Section */
    .magazine-author {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.08);
    }
    
    :is(.dark .magazine-author) {
        border-top-color: rgba(255, 255, 255, 0.08);
    }
    
    .magazine-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #10b981;
    }
    
    .magazine-author-info {
        flex: 1;
    }
    
    .magazine-author-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2d3748;
    }
    
    :is(.dark .magazine-author-name) {
        color: #e2e8f0;
    }
    
    .magazine-author-date {
        font-size: 0.75rem;
        color: #718096;
    }
    
    :is(.dark .magazine-author-date) {
        color: #a0aec0;
    }
    
    /* Social Actions */
    .magazine-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    :is(.dark .magazine-actions) {
        border-top-color: rgba(255, 255, 255, 0.05);
    }
</style>
