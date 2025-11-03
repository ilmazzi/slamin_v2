<div>
    @if ($recentEvents && $recentEvents->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                Eventi <span class="italic text-primary-600">in Arrivo</span>
            </h2>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                Non perdere i prossimi appuntamenti poetici
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($recentEvents->take(6) as $i => $event)
                <x-ui.cards.event :event="$event" :delay="$i * 0.1" />
            @endforeach
        </div>

        <div class="text-center mt-10">
            <x-ui.buttons.primary :href="route('events.index')" size="md" icon="M9 5l7 7-7 7">
                Tutti gli Eventi
            </x-ui.buttons.primary>
        </div>
    </div>
    @endif
</div>
