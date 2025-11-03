<div>
    @if($articles && $articles->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10 lg:gap-12">
        @foreach($articles->take(3) as $article)
        <article class="group"
                 x-data
                 x-intersect.half="$el.classList.add('animate-fade-in-up')">
            <a href="{{ route('articles.show', $article->id) }}" class="block">
                @if($article->featured_image_url)
                <div class="aspect-[16/10] rounded-2xl overflow-hidden mb-6 relative">
                    <img src="{{ $article->featured_image_url }}" 
                         alt="{{ $article->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                @endif
                
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ $article->user->profile_photo_url }}" 
                         alt="{{ $article->user->name }}" 
                         class="w-10 h-10 rounded-full object-cover ring-2 ring-primary-200">
                    <div>
                        <div class="font-semibold text-sm text-neutral-900 dark:text-white">{{ $article->user->name }}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400">{{ $article->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <h3 class="text-2xl font-bold mb-3 text-neutral-900 dark:text-white group-hover:text-primary-600 transition-colors" style="font-family: 'Crimson Pro', serif;">
                    {{ $article->title }}
                </h3>
                
                <p class="text-neutral-600 dark:text-neutral-400 line-clamp-3 leading-relaxed mb-4">
                    {{ $article->excerpt ?? Str::limit($article->content, 150) }}
                </p>

                <div class="flex items-center gap-6 text-sm text-neutral-500 dark:text-neutral-400">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        {{ $article->like_count ?? 0 }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        {{ $article->comment_count ?? 0 }}
                    </span>
                </div>
            </a>
        </article>
        @endforeach
    </div>

    <div class="text-center mt-12">
        <x-ui.buttons.primary :href="route('articles.index')" variant="outline" size="md" icon="M9 5l7 7-7 7">
            Tutti gli Articoli
        </x-ui.buttons.primary>
    </div>
    
    <style>
        @keyframes fade-in-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; opacity: 0; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @endif
</div>
