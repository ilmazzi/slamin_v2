<div>
    @if($articles && $articles->count() > 0)
    <div class="space-y-6">
        <!-- Section Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-2xl md:text-3xl font-bold text-neutral-900 dark:text-white">
                Articoli Recenti
            </h3>
            <x-ui.buttons.primary 
                :href="route('articles.index')" 
                variant="ghost"
                size="sm"
                icon="M9 5l7 7-7 7">
                Vedi tutti
            </x-ui.buttons.primary>
        </div>

        <!-- Articles Grid -->
        <div class="space-y-6">
            @foreach($articles->take(3) as $article)
                <x-ui.cards.post :post="$article" type="article" />
            @endforeach
        </div>
    </div>
    @endif
</div>
