@props([
    'event' => null,
    'delay' => 0,
])

<article 
    class="group cursor-pointer overflow-hidden rounded-2xl md:rounded-3xl bg-white dark:bg-neutral-800 shadow-lg hover:shadow-2xl transition-all duration-500"
    x-data="{ hovered: false }"
    @mouseenter="hovered = true"
    @mouseleave="hovered = false"
    x-intersect.half="$el.classList.add('animate-slide-up')"
    style="animation-delay: {{ $delay }}s"
    {{ $attributes }}
>
    <!-- Event Image -->
    <div class="relative h-56 md:h-64 overflow-hidden">
        <img src="{{ $event->image_url ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80' }}" 
             alt="{{ $event->title }}" 
             class="w-full h-full object-cover transition-transform duration-700"
             :class="hovered && 'scale-110'">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
        
        <!-- Date Badge -->
        <div class="absolute top-4 left-4 transition-transform duration-300" :class="hovered && 'scale-110'">
            <x-ui.badges.date :date="$event->start_datetime" />
        </div>

        <!-- Category Badge -->
        @if($event->category)
        <div class="absolute top-4 right-4 transition-transform duration-300" :class="hovered && 'scale-110'">
            <x-ui.badges.category :label="$event->category" />
        </div>
        @endif

        <!-- Event Title & Info (Overlay) -->
        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-6 text-white">
            <h3 class="text-xl md:text-2xl font-bold mb-2 line-clamp-2" style="font-family: 'Crimson Pro', serif;">
                {{ $event->title }}
            </h3>
            <div class="flex items-center gap-2 text-white/90 text-sm mb-3">
                @if($event->venue_name || $event->city)
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                <span>{{ $event->city ?? $event->venue_name }}</span>
                @endif
                @if($event->start_datetime)
                <span class="mx-2">•</span>
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $event->start_datetime->format('H:i') }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Event Details -->
    <div class="p-4 md:p-6 min-h-[140px] flex flex-col justify-between">
        @if($event->description)
        <p class="text-sm md:text-base text-neutral-600 dark:text-neutral-400 mb-4 line-clamp-3">
            {{ $event->description }}
        </p>
        @endif
        
        <!-- Attendees & CTA -->
        <div class="flex items-center justify-between">
            @if($event->organizer)
            <div class="flex items-center gap-2">
                <img src="{{ $event->organizer->profile_photo_url }}" 
                     alt="{{ $event->organizer->name }}" 
                     class="w-8 h-8 rounded-full border-2 border-white dark:border-neutral-800 object-cover">
                <span class="text-xs md:text-sm text-neutral-600 dark:text-neutral-400 font-medium">
                    {{ $event->organizer->name }}
                </span>
            </div>
            @endif
            
            <x-ui.buttons.primary 
                :href="route('events.show', $event->id)" 
                size="sm">
                Partecipa
            </x-ui.buttons.primary>
        </div>
    </div>
</article>

