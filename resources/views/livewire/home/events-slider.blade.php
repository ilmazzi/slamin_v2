<div>
    @if ($recentEvents && $recentEvents->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8"
         x-data="{
             currentPage: 0,
             itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
             totalItems: {{ $recentEvents->count() }},
             get totalPages() {
                 return Math.ceil(this.totalItems / this.itemsPerPage);
             },
             next() {
                 if (this.currentPage < this.totalPages - 1) {
                     this.currentPage++;
                 }
             },
             prev() {
                 if (this.currentPage > 0) {
                     this.currentPage--;
                 }
             }
         }"
         x-init="
             window.addEventListener('resize', () => {
                 itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                 if (currentPage >= totalPages) currentPage = totalPages - 1;
             });
         ">
        
        <!-- Header con Navigation -->
        <div class="flex items-center justify-between mb-10">
            <div class="flex-1">
                <h2 class="text-4xl md:text-5xl font-bold mb-3 text-neutral-900 dark:text-white" style="font-family: 'Crimson Pro', serif;">
                    {!! __('home.events_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-400">
                    {{ __('home.events_section_subtitle') }}
                </p>
            </div>

            <!-- Slider Controls (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button @click="prev()" 
                        :disabled="currentPage === 0"
                        :class="currentPage === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-primary-100'"
                        class="w-12 h-12 rounded-full border-2 border-primary-600 flex items-center justify-center text-primary-600 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <span class="text-sm text-neutral-600 dark:text-neutral-400 font-medium min-w-[60px] text-center">
                    <span x-text="currentPage + 1"></span> / <span x-text="totalPages"></span>
                </span>
                <button @click="next()" 
                        :disabled="currentPage >= totalPages - 1"
                        :class="currentPage >= totalPages - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-primary-100'"
                        class="w-12 h-12 rounded-full border-2 border-primary-600 flex items-center justify-center text-primary-600 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Events Slider Container -->
        <div class="relative overflow-x-hidden -mx-3 px-3">
            <div class="flex transition-transform duration-500 ease-out pb-8"
                 :style="`transform: translateX(-${currentPage * 100}%)`">
                @foreach($recentEvents->take(6) as $i => $event)
                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ $i * 0.1 }}s">
                    <x-ui.cards.event :event="$event" :delay="0" />
                </div>
                @endforeach
            </div>
        </div>

        <!-- Dots Indicator (Mobile) -->
        <div class="flex md:hidden justify-center gap-2 mt-8">
            <template x-for="page in totalPages" :key="page">
                <button @click="currentPage = page - 1"
                        class="h-2 rounded-full transition-all"
                        :class="currentPage === page - 1 ? 'w-8 bg-primary-600' : 'w-2 bg-neutral-300'">
                </button>
            </template>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12">
            <x-ui.buttons.primary :href="route('events.index')" size="md" icon="M9 5l7 7-7 7">
                {{ __('home.all_events_button') }}
            </x-ui.buttons.primary>
        </div>
    </div>
    
    <style>
        @keyframes fade-in { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .animate-fade-in { animation: fade-in 0.5s ease-out forwards; opacity: 0; }
    </style>
    @endif
</div>
