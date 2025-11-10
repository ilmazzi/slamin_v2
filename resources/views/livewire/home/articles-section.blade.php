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
                    @if($article->featured_image_url)
                    <div class="aspect-[16/10] overflow-hidden mb-4 relative -mx-6 -mt-6">
                        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    @endif
                    
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-200">
                            <div>
                                <p class="font-semibold text-sm text-neutral-900 dark:text-white">{{ $article->user->name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $article->created_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold mb-2 text-neutral-900 dark:text-white group-hover:text-primary-600 transition-colors" style="font-family: 'Crimson Pro', serif;">
                            {{ $article->title }}
                        </h3>
                        
                        <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2 text-sm mb-4">
                            {{ $article->excerpt ?? Str::limit($article->content, 100) }}
                        </p>
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
        
        /* Magazine Page Effect - MORE VISIBLE */
        .magazine-page-card {
            position: relative;
            height: 100%;
            background: 
                /* Paper grain texture */
                repeating-linear-gradient(
                    0deg,
                    rgba(0, 0, 0, 0.03) 0px,
                    transparent 1px,
                    transparent 2px
                ),
                /* Column pattern */
                repeating-linear-gradient(
                    90deg,
                    transparent 0px,
                    transparent 47%,
                    rgba(0, 0, 0, 0.02) 47%,
                    rgba(0, 0, 0, 0.02) 53%,
                    transparent 53%
                ),
                /* Base gradient - cooler tones (blue-grey) */
                linear-gradient(145deg, 
                    #e8eef4 0%,
                    #dce4ec 25%,
                    #d4dde6 50%,
                    #dce4ec 75%,
                    #e8eef4 100%
                );
            padding: 1.5rem;
            box-shadow: 
                /* Outer shadows */
                0 3px 6px rgba(0, 0, 0, 0.08),
                0 10px 20px rgba(0, 0, 0, 0.12),
                /* Central fold shadow */
                inset -4px 0 8px rgba(0, 0, 0, 0.08),
                inset 4px 0 8px rgba(0, 0, 0, 0.04),
                /* Subtle top/bottom edges */
                inset 0 2px 4px rgba(255, 255, 255, 0.5),
                inset 0 -2px 4px rgba(0, 0, 0, 0.03);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }
        
        /* Dark mode - darker but still distinct */
        :is(.dark .magazine-page-card) {
            background: 
                /* Paper grain texture */
                repeating-linear-gradient(
                    0deg,
                    rgba(255, 255, 255, 0.02) 0px,
                    transparent 1px,
                    transparent 2px
                ),
                /* Column pattern */
                repeating-linear-gradient(
                    90deg,
                    transparent 0px,
                    transparent 47%,
                    rgba(255, 255, 255, 0.015) 47%,
                    rgba(255, 255, 255, 0.015) 53%,
                    transparent 53%
                ),
                /* Base gradient - blue-grey dark */
                linear-gradient(145deg, 
                    #374151 0%,
                    #2d3748 25%,
                    #1f2937 50%,
                    #2d3748 75%,
                    #374151 100%
                );
            box-shadow: 
                0 3px 6px rgba(0, 0, 0, 0.5),
                0 10px 20px rgba(0, 0, 0, 0.6),
                inset -4px 0 8px rgba(0, 0, 0, 0.4),
                inset 4px 0 8px rgba(0, 0, 0, 0.2),
                inset 0 2px 4px rgba(255, 255, 255, 0.03),
                inset 0 -2px 4px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Additional shine effect (glossy magazine) */
        .magazine-page-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 50%;
            height: 100%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0.15) 0%,
                rgba(255, 255, 255, 0.05) 50%,
                transparent 100%
            );
            pointer-events: none;
            z-index: 1;
        }
        
        :is(.dark .magazine-page-card::before) {
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0.04) 0%,
                rgba(255, 255, 255, 0.01) 50%,
                transparent 100%
            );
        }
        
        /* Ensure content is above effects */
        .magazine-page-card > * {
            position: relative;
            z-index: 2;
        }
        
        /* Page corner marker (folded corner effect) - BIGGER AND MORE VISIBLE */
        .magazine-corner {
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 50px 50px 0;
            border-color: transparent rgba(255, 255, 255, 0.8) transparent transparent;
            filter: drop-shadow(-2px 2px 4px rgba(0, 0, 0, 0.2));
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        :is(.dark .magazine-corner) {
            border-color: transparent rgba(0, 0, 0, 0.5) transparent transparent;
            filter: drop-shadow(-2px 2px 4px rgba(0, 0, 0, 0.6));
        }
        
        /* Add fold line to corner */
        .magazine-corner::after {
            content: '';
            position: absolute;
            top: -50px;
            right: 0;
            width: 70px;
            height: 1px;
            background: linear-gradient(135deg, transparent, rgba(0, 0, 0, 0.15), transparent);
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
        
        /* Hover effects - dramatic lift */
        .magazine-page-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                /* Enhanced outer shadows */
                0 8px 16px rgba(0, 0, 0, 0.15),
                0 20px 40px rgba(0, 0, 0, 0.2),
                /* Deeper fold */
                inset -6px 0 12px rgba(0, 0, 0, 0.12),
                inset 6px 0 12px rgba(0, 0, 0, 0.06),
                inset 0 3px 6px rgba(255, 255, 255, 0.6),
                inset 0 -3px 6px rgba(0, 0, 0, 0.05);
        }
        
        :is(.dark .magazine-page-card:hover) {
            box-shadow: 
                0 8px 16px rgba(0, 0, 0, 0.6),
                0 20px 40px rgba(0, 0, 0, 0.7),
                inset -6px 0 12px rgba(0, 0, 0, 0.5),
                inset 6px 0 12px rgba(0, 0, 0, 0.3),
                inset 0 3px 6px rgba(255, 255, 255, 0.05),
                inset 0 -3px 6px rgba(0, 0, 0, 0.4);
        }
        
        .magazine-page-card:hover .magazine-corner {
            border-width: 0 60px 60px 0;
            filter: drop-shadow(-3px 3px 6px rgba(0, 0, 0, 0.3));
        }
        
        :is(.dark .magazine-page-card:hover .magazine-corner) {
            filter: drop-shadow(-3px 3px 6px rgba(0, 0, 0, 0.8));
        }
    </style>
    @endif
</div>
