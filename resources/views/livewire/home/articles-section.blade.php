<div>
    @if($articles && $articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($articles->take(3) as $i => $article)
        <?php
            // Random corner effects for each card (more natural/varied)
            $corners = ['tl', 'tr', 'bl', 'br'];
            $randomCorners = array_rand(array_flip($corners), rand(1, 2)); // 1 or 2 random corners
            if (!is_array($randomCorners)) $randomCorners = [$randomCorners];
        ?>
        <article class="group h-full" x-data x-intersect.once="$el.classList.add('animate-fade-in')" style="animation-delay: {{ $i * 0.1 }}s">
            
            {{-- Newspaper Page Container --}}
            <div class="relative h-full newspaper-page">
                
                {{-- Crumpled corners (random per card) --}}
                @foreach($randomCorners as $corner)
                    <div class="crumpled-corner crumpled-corner-{{ $corner }}"></div>
                @endforeach
                
                <a href="{{ route('articles.show', $article->id) }}" class="block">
                    
                    {{-- Newspaper Header (Masthead) --}}
                    <div class="newspaper-header">
                        <div class="newspaper-masthead">Slamin Journal</div>
                        <div class="newspaper-date">{{ $article->created_at->format('d M Y') }}</div>
                    </div>
                    
                    {{-- Article Headline (newspaper style) --}}
                    <h3 class="newspaper-headline group-hover:text-primary-600 transition-colors">
                        {{ $article->title }}
                    </h3>
                    
                    {{-- Byline (author) --}}
                    <div class="newspaper-byline">
                        <span class="font-bold">di {{ $article->user->name }}</span>
                    </div>
                    
                    {{-- Article Body --}}
                    <div class="newspaper-columns">
                        <p class="newspaper-text">
                            {{ $article->excerpt ?? Str::limit($article->content, 200) }}
                        </p>
                    </div>
                    
                    {{-- Image integrated in layout --}}
                    @if($article->featured_image_url)
                    <div class="newspaper-image">
                        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="newspaper-caption">{{ $article->user->name }}</div>
                    </div>
                    @endif
                    
                </a>
                
                <!-- Social Actions -->
                <div class="flex items-center gap-4 pt-3 mt-3 border-t-2 border-neutral-800/80 dark:border-neutral-500" @click.stop>
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
        <x-ui.buttons.primary :href="route('articles.index')" variant="outline" size="md" icon="M9 5l7 7-7 7">
            {{ __('home.all_articles_button') }}
        </x-ui.buttons.primary>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        /* ============================================
           REAL NEWSPAPER PAGE EFFECT
           ============================================ */
        
        .newspaper-page {
            position: relative;
            height: 100%;
            /* Aged newspaper paper - cream/ivory with slight yellow tint */
            background: 
                /* Paper fiber texture (SVG noise) */
                url("data:image/svg+xml,%3Csvg width='400' height='400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.95' numOctaves='4' /%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23paper)' opacity='0.12'/%3E%3C/svg%3E"),
                /* Base newspaper color */
                linear-gradient(140deg, 
                    #f7f3ea 0%,
                    #f0e9dc 30%,
                    #ebe3d3 50%,
                    #f0e9dc 70%,
                    #f7f3ea 100%
                );
            padding: 1.25rem;
            box-shadow: 
                /* Paper depth */
                0 4px 12px rgba(0, 0, 0, 0.1),
                0 8px 24px rgba(0, 0, 0, 0.06),
                /* Subtle inner shadow for paper feel */
                inset 0 0 40px rgba(139, 115, 85, 0.03);
            border: 1px solid rgba(139, 115, 85, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }
        
        /* Dark mode - vintage newspaper at night */
        :is(.dark .newspaper-page) {
            background: 
                url("data:image/svg+xml,%3Csvg width='400' height='400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='paper'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.95' numOctaves='4' /%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23paper)' opacity='0.12'/%3E%3C/svg%3E"),
                linear-gradient(140deg, 
                    #3d3a32 0%,
                    #34312a 30%,
                    #2b2924 50%,
                    #34312a 70%,
                    #3d3a32 100%
                );
            border: 1px solid rgba(139, 115, 85, 0.3);
        }
        
        /* ============================================
           NEWSPAPER TYPOGRAPHY
           ============================================ */
        
        /* Masthead (testata giornale) */
        .newspaper-header {
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            border-bottom: 3px double rgba(0, 0, 0, 0.85);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        :is(.dark .newspaper-header) {
            border-bottom-color: rgba(255, 255, 255, 0.7);
        }
        
        .newspaper-masthead {
            font-family: 'Crimson Pro', serif;
            font-size: 1.25rem;
            font-weight: 900;
            letter-spacing: 0.12em;
            color: #1a1a1a;
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.1);
        }
        
        :is(.dark .newspaper-masthead) {
            color: #f5f5f5;
            text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.3);
        }
        
        .newspaper-date {
            font-family: 'Crimson Pro', serif;
            font-size: 0.625rem;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        
        :is(.dark .newspaper-date) {
            color: #aaa;
        }
        
        /* Headline (titolo articolo) */
        .newspaper-headline {
            font-family: 'Crimson Pro', serif;
            font-size: 1.5rem;
            font-weight: 900;
            line-height: 1.15;
            color: #0f0f0f;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: -0.01em;
        }
        
        :is(.dark .newspaper-headline) {
            color: #f5f5f5;
        }
        
        /* Byline (firma autore) */
        .newspaper-byline {
            font-family: 'Crimson Pro', serif;
            font-size: 0.75rem;
            color: #555;
            margin-bottom: 1rem;
            font-style: italic;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.15);
        }
        
        :is(.dark .newspaper-byline) {
            color: #aaa;
            border-bottom-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Article body text */
        .newspaper-columns {
            margin-bottom: 1rem;
        }
        
        .newspaper-text {
            font-family: 'Crimson Pro', serif;
            font-size: 0.875rem;
            line-height: 1.65;
            color: #1f1f1f;
            text-align: justify;
            hyphens: auto;
        }
        
        :is(.dark .newspaper-text) {
            color: #d9d9d9;
        }
        
        /* Newspaper image with caption */
        .newspaper-image {
            position: relative;
            aspect-ratio: 16/10;
            overflow: hidden;
            margin-bottom: 0.5rem;
            border: 2px solid rgba(0, 0, 0, 0.3);
            background: #000;
        }
        
        :is(.dark .newspaper-image) {
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .newspaper-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            font-family: 'Crimson Pro', serif;
            font-size: 0.625rem;
            padding: 0.375rem 0.625rem;
            font-style: italic;
            letter-spacing: 0.02em;
        }
        
        /* ============================================
           NEWSPAPER EFFECTS & INTERACTIONS
           ============================================ */
        
        /* Irregular cut edges with crumpled corners */
        .newspaper-page {
            clip-path: polygon(
                0% 2%,
                2% 0%,
                98% 0%,
                100% 2%,
                100% 98%,
                98% 100%,
                2% 100%,
                0% 98%
            );
        }
        
        /* DOG-EAR / PAGE CURL EFFECT - Real folded corner */
        .crumpled-corner {
            position: absolute;
            width: 0;
            height: 0;
            pointer-events: none;
            z-index: 10;
        }
        
        /* Top-left corner - folded page */
        .crumpled-corner-tl {
            top: 0;
            left: 0;
            border-style: solid;
            border-width: 45px 45px 0 0;
            border-color: #d8d0c0 transparent transparent transparent;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        /* Shadow under the fold */
        .crumpled-corner-tl::before {
            content: '';
            position: absolute;
            top: -45px;
            left: 0;
            width: 45px;
            height: 45px;
            background: 
                linear-gradient(
                    135deg,
                    rgba(0, 0, 0, 0.4) 0%,
                    rgba(0, 0, 0, 0.2) 50%,
                    transparent 100%
                );
        }
        
        :is(.dark .crumpled-corner-tl) {
            border-color: #2a2720 transparent transparent transparent;
            filter: drop-shadow(2px 2px 6px rgba(0, 0, 0, 0.8));
        }
        
        /* Top-right corner - folded page */
        .crumpled-corner-tr {
            top: 0;
            right: 0;
            border-style: solid;
            border-width: 0 45px 45px 0;
            border-color: transparent #d8d0c0 transparent transparent;
            filter: drop-shadow(-2px 2px 4px rgba(0, 0, 0, 0.3));
        }
        
        .crumpled-corner-tr::before {
            content: '';
            position: absolute;
            top: 0;
            right: -45px;
            width: 45px;
            height: 45px;
            background: 
                linear-gradient(
                    225deg,
                    rgba(0, 0, 0, 0.4) 0%,
                    rgba(0, 0, 0, 0.2) 50%,
                    transparent 100%
                );
        }
        
        :is(.dark .crumpled-corner-tr) {
            border-color: transparent #2a2720 transparent transparent;
            filter: drop-shadow(-2px 2px 6px rgba(0, 0, 0, 0.8));
        }
        
        /* Bottom-left corner - folded page */
        .crumpled-corner-bl {
            bottom: 0;
            left: 0;
            border-style: solid;
            border-width: 0 0 45px 45px;
            border-color: transparent transparent #d8d0c0 transparent;
            filter: drop-shadow(2px -2px 4px rgba(0, 0, 0, 0.3));
        }
        
        .crumpled-corner-bl::before {
            content: '';
            position: absolute;
            bottom: -45px;
            left: 0;
            width: 45px;
            height: 45px;
            background: 
                linear-gradient(
                    45deg,
                    rgba(0, 0, 0, 0.4) 0%,
                    rgba(0, 0, 0, 0.2) 50%,
                    transparent 100%
                );
        }
        
        :is(.dark .crumpled-corner-bl) {
            border-color: transparent transparent #2a2720 transparent;
            filter: drop-shadow(2px -2px 6px rgba(0, 0, 0, 0.8));
        }
        
        /* Bottom-right corner - folded page */
        .crumpled-corner-br {
            bottom: 0;
            right: 0;
            border-style: solid;
            border-width: 45px 0 0 45px;
            border-color: transparent transparent transparent #d8d0c0;
            filter: drop-shadow(-2px -2px 4px rgba(0, 0, 0, 0.3));
        }
        
        .crumpled-corner-br::before {
            content: '';
            position: absolute;
            bottom: 0;
            right: -45px;
            width: 45px;
            height: 45px;
            background: 
                linear-gradient(
                    315deg,
                    rgba(0, 0, 0, 0.4) 0%,
                    rgba(0, 0, 0, 0.2) 50%,
                    transparent 100%
                );
        }
        
        :is(.dark .crumpled-corner-br) {
            border-color: transparent transparent transparent #2a2720;
            filter: drop-shadow(-2px -2px 6px rgba(0, 0, 0, 0.8));
        }
        
        /* Hover: lift newspaper clipping */
        .newspaper-page:hover {
            transform: translateY(-8px) rotate(-0.8deg);
            box-shadow: 
                0 12px 30px rgba(0, 0, 0, 0.18),
                0 6px 15px rgba(0, 0, 0, 0.12),
                inset 0 0 50px rgba(139, 115, 85, 0.05);
        }
        
        :is(.dark .newspaper-page:hover) {
            box-shadow: 
                0 12px 30px rgba(0, 0, 0, 0.8),
                0 6px 15px rgba(0, 0, 0, 0.7);
        }
        
        /* Corners "unfold" slightly on hover */
        .newspaper-page:hover .crumpled-corner-tl {
            border-width: 50px 50px 0 0;
        }
        
        .newspaper-page:hover .crumpled-corner-tr {
            border-width: 0 50px 50px 0;
        }
        
        .newspaper-page:hover .crumpled-corner-bl {
            border-width: 0 0 50px 50px;
        }
        
        .newspaper-page:hover .crumpled-corner-br {
            border-width: 50px 0 0 50px;
        }
    </style>
    @endif
</div>
