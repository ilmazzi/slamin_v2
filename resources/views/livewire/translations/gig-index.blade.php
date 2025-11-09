<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Poetic Header -->
        <div class="text-center mb-16 relative">
            <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-primary-200 dark:text-primary-900/30 text-9xl font-poem leading-none pointer-events-none">
                🌍
            </div>
            
            <div class="relative z-10">
                <h1 class="text-5xl md:text-7xl font-bold text-neutral-900 dark:text-white mb-4 font-poem tracking-tight">
                    {{ __('translations.available_gigs') }}
                </h1>
                <p class="text-lg md:text-xl text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto font-poem italic">
                    "{{ __('translations.subtitle') }}"
                </p>
            </div>
        </div>
        
        <!-- Search & Filters -->
        <div class="mb-12">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 
                        rounded-3xl shadow-2xl border border-white/20 dark:border-neutral-700/50 
                        p-6 md:p-8">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <!-- Search -->
                    <div class="md:col-span-1 relative">
                        <input wire:model.live.debounce.500ms="search"
                               type="text"
                               placeholder="{{ __('translations.search_gigs') }}"
                               class="w-full px-4 py-4 pl-12 rounded-2xl 
                                      border-2 border-neutral-200 dark:border-neutral-700 
                                      bg-white dark:bg-neutral-900
                                      text-neutral-900 dark:text-white placeholder:text-neutral-400
                                      focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                      transition-all duration-300">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    
                    <!-- Language Filter -->
                    <div class="relative">
                        <select wire:model.live="language"
                                class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                       bg-white dark:bg-neutral-800 
                                       border-2 border-neutral-200 dark:border-neutral-700
                                       text-neutral-900 dark:text-white
                                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                       transition-all duration-200 cursor-pointer font-medium">
                            <option value="">{{ __('poems.filters.all_languages') }}</option>
                            @foreach($languages as $code => $name)
                                <option value="{{ $code }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sort -->
                    <div class="relative">
                        <select wire:model.live="sort"
                                class="w-full appearance-none pl-4 pr-10 py-4 rounded-2xl 
                                       bg-white dark:bg-neutral-800 
                                       border-2 border-neutral-200 dark:border-neutral-700
                                       text-neutral-900 dark:text-white
                                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/30
                                       transition-all duration-200 cursor-pointer font-medium">
                            <option value="recent">{{ __('translations.sort_recent') }}</option>
                            <option value="compensation_high">{{ __('translations.sort_compensation_high') }}</option>
                            <option value="compensation_low">{{ __('translations.sort_compensation_low') }}</option>
                            <option value="deadline">{{ __('translations.sort_deadline') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gigs Grid -->
        @if($gigs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($gigs as $index => $gig)
                    <div class="h-full" style="animation-delay: {{ $index * 0.1 }}s" class="opacity-0 animate-fade-in">
                        <article class="h-full flex flex-col backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                       rounded-3xl shadow-xl hover:shadow-2xl
                                       border border-white/50 dark:border-neutral-700/50
                                       p-6 cursor-pointer group
                                       hover:-translate-y-2 transition-all duration-300"
                                onclick="window.location='{{ route('translations.gig.show', $gig) }}'">
                            
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-2xl">{{ config('poems.languages')[$gig->target_language] ?? $gig->target_language }}</span>
                                    <x-ui.badges.category label="{{ config('poems.languages')[$gig->target_language] ?? $gig->target_language }}" color="primary" class="!text-xs" />
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300">
                                    {{ __('translations.status.open') }}
                                </span>
                            </div>
                            
                            <!-- Poem Info -->
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2 font-poem line-clamp-2
                                       group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                "{{ $gig->poem->title ?: __('poems.untitled') }}"
                            </h3>
                            
                            <p class="text-sm text-neutral-600 dark:text-neutral-400 italic line-clamp-3 mb-4 font-poem flex-1">
                                {{ Str::limit(strip_tags($gig->poem->content), 120) }}
                            </p>
                            
                            <!-- Divisore -->
                            <div class="flex items-center justify-center my-4">
                                <div class="flex-1 h-px bg-neutral-300 dark:bg-neutral-600"></div>
                                <div class="px-3 text-neutral-400 text-sm">❦</div>
                                <div class="flex-1 h-px bg-neutral-300 dark:bg-neutral-600"></div>
                            </div>
                            
                            <!-- Details -->
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.proposed_compensation') }}:</span>
                                    <span class="font-bold text-primary-600 dark:text-primary-400">€{{ number_format($gig->proposed_compensation, 2) }}</span>
                                </div>
                                
                                @if($gig->deadline)
                                    <div class="flex items-center justify-between">
                                        <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.deadline') }}:</span>
                                        <span class="font-medium">{{ $gig->deadline->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.applications_count_label') }}:</span>
                                    <span class="font-medium">{{ $gig->applications()->count() }}</span>
                                </div>
                            </div>
                            
                            <!-- Author -->
                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <x-ui.user-avatar :user="$gig->requester" size="sm" :showName="true" :link="false" />
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $gigs->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-32 h-32 rounded-full 
                           bg-gradient-to-br from-primary-100 to-primary-50 
                           dark:from-primary-900/20 dark:to-primary-900/10
                           mb-8">
                    <svg class="w-16 h-16 text-primary-500 dark:text-primary-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                </div>
                
                <h3 class="text-3xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                    {{ __('translations.no_gigs') }}
                </h3>
                
                <p class="text-lg text-neutral-600 dark:text-neutral-400 mb-8 max-w-md mx-auto font-poem italic">
                    "{{ __('translations.no_gigs_description') }}"
                </p>
            </div>
        @endif
    </div>
</div>
