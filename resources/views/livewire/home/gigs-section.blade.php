<div>
    @if ($topGigs && $topGigs->count() > 0)
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8"
         x-data="{
             currentPage: 0,
             itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
             totalItems: {{ $topGigs->count() }},
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
                    {!! __('home.gigs_section_title') !!}
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-400">
                    {{ __('home.gigs_section_subtitle') }}
                </p>
            </div>

            <!-- Slider Controls (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <button @click="prev()" 
                        :disabled="currentPage === 0"
                        :class="currentPage === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-accent-100 dark:hover:bg-accent-900'"
                        class="w-12 h-12 rounded-full border-2 border-accent-600 dark:border-accent-500 flex items-center justify-center text-accent-600 dark:text-accent-400 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <span class="text-sm text-neutral-600 dark:text-neutral-400 font-medium min-w-[60px] text-center">
                    <span x-text="currentPage + 1"></span> / <span x-text="totalPages"></span>
                </span>
                <button @click="next()" 
                        :disabled="currentPage >= totalPages - 1"
                        :class="currentPage >= totalPages - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-accent-100 dark:hover:bg-accent-900'"
                        class="w-12 h-12 rounded-full border-2 border-accent-600 dark:border-accent-500 flex items-center justify-center text-accent-600 dark:text-accent-400 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Gigs Slider Container -->
        <div class="relative overflow-x-hidden -mx-3 px-3">
            <div class="flex transition-transform duration-500 ease-out pb-8"
                 :style="`transform: translateX(-${currentPage * 100}%)`">
                @foreach($topGigs as $i => $gig)
                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3"
                     x-data
                     x-intersect.once="$el.classList.add('animate-fade-in')"
                     style="animation-delay: {{ $i * 0.1 }}s">
                    
                    {{-- Gig Card --}}
                    <a href="{{ route('gigs.show', $gig) }}" 
                       class="group block h-full bg-white dark:bg-neutral-800 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border-t-4 border-accent-500 hover:border-accent-600 hover:-translate-y-2">
                        
                        {{-- Header with Badges --}}
                        <div class="p-6 border-b border-neutral-100 dark:border-neutral-700">
                            <div class="flex flex-wrap gap-2 mb-4">
                                @if($gig->is_featured)
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-wider bg-gradient-to-r from-blue-500 to-indigo-500 text-white">
                                        Featured
                                    </span>
                                @endif
                                @if($gig->is_urgent)
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-wider bg-gradient-to-r from-orange-500 to-red-500 text-white animate-pulse">
                                        Urgente
                                    </span>
                                @endif
                                @if($gig->is_remote)
                                    <span class="px-3 py-1 text-xs font-black uppercase tracking-wider bg-gradient-to-r from-green-500 to-emerald-500 text-white">
                                        Remoto
                                    </span>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-black text-neutral-900 dark:text-white mb-2 line-clamp-2 group-hover:text-accent-600 dark:group-hover:text-accent-400 transition-colors">
                                {{ $gig->title }}
                            </h3>
                            
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 line-clamp-2 mb-4">
                                {{ Str::limit(strip_tags($gig->description), 100) }}
                            </p>
                            
                            <div class="flex items-center gap-3 text-sm">
                                <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium">{{ $gig->user ? $gig->user->name : ($gig->requester ? $gig->requester->name : 'Anonimo') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Body --}}
                        <div class="p-6 space-y-3">
                            {{-- Category & Type --}}
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 text-xs font-bold bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 uppercase">
                                    {{ __('gigs.categories.' . $gig->category) }}
                                </span>
                                <span class="px-3 py-1 text-xs font-bold {{ $gig->type === 'paid' ? 'bg-accent-100 dark:bg-accent-900/30 text-accent-700 dark:text-accent-400' : 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400' }} uppercase">
                                    {{ __('gigs.types.' . $gig->type) }}
                                </span>
                            </div>
                            
                            {{-- Location & Deadline --}}
                            <div class="space-y-2">
                                @if($gig->location)
                                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium">{{ $gig->location }}</span>
                                    </div>
                                @endif
                                
                                @if($gig->deadline)
                                    <div class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium">{{ $gig->deadline->format('d M Y') }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Compensation (if exists) --}}
                            @if($gig->compensation)
                                <div class="pt-3 border-t border-neutral-100 dark:border-neutral-700">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-accent-600 dark:text-accent-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-bold text-accent-700 dark:text-accent-400 line-clamp-1">
                                            {{ $gig->compensation }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Applications Count --}}
                            <div class="pt-3 border-t border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-neutral-600 dark:text-neutral-400">Candidature</span>
                                    <span class="text-lg font-black text-primary-600 dark:text-primary-400">
                                        {{ $gig->application_count }}@if($gig->max_applications)<span class="text-sm text-neutral-500">/{{ $gig->max_applications }}</span>@endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Footer CTA --}}
                        <div class="px-6 pb-6">
                            <div class="w-full py-3 bg-gradient-to-r from-accent-500 to-accent-600 group-hover:from-accent-600 group-hover:to-accent-700 text-white text-center font-black uppercase tracking-wider text-sm transition-all">
                                Visualizza Dettagli
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Dots Indicator (Mobile) -->
        <div class="flex md:hidden justify-center gap-2 mt-8">
            <template x-for="i in totalPages" :key="i">
                <button @click="currentPage = i - 1"
                        :class="currentPage === i - 1 ? 'bg-accent-600 dark:bg-accent-500 w-8' : 'bg-neutral-300 dark:bg-neutral-600 w-3'"
                        class="h-3 rounded-full transition-all duration-300"></button>
            </template>
        </div>

        <!-- See All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('gigs.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 text-white font-black uppercase tracking-wider transition-all hover:shadow-2xl hover:scale-105">
                <span>{{ __('home.see_all_gigs') }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </div>
    @endif
</div>
