<div>
    @if($poems && $poems->count() > 0)
    <div class="space-y-6">
        <!-- Section Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white">
                Poesie Recenti
            </h3>
            <x-ui.buttons.primary 
                :href="route('poems.index')" 
                variant="ghost"
                size="sm"
                icon="M9 5l7 7-7 7">
                Vedi tutte
            </x-ui.buttons.primary>
        </div>

        <!-- Poems Grid -->
        <div class="space-y-6">
            @foreach($poems->take(3) as $poem)
                <x-ui.cards.post :post="$poem" type="poem" />
            @endforeach
        </div>
    </div>
    @endif
</div>
