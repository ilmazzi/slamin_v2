@php
    $isLarge = $isLarge ?? false;
    $index = $index ?? 0;
@endphp

<article 
    x-data="{ 
        visible: false,
        isHovered: false,
        tiltX: 0,
        tiltY: 0
    }"
    x-init="setTimeout(() => visible = true, {{ 50 + ($index * 60) }})"
    x-show="visible"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false; tiltX = 0; tiltY = 0"
    @mousemove="
        if (isHovered) {
            const rect = $el.getBoundingClientRect();
            const x = $event.clientX - rect.left;
            const y = $event.clientY - rect.top;
            tiltX = ((y / rect.height) - 0.5) * -10;
            tiltY = ((x / rect.width) - 0.5) * 10;
        }
    "
    x-transition:enter="transition ease-out duration-800"
    x-transition:enter-start="opacity-0 scale-90 {{ $isLarge ? 'rotate-2' : '-rotate-1' }}"
    x-transition:enter-end="opacity-100 scale-100 rotate-0"
    class="group relative overflow-hidden rounded-2xl cursor-pointer transition-all duration-300 {{ $isLarge ? 'min-h-[480px]' : 'min-h-[240px]' }}"
    :class="isHovered ? 'z-20 shadow-2xl' : 'z-10 shadow-lg'"
    :style="`transform: ${isHovered ? `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale(1.05)` : 'none'}`">
    
    <!-- Event Image Background -->
    <div class="absolute inset-0">
        @if($event->image_url)
        <img src="{{ $event->image_url }}" 
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
             alt="{{ $event->title }}">
        @else
        <div class="w-full h-full bg-gradient-to-br from-red-600 via-red-700 to-amber-700"></div>
        @endif
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>
    </div>
    
    <!-- Sparkle Effect on Hover -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping"></div>
        <div class="absolute top-1/3 right-1/3 w-1.5 h-1.5 bg-red-300 rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.1s"></div>
        <div class="absolute bottom-1/3 left-1/3 w-2 h-2 bg-amber-300 rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.2s"></div>
        <div class="absolute top-1/2 right-1/4 w-1 h-1 bg-white rounded-full opacity-0 group-hover:opacity-100 group-hover:animate-ping" style="animation-delay: 0.15s"></div>
    </div>
    
    <!-- Floating Category Badge -->
    <div class="absolute top-4 right-4 z-10 transform transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
        <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase rounded-full border border-white/30 shadow-lg">
            {{ str_replace('_', ' ', $event->category ?? 'Event') }}
        </span>
    </div>
    
    <!-- Content -->
    <div class="relative h-full flex flex-col justify-end {{ $isLarge ? 'p-6' : 'p-4' }}">
        <!-- Date Badge -->
        <div class="mb-2">
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-700/90 backdrop-blur-sm rounded-full">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-white text-xs font-semibold">
                    {{ $event->start_datetime ? $event->start_datetime->format('d M') : 'TBD' }}
                </span>
            </div>
        </div>
        
        <!-- Title -->
        <h3 class="text-white font-bold mb-1.5 {{ $isLarge ? 'text-2xl' : 'text-lg' }} line-clamp-2 group-hover:text-red-300 transition-colors">
            {{ $event->title }}
        </h3>
        
        <!-- Location -->
        <div class="flex items-center gap-1.5 text-white/80 text-xs mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>{{ $event->city }}</span>
        </div>
        
        @if($isLarge)
        <!-- Description (only for large cards) -->
        <p class="text-white/70 text-xs mb-3 line-clamp-2">
            {{ Str::limit($event->description, 100) }}
        </p>
        @endif
        
        <!-- Social Actions -->
        <div class="flex items-center gap-2" @click.stop>
            <x-like-button 
                :itemId="$event->id"
                itemType="event"
                :isLiked="$event->is_liked ?? false"
                :likesCount="$event->like_count ?? 0"
                size="sm"
                class="text-white" />
            
            <x-comment-button 
                :itemId="$event->id"
                itemType="event"
                :commentsCount="$event->comment_count ?? 0"
                size="sm"
                class="text-white" />
        </div>
        
        <!-- Hover Reveal: View Button -->
        <div class="mt-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
            <a href="{{ route('events.show', $event) }}" 
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-red-700 rounded-full font-semibold hover:bg-red-50 transition-colors text-xs">
                {{ __('events.view_details') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Animated Border on Hover -->
    <div class="absolute inset-0 border-3 border-red-400/60 opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300 pointer-events-none"></div>
    
    <!-- Shine Effect on Hover -->
    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none overflow-hidden">
        <div class="absolute -inset-full bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 group-hover:animate-shine"></div>
    </div>
    
    <!-- Glow Effect Under Card -->
    <div class="absolute -inset-4 bg-gradient-to-r from-red-600/0 via-red-600/20 to-amber-600/0 blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
    
    <!-- Click Overlay -->
    <a href="{{ route('events.show', $event) }}" class="absolute inset-0 z-5"></a>
</article>

