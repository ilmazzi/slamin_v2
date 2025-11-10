<div>
    @if($articles && $articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($articles->take(3) as $i => $article)
        <article class="group h-full" x-data x-intersect.once="$el.classList.add('animate-fade-in')" style="animation-delay: {{ $i * 0.1 }}s">
            
            {{-- Magazine Page Effect Container --}}
            <div class="relative h-full magazine-page-card">
                
                {{-- Page Marker Corner --}}
                <div class="magazine-corner"></div>
                
                <a href="{{ route('articles.show', $article->id) }}" class="block">
                    
                    <div>
                        {{-- Author Info in alto --}}
                        <div class="flex items-center gap-3 mb-4">
                            <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-300 dark:ring-primary-600">
                            <div>
                                <p class="font-semibold text-sm text-neutral-900 dark:text-white">{{ $article->user->name }}</p>
                                <p class="text-xs text-neutral-600 dark:text-neutral-400">{{ $article->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        {{-- Title (più grande e prominente) --}}
                        <h3 class="text-2xl font-bold mb-3 text-neutral-900 dark:text-white group-hover:text-primary-600 transition-colors leading-tight" style="font-family: 'Crimson Pro', serif;">
                            {{ $article->title }}
                        </h3>
                        
                        {{-- Descrizione (più lunga) --}}
                        <p class="text-neutral-700 dark:text-neutral-300 line-clamp-3 text-base mb-4 leading-relaxed">
                            {{ $article->excerpt ?? Str::limit($article->content, 150) }}
                        </p>
                        
                        {{-- Immagine PICCOLA come preview --}}
                        @if($article->featured_image_url)
                        <div class="aspect-[16/7] overflow-hidden mb-4 relative rounded-sm">
                            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        @endif
                    </div>
                </a>
                
                <!-- Social Actions - Using Reusable Components -->
                <div class="flex items-center gap-4 pt-4 mt-4 border-t border-neutral-200/50 dark:border-neutral-700/50" @click.stop>
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
            {{-- End Magazine Page Card --}}
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
        
        /* Magazine Page Effect - SUPER VISIBLE & DISTINCT */
        .magazine-page-card {
            position: relative;
            height: 100%;
            background: 
                /* Strong paper grain */
                repeating-linear-gradient(
                    0deg,
                    rgba(0, 0, 0, 0.08) 0px,
                    transparent 1px,
                    transparent 2px,
                    rgba(0, 0, 0, 0.08) 3px
                ),
                /* Bold column lines (3 columns) */
                repeating-linear-gradient(
                    90deg,
                    transparent 0px,
                    transparent 32%,
                    rgba(0, 0, 0, 0.06) 32.5%,
                    rgba(0, 0, 0, 0.06) 33%,
                    transparent 33%,
                    transparent 65%,
                    rgba(0, 0, 0, 0.06) 65.5%,
                    rgba(0, 0, 0, 0.06) 66%,
                    transparent 66%
                ),
                /* Base gradient - STRONG blue-grey magazine paper */
                linear-gradient(160deg, 
                    #d8e3f0 0%,
                    #c8d5e3 20%,
                    #b8c8d8 40%,
                    #c0cfe0 60%,
                    #cad9e8 80%,
                    #d8e3f0 100%
                );
            padding: 1.5rem;
            box-shadow: 
                /* Deep outer shadows */
                0 4px 8px rgba(0, 0, 0, 0.12),
                0 12px 24px rgba(0, 0, 0, 0.15),
                /* STRONG central fold */
                inset -6px 0 12px rgba(0, 0, 0, 0.15),
                inset 6px 0 12px rgba(0, 0, 0, 0.08),
                /* Edge highlights */
                inset 0 3px 6px rgba(255, 255, 255, 0.7),
                inset 0 -3px 6px rgba(0, 0, 0, 0.08);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            border: 2px solid rgba(100, 130, 160, 0.2);
        }
        
        /* Dark mode - blue-tinted dark */
        :is(.dark .magazine-page-card) {
            background: 
                repeating-linear-gradient(
                    0deg,
                    rgba(255, 255, 255, 0.05) 0px,
                    transparent 1px,
                    transparent 2px,
                    rgba(255, 255, 255, 0.05) 3px
                ),
                repeating-linear-gradient(
                    90deg,
                    transparent 0px,
                    transparent 32%,
                    rgba(255, 255, 255, 0.04) 32.5%,
                    rgba(255, 255, 255, 0.04) 33%,
                    transparent 33%,
                    transparent 65%,
                    rgba(255, 255, 255, 0.04) 65.5%,
                    rgba(255, 255, 255, 0.04) 66%,
                    transparent 66%
                ),
                linear-gradient(160deg, 
                    #3a4556 0%,
                    #2e3947 20%,
                    #252d3a 40%,
                    #2a3440 60%,
                    #323d4d 80%,
                    #3a4556 100%
                );
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.6),
                0 12px 24px rgba(0, 0, 0, 0.7),
                inset -6px 0 12px rgba(0, 0, 0, 0.5),
                inset 6px 0 12px rgba(0, 0, 0, 0.3),
                inset 0 3px 6px rgba(255, 255, 255, 0.05),
                inset 0 -3px 6px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(100, 130, 160, 0.1);
        }
        
        /* STRONG glossy shine effect on left */
        .magazine-page-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 40%;
            height: 100%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0.25) 0%,
                rgba(255, 255, 255, 0.1) 70%,
                transparent 100%
            );
            pointer-events: none;
            z-index: 1;
        }
        
        :is(.dark .magazine-page-card::before) {
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0.08) 0%,
                rgba(255, 255, 255, 0.03) 70%,
                transparent 100%
            );
        }
        
        /* Ensure content is above effects */
        .magazine-page-card > * {
            position: relative;
            z-index: 2;
        }
        
        /* Page corner marker - MASSIVE AND SUPER VISIBLE */
        .magazine-corner {
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 55px 55px 0;
            border-color: transparent #ffffff transparent transparent;
            filter: drop-shadow(-3px 3px 6px rgba(0, 0, 0, 0.3));
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        :is(.dark .magazine-corner) {
            border-color: transparent #1a1f2e transparent transparent;
            filter: drop-shadow(-3px 3px 8px rgba(0, 0, 0, 0.8));
        }
        
        /* Diagonal fold line on corner */
        .magazine-corner::before {
            content: '';
            position: absolute;
            top: -55px;
            right: 0;
            width: 78px;
            height: 2px;
            background: linear-gradient(135deg, 
                transparent 0%, 
                rgba(0, 0, 0, 0.2) 30%, 
                rgba(0, 0, 0, 0.25) 50%, 
                rgba(0, 0, 0, 0.2) 70%, 
                transparent 100%
            );
            transform: rotate(45deg);
            transform-origin: right;
        }
        
        /* Worn edges effect - more visible irregularity */
        .magazine-page-card {
            clip-path: polygon(
                0% 1%,
                1% 0%,
                2% 0.3%,
                5% 0%,
                95% 0%,
                98% 0.3%,
                99% 0%,
                100% 1%,
                100% 98%,
                99.5% 99%,
                99% 100%,
                98% 99.5%,
                5% 100%,
                2% 99.7%,
                1% 100%,
                0% 99%
            );
        }
        
        /* Hover effects - SUPER DRAMATIC */
        .magazine-page-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 
                /* Much deeper outer shadows */
                0 10px 20px rgba(0, 0, 0, 0.2),
                0 25px 50px rgba(0, 0, 0, 0.25),
                /* VERY deep central fold */
                inset -8px 0 16px rgba(0, 0, 0, 0.2),
                inset 8px 0 16px rgba(0, 0, 0, 0.12),
                /* Strong edge highlights */
                inset 0 4px 8px rgba(255, 255, 255, 0.8),
                inset 0 -4px 8px rgba(0, 0, 0, 0.12);
            border-color: rgba(100, 130, 160, 0.3);
        }
        
        :is(.dark .magazine-page-card:hover) {
            box-shadow: 
                0 10px 20px rgba(0, 0, 0, 0.7),
                0 25px 50px rgba(0, 0, 0, 0.8),
                inset -8px 0 16px rgba(0, 0, 0, 0.6),
                inset 8px 0 16px rgba(0, 0, 0, 0.4),
                inset 0 4px 8px rgba(255, 255, 255, 0.08),
                inset 0 -4px 8px rgba(0, 0, 0, 0.5);
            border-color: rgba(100, 130, 160, 0.15);
        }
        
        .magazine-page-card:hover .magazine-corner {
            border-width: 0 65px 65px 0;
            filter: drop-shadow(-4px 4px 8px rgba(0, 0, 0, 0.4));
        }
        
        :is(.dark .magazine-page-card:hover .magazine-corner) {
            filter: drop-shadow(-4px 4px 10px rgba(0, 0, 0, 0.9));
        }
    </style>
    @endif
</div>
