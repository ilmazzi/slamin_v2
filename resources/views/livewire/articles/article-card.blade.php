@php
    $heightClass = match($size) {
        'large' => 'h-64',
        'small' => 'h-40',
        default => 'h-48',
    };
    $titleSize = match($size) {
        'large' => 'text-2xl',
        'small' => 'text-base',
        default => 'text-xl',
    };
@endphp

<article class="group bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full">
    {{-- Immagine --}}
    <div class="relative overflow-hidden {{ $heightClass }}">
        @if($article->featured_image_url)
            <img 
                src="{{ $article->featured_image_url }}" 
                alt="{{ $article->title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            >
        @else
            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-accent-400 flex items-center justify-center">
                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
        @endif
        
        @if($showCategory && $article->category)
            <div class="absolute top-3 left-3">
                <span class="px-2.5 py-1 bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm text-xs font-semibold text-gray-700 dark:text-gray-300 rounded-full">
                    {{ $article->category->name }}
                </span>
            </div>
        @endif
    </div>

    {{-- Contenuto --}}
    <div class="p-6 flex-1 flex flex-col">
        <h3 class="{{ $titleSize }} font-bold text-gray-900 dark:text-white mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2">
            <a href="{{ route('articles.show', $article->slug) }}" wire:navigate>
                {{ $article->title }}
            </a>
        </h3>
        
        @if($showExcerpt && $article->excerpt)
            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3 flex-1">
                {{ $article->excerpt }}
            </p>
        @endif
        
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-4 border-t border-gray-200 dark:border-gray-700 mt-auto">
            <div class="flex items-center gap-3 flex-1">
                @if($showAuthor && $article->user)
                    <div class="flex items-center gap-2">
                        <img src="{{ $article->user->avatar }}" 
                             alt="{{ $article->user->name }}"
                             class="w-6 h-6 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700">
                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $article->user->name }}</span>
                    </div>
                    <span class="text-gray-400">•</span>
                @endif
                <span>{{ $article->published_at->format('d M Y') }}</span>
                @if($showStats)
                    <span class="text-gray-400">•</span>
                    <span>{{ $article->read_time }} min</span>
                @endif
            </div>
            
            {{-- Pulsante Social Share --}}
            <x-share-button 
                :url="route('articles.show', $article->slug)"
                :title="$article->title"
                size="sm"
            />
        </div>
    </div>
</article>
