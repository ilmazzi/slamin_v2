<div>
    @if($articles && $articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($articles->take(3) as $i => $article)
        <article class="group h-full" x-data x-intersect.once="$el.classList.add('animate-fade-in')" style="animation-delay: {{ $i * 0.1 }}s">
            
            {{-- Magazine Page Effect Container --}}
            <div class="relative h-full magazine-page-card">
                
                {{-- Editorial Header Bar --}}
                <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-primary-600 via-accent-600 to-primary-600 z-10"></div>
                
                {{-- Article Label --}}
                <div class="absolute top-3 left-3 px-3 py-1 bg-white/90 dark:bg-neutral-900/90 border border-neutral-300 dark:border-neutral-600 z-10">
                    <span class="text-[10px] font-black uppercase tracking-widest text-neutral-600 dark:text-neutral-400">Articolo</span>
                </div>
                
                <a href="{{ route('articles.show', $article->id) }}" class="block pt-10">
                    
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
        
        /* NEWSPAPER/MAGAZINE CLIPPING EFFECT - SUPER DISTINCTIVE */
        .magazine-page-card {
            position: relative;
            height: 100%;
            /* Newspaper aged paper - YELLOW-GREY tint */
            background: 
                /* Visible newspaper print lines */
                repeating-linear-gradient(
                    180deg,
                    transparent 0px,
                    transparent 19px,
                    rgba(0, 0, 0, 0.06) 19px,
                    rgba(0, 0, 0, 0.06) 20px,
                    transparent 20px
                ),
                /* Base newspaper color - aged paper */
                linear-gradient(145deg, 
                    #f4f1e8 0%,
                    #ebe5d8 50%,
                    #f4f1e8 100%
                );
            padding: 1.5rem;
            padding-left: 2.5rem;
            box-shadow: 
                /* Strong shadows for depth */
                0 6px 16px rgba(0, 0, 0, 0.15),
                0 3px 6px rgba(0, 0, 0, 0.1),
                /* Subtle edges */
                inset 0 1px 0 rgba(255, 255, 255, 0.5),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05);
            border-left: 4px solid #dc2626;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            border-right: 1px solid rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: visible;
        }
        
        /* Dark mode - newspaper at night */
        :is(.dark .magazine-page-card) {
            background: 
                repeating-linear-gradient(
                    180deg,
                    transparent 0px,
                    transparent 19px,
                    rgba(255, 255, 255, 0.04) 19px,
                    rgba(255, 255, 255, 0.04) 20px,
                    transparent 20px
                ),
                linear-gradient(145deg, 
                    #3a3830 0%,
                    #2d2a24 50%,
                    #3a3830 100%
                );
            border-left: 4px solid #ef4444;
            box-shadow: 
                0 6px 16px rgba(0, 0, 0, 0.6),
                0 3px 6px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.03),
                inset 0 -1px 0 rgba(0, 0, 0, 0.3);
        }
        
        /* RED MARGIN LINE - THICK AND OBVIOUS */
        .magazine-margin-line {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #dc2626;
            z-index: 5;
            box-shadow: 2px 0 4px rgba(220, 38, 38, 0.3);
        }
        
        :is(.dark .magazine-margin-line) {
            background: #ef4444;
            box-shadow: 2px 0 6px rgba(239, 68, 68, 0.4);
        }
        
        /* Newspaper texture - more visible */
        .magazine-page-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg width='200' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23noise)' opacity='0.08'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1;
            mix-blend-mode: multiply;
        }
        
        :is(.dark .magazine-page-card::before) {
            mix-blend-mode: overlay;
            opacity: 0.3;
        }
        
        /* Ensure content is above effects */
        .magazine-page-card > * {
            position: relative;
            z-index: 2;
        }
        
        /* Slightly torn/cut edges */
        .magazine-page-card {
            clip-path: polygon(
                0% 0%,
                100% 0%,
                100% 99.5%,
                99.5% 100%,
                0.5% 100%,
                0% 99.5%
            );
        }
        
        /* Hover effects - LIFT THE NEWSPAPER CLIPPING */
        .magazine-page-card:hover {
            transform: translateY(-6px) rotate(-1deg);
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.2),
                0 5px 10px rgba(0, 0, 0, 0.15),
                inset 0 2px 0 rgba(255, 255, 255, 0.6),
                inset 0 -2px 0 rgba(0, 0, 0, 0.08);
            border-left-width: 5px;
        }
        
        :is(.dark .magazine-page-card:hover) {
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.7),
                0 5px 10px rgba(0, 0, 0, 0.6),
                inset 0 2px 0 rgba(255, 255, 255, 0.05),
                inset 0 -2px 0 rgba(0, 0, 0, 0.4);
        }
    </style>
    @endif
</div>
