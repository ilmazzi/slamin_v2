<div>
    @if($articles && $articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($articles->take(3) as $i => $article)
        <article class="group h-full" x-data x-intersect.once="$el.classList.add('animate-fade-in')" style="animation-delay: {{ $i * 0.1 }}s">
            
            {{-- Magazine Page Effect Container --}}
            <div class="relative h-full magazine-page-card">
                
                {{-- Red Margin Line (like notebooks) --}}
                <div class="magazine-margin-line"></div>
                
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
        
        /* Magazine/Newspaper Page Effect - CRYSTAL CLEAR */
        .magazine-page-card {
            position: relative;
            height: 100%;
            /* Newspaper/magazine paper color - light blue-grey */
            background: 
                /* Horizontal ruled lines (like lined paper) */
                repeating-linear-gradient(
                    180deg,
                    transparent 0px,
                    transparent 23px,
                    rgba(200, 210, 225, 0.3) 23px,
                    rgba(200, 210, 225, 0.3) 24px,
                    transparent 24px
                ),
                /* Base paper color - cool newspaper grey */
                linear-gradient(135deg, 
                    #e8ecf1 0%,
                    #dce3eb 100%
                );
            padding: 1.5rem;
            padding-left: 3rem; /* Space for red margin line */
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.1),
                0 8px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(180, 190, 210, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: visible;
        }
        
        /* Dark mode */
        :is(.dark .magazine-page-card) {
            background: 
                repeating-linear-gradient(
                    180deg,
                    transparent 0px,
                    transparent 23px,
                    rgba(100, 120, 140, 0.15) 23px,
                    rgba(100, 120, 140, 0.15) 24px,
                    transparent 24px
                ),
                linear-gradient(135deg, 
                    #2d3440 0%,
                    #252b36 100%
                );
            border: 1px solid rgba(100, 120, 140, 0.2);
            box-shadow: 
                0 4px 12px rgba(0, 0, 0, 0.4),
                0 8px 24px rgba(0, 0, 0, 0.5);
        }
        
        /* RED MARGIN LINE (like notebooks/magazines) - SUPER VISIBLE */
        .magazine-margin-line {
            position: absolute;
            left: 2rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(
                to bottom,
                transparent 0%,
                #dc2626 2%,
                #dc2626 98%,
                transparent 100%
            );
            z-index: 5;
        }
        
        :is(.dark .magazine-margin-line) {
            background: linear-gradient(
                to bottom,
                transparent 0%,
                #ef4444 2%,
                #ef4444 98%,
                transparent 100%
            );
        }
        
        /* Paper texture overlay */
        .magazine-page-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='100' height='100' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1;
        }
        
        /* Ensure content is above effects */
        .magazine-page-card > * {
            position: relative;
            z-index: 2;
        }
        
        /* Subtle torn edges (magazine page) */
        .magazine-page-card {
            clip-path: polygon(
                0% 0.5%,
                0.3% 0%,
                99.7% 0%,
                100% 0.5%,
                100% 99.5%,
                99.7% 100%,
                0.3% 100%,
                0% 99.5%
            );
        }
        
        /* Hover effects - LIFT THE PAGE */
        .magazine-page-card:hover {
            transform: translateY(-8px) rotate(-0.5deg);
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.15),
                0 16px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(180, 190, 210, 0.6);
        }
        
        :is(.dark .magazine-page-card:hover) {
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.6),
                0 16px 40px rgba(0, 0, 0, 0.7);
            border-color: rgba(100, 120, 140, 0.4);
        }
        
        /* Red line intensifies on hover */
        .magazine-page-card:hover .magazine-margin-line {
            width: 3px;
            box-shadow: 0 0 8px rgba(220, 38, 38, 0.4);
        }
    </style>
    @endif
</div>
