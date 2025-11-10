<div>
    @if($articles && $articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($articles->take(3) as $i => $article)
        <article class="group magazine-page-card" x-data x-intersect.once="$el.classList.add('animate-fade-in')" style="animation-delay: {{ $i * 0.1 }}s">
            <a href="{{ route('articles.show', $article->id) }}" class="block h-full">
                
                {{-- Magazine Page Effect Container --}}
                <div class="relative h-full magazine-page-content">
                    
                    @if($article->featured_image_url)
                    <div class="aspect-[16/10] overflow-hidden mb-4 relative">
                        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        
                        {{-- Page Marker Corner --}}
                        <div class="magazine-corner"></div>
                    </div>
                    @endif
                
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
                
                    <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2 text-sm mb-3">
                        {{ $article->excerpt ?? Str::limit($article->content, 100) }}
                    </p>
                
                </div>
                {{-- End Magazine Page Content --}}
            </a>
            
            <!-- Social Actions - Using Reusable Components -->
            <div class="flex items-center gap-4 mt-3 px-4" @click.stop>
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
        
        /* Magazine Page Effect */
        .magazine-page-card {
            position: relative;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .magazine-page-content {
            position: relative;
            background: linear-gradient(135deg, 
                #f8f9fa 0%, 
                #f1f3f5 50%, 
                #e9ecef 100%
            );
            padding: 1.5rem;
            box-shadow: 
                0 1px 3px rgba(0, 0, 0, 0.05),
                0 4px 12px rgba(0, 0, 0, 0.08),
                inset -2px 0 4px rgba(0, 0, 0, 0.03);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Dark mode */
        :is(.dark .magazine-page-content) {
            background: linear-gradient(135deg, 
                #2d3748 0%, 
                #1a202c 50%, 
                #171923 100%
            );
            box-shadow: 
                0 1px 3px rgba(0, 0, 0, 0.3),
                0 4px 12px rgba(0, 0, 0, 0.4),
                inset -2px 0 4px rgba(0, 0, 0, 0.5);
        }
        
        /* Texture overlay - Glossy magazine paper */
        .magazine-page-content::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                repeating-linear-gradient(
                    0deg,
                    rgba(0, 0, 0, 0.01) 0px,
                    transparent 1px,
                    transparent 2px,
                    rgba(0, 0, 0, 0.01) 3px
                );
            pointer-events: none;
            opacity: 0.3;
        }
        
        /* Subtle column pattern (like magazine text columns) */
        .magazine-page-content::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                repeating-linear-gradient(
                    90deg,
                    transparent 0px,
                    transparent 45%,
                    rgba(0, 0, 0, 0.01) 45%,
                    rgba(0, 0, 0, 0.01) 50%,
                    transparent 50%
                );
            pointer-events: none;
            opacity: 0.2;
        }
        
        /* Page corner marker (folded corner effect) */
        .magazine-corner {
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 30px 30px 0;
            border-color: transparent rgba(255, 255, 255, 0.3) transparent transparent;
            filter: drop-shadow(-1px 1px 2px rgba(0, 0, 0, 0.1));
            transition: border-width 0.3s ease;
        }
        
        :is(.dark .magazine-corner) {
            border-color: transparent rgba(0, 0, 0, 0.3) transparent transparent;
        }
        
        /* Hover effects */
        .magazine-page-card:hover .magazine-page-content {
            transform: translateY(-4px);
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.1),
                0 12px 24px rgba(0, 0, 0, 0.15),
                inset -3px 0 6px rgba(0, 0, 0, 0.05);
        }
        
        :is(.dark .magazine-page-card:hover .magazine-page-content) {
            box-shadow: 
                0 4px 8px rgba(0, 0, 0, 0.4),
                0 12px 24px rgba(0, 0, 0, 0.5),
                inset -3px 0 6px rgba(0, 0, 0, 0.6);
        }
        
        .magazine-page-card:hover .magazine-corner {
            border-width: 0 40px 40px 0;
        }
        
        /* Worn edges effect */
        .magazine-page-content {
            clip-path: polygon(
                0% 1%,
                1% 0%,
                99% 0%,
                100% 1%,
                100% 99%,
                99% 100%,
                1% 100%,
                0% 99%
            );
        }
    </style>
    @endif
</div>
