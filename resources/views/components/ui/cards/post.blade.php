@props([
    'post' => null,
    'type' => 'poem', // poem, article
])

@php
$image = $post->thumbnail_url ?? ($post->featured_image_url ?? 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&q=80');
$route = $type === 'poem' ? route('poems.show', $post->id) : route('articles.show', $post->id);
@endphp

<article class="group bg-white dark:bg-neutral-900 rounded-2xl md:rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500"
         x-data
         x-intersect.half="$el.classList.add('animate-slide-up')"
         {{ $attributes }}>
    
    <!-- Post Header -->
    <div class="flex items-center justify-between p-4 md:p-6">
        <div class="flex items-center gap-3">
            <img src="{{ $post->user->profile_photo_url }}" 
                 alt="{{ $post->user->name }}" 
                 class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover ring-2 ring-primary-200 dark:ring-primary-900">
            <div>
                <div class="font-semibold text-sm md:text-base text-neutral-900 dark:text-white">{{ $post->user->name }}</div>
                <div class="text-xs md:text-sm text-neutral-500 dark:text-neutral-400">{{ $post->created_at->diffForHumans() }}</div>
            </div>
        </div>
    </div>

    <!-- Post Image (if applicable) -->
    @if($image)
    <div class="relative aspect-[4/3] overflow-hidden">
        <img src="{{ $image }}" 
             alt="{{ $post->title }}" 
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="p-4 md:p-6">
        <h3 class="text-lg md:text-xl font-semibold text-neutral-900 dark:text-white mb-3" style="font-family: 'Crimson Pro', serif;">
            "{{ $post->title }}"
        </h3>
        <p class="text-sm md:text-base leading-relaxed text-neutral-700 dark:text-neutral-300 italic line-clamp-3">
            {{ $post->description ?? Str::limit($post->content, 150) }}
        </p>
    </div>

    <!-- Post Actions -->
    <div class="px-4 md:px-6 pb-4 md:pb-6 flex items-center justify-between border-t border-neutral-100 dark:border-neutral-800 pt-4">
        <div class="flex items-center gap-4 md:gap-6">
            <button class="flex items-center gap-1.5 md:gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <span class="text-sm md:text-base font-semibold">{{ $post->like_count ?? 0 }}</span>
            </button>
            <button class="flex items-center gap-1.5 md:gap-2 text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span class="text-sm md:text-base font-semibold">{{ $post->comment_count ?? 0 }}</span>
            </button>
        </div>
        <a href="{{ $route }}" class="text-neutral-600 dark:text-neutral-400 hover:text-primary-600 transition-colors">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
        </a>
    </div>
</article>

