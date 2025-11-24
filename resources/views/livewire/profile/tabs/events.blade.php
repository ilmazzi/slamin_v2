{{-- Events Tab - con riferimento grafico Ticket --}}
<div class="space-y-6">
    {{-- Header con Ticket --}}
    <div class="flex items-center gap-4 mb-6">
        <div class="relative" style="width: 80px; height: 60px;">
            <div class="event-show-ticket" style="transform: rotate(-2deg); background: linear-gradient(135deg, #fefaf3 0%, #fdf8f0 50%, #faf5ec 100%); padding: 0.5rem;">
                <div class="event-ticket-perforation-top" style="height: 8px;"></div>
                <div class="text-center" style="padding-top: 0.5rem;">
                    <div class="text-xs font-bold text-neutral-900">EVENT</div>
                </div>
            </div>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                {{ __('profile.events.title') }}
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.events.subtitle', ['count' => $events->total()]) }}</p>
        </div>
    </div>

    {{-- Events List --}}
    @if($events->count() > 0)
        <div class="space-y-4">
            @foreach($events as $event)
                <a href="{{ route('events.show', $event->id) }}" class="block group">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-700 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="flex flex-col sm:flex-row">
                            @if($event->image_url)
                            <div class="sm:w-48 h-48 sm:h-auto overflow-hidden bg-neutral-100 dark:bg-neutral-900">
                                <img src="{{ $event->image_url }}" 
                                     alt="{{ $event->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            @endif
                            <div class="flex-1 p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-semibold rounded-full">
                                        {{ \App\Models\Event::getCategories()[$event->category] ?? $event->category }}
                                    </span>
                                    @if($event->start_datetime)
                                    <span class="text-xs text-neutral-500 dark:text-neutral-500">
                                        {{ $event->start_datetime->format('d/m/Y H:i') }}
                                    </span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2 mb-3">
                                    {{ Str::limit(strip_tags($event->description), 150) }}
                                </p>
                                <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-500">
                                    @if($event->city)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $event->city }}
                                    </span>
                                    @endif
                                    @if($event->venue_name)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $event->venue_name }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($events->hasPages())
        <div class="mt-6">
            {{ $events->links() }}
        </div>
        @endif
    @else
        <div class="bg-white dark:bg-neutral-800 rounded-xl p-12 text-center border border-neutral-200 dark:border-neutral-700">
            <svg class="w-16 h-16 text-neutral-400 dark:text-neutral-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-neutral-600 dark:text-neutral-400">{{ __('profile.events.empty') }}</p>
        </div>
    @endif
</div>

