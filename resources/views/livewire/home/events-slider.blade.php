<div>
    @if ($recentEvents && $recentEvents->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-12 md:mb-16">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                Eventi <span class="italic text-primary-600">in Arrivo</span>
            </h2>
            <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 mb-8">
                Non perdere i prossimi appuntamenti poetici
            </p>
        </div>

        <div class="space-y-6 md:space-y-0 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8 lg:gap-10">
            @foreach($recentEvents->take(6) as $i => $event)
                <x-ui.cards.event :event="$event" :delay="$i * 0.1" />
            @endforeach
        </div>

        <div class="text-center mt-12 md:mt-16">
            <x-ui.buttons.primary :href="route('events.index')" size="lg" icon="M9 5l7 7-7 7">
                Tutti gli Eventi
            </x-ui.buttons.primary>
        </div>
    </div>
    @endif
</div>
