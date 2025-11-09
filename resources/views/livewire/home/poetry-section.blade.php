<div>
    @if($poems && $poems->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($poems->take(3) as $i => $poem)
        <div class="h-full" 
             x-data 
             x-intersect.once="$el.classList.add('animate-fade-in')" 
             style="animation-delay: {{ $i * 0.1 }}s">
            <livewire:poems.poem-card 
                :poem="$poem" 
                :show-actions="true"
                :key="'home-poem-'.$poem->id" 
                wire:key="home-poem-{{ $poem->id }}" />
        </div>
        @endforeach
    </div>

        <div class="text-center mt-10">
        <x-ui.buttons.primary :href="route('poems.index')" variant="outline" size="md" icon="M9 5l7 7-7 7">
            {{ __('home.all_poems_button') }}
        </x-ui.buttons.primary>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
    </style>
    @endif
</div>
