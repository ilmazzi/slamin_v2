<div>
    @if ($recentEvents && $recentEvents->count() > 0)
    <section id="events" class="py-12 md:py-20 bg-white dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 md:mb-12 gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                        {{ __('home.events_section.title') }}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400">Non perdere i prossimi appuntamenti poetici</p>
                </div>
                <x-ui.buttons.primary 
                    :href="route('events.index')" 
                    variant="outline"
                    size="md"
                    icon="M9 5l7 7-7 7">
                    Vedi tutti
                </x-ui.buttons.primary>
            </div>

            <!-- Events Grid -->
            <div class="space-y-6 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-6">
                @foreach($recentEvents->take(6) as $i => $event)
                    <x-ui.cards.event :event="$event" :delay="$i * 0.1" />
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
