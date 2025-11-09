<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Back Button -->
        <a href="{{ route('translations.gigs.index') }}" 
           class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-400
                  hover:text-primary-500 transition-colors mb-8 group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="font-poem">{{ __('translations.back_to_gigs') }}</span>
        </a>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content - Gig Details -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Poesia da Tradurre - Vintage Paper -->
                <article class="relative" style="transform: perspective(1200px) rotateX(1deg);">
                    <div class="relative vintage-paper-sheet-card overflow-visible p-8">
                        <div class="vintage-corner-card"></div>
                        <div class="vintage-texture-card"></div>
                        <div class="vintage-stains-card"></div>
                        
                        <div class="relative z-10">
                            <!-- Status Badge -->
                            <div class="flex items-center justify-between mb-6">
                                <span class="px-4 py-2 rounded-full text-sm font-bold
                                             {{ $gig->status === 'open' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 
                                                ($gig->status === 'in_progress' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 
                                                'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300') }}">
                                    {{ __('translations.status.' . $gig->status) }}
                                </span>
                                
                                <span class="text-3xl">{{ config('poems.languages')[$gig->target_language] ?? $gig->target_language }}</span>
                            </div>
                            
                            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-neutral-100 mb-4 font-poem leading-tight">
                                "{{ $gig->poem->title ?: __('poems.untitled') }}"
                            </h1>
                            
                            <div class="flex items-center gap-4 mb-6">
                                <x-ui.user-avatar :user="$gig->poem->user" size="sm" :showName="true" :link="false" />
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ $gig->poem->created_at->diffForHumans() }}
                                </span>
                            </div>
                            
                            <!-- Divisore -->
                            <div class="flex items-center justify-center my-6">
                                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-neutral-400/30 to-neutral-400/15"></div>
                                <div class="px-4 text-neutral-500/50 text-xl">❦</div>
                                <div class="flex-1 h-px bg-gradient-to-l from-transparent via-neutral-400/30 to-neutral-400/15"></div>
                            </div>
                            
                            <!-- Estratto Poesia -->
                            <div class="text-lg text-neutral-700 dark:text-neutral-300 font-poem italic leading-relaxed mb-6 line-clamp-6">
                                {{ strip_tags($gig->poem->content) }}
                            </div>
                            
                            <a href="{{ route('poems.show', $gig->poem->slug) }}"
                               class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:underline font-semibold">
                                {{ __('translations.view_full_poem') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                
                <!-- Requisiti (se presenti) -->
                @if($gig->requirements)
                    <div class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                rounded-3xl shadow-xl border border-white/50 dark:border-neutral-700/50 p-8">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4 font-poem flex items-center gap-3">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            {{ __('translations.requirements') }}
                        </h2>
                        <p class="text-neutral-700 dark:text-neutral-300 font-poem whitespace-pre-line">
                            {{ $gig->requirements }}
                        </p>
                    </div>
                @endif
                
                <!-- Application Form (se può candidarsi) -->
                @if($canApply)
                    @if($showApplicationForm)
                        <div class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                    rounded-3xl shadow-xl border border-white/50 dark:border-neutral-700/50 p-8">
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 font-poem">
                                {{ __('translations.your_proposal') }}
                            </h2>
                            
                            <form wire:submit.prevent="submitApplication" class="space-y-6">
                                <!-- Cover Letter -->
                                <div>
                                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                        {{ __('translations.cover_letter') }} <span class="text-red-500">*</span>
                                    </label>
                                    <textarea wire:model="coverLetter"
                                              rows="6"
                                              placeholder="{{ __('translations.cover_letter_placeholder') }}"
                                              class="w-full px-4 py-3 rounded-2xl 
                                                     border-2 border-neutral-200 dark:border-neutral-700
                                                     bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                                     focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                                     transition-all duration-300 font-poem
                                                     resize-none placeholder:italic"></textarea>
                                    @error('coverLetter')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-6">
                                    <!-- Compenso -->
                                    <div>
                                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                            {{ __('translations.your_compensation') }} <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500 font-bold">€</span>
                                            <input wire:model="proposedCompensation"
                                                   type="number"
                                                   step="0.01"
                                                   min="0"
                                                   class="w-full pl-8 pr-4 py-3 rounded-2xl 
                                                          border-2 border-neutral-200 dark:border-neutral-700
                                                          bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                                          focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                                          transition-all duration-300 font-medium">
                                        </div>
                                        @error('proposedCompensation')
                                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Delivery -->
                                    <div>
                                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                            {{ __('translations.estimated_delivery') }} <span class="text-red-500">*</span>
                                        </label>
                                        <input wire:model="estimatedDelivery"
                                               type="date"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full px-4 py-3 rounded-2xl 
                                                      border-2 border-neutral-200 dark:border-neutral-700
                                                      bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white
                                                      focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                                      transition-all duration-300 font-medium">
                                        @error('estimatedDelivery')
                                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Buttons -->
                                <div class="flex items-center justify-end gap-4">
                                    <button type="button"
                                            wire:click="toggleApplicationForm"
                                            class="px-6 py-3 rounded-2xl font-medium
                                                   bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300
                                                   hover:bg-neutral-200 dark:hover:bg-neutral-600
                                                   transition-all duration-200">
                                        {{ __('common.cancel') }}
                                    </button>
                                    
                                    <button type="submit"
                                            wire:loading.attr="disabled"
                                            class="px-8 py-3 rounded-2xl font-bold
                                                   bg-gradient-to-r from-primary-500 to-primary-600
                                                   hover:from-primary-600 hover:to-primary-700
                                                   text-white shadow-xl hover:shadow-2xl
                                                   hover:-translate-y-1 transition-all duration-300
                                                   disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span wire:loading.remove>{{ __('translations.send_application') }}</span>
                                        <span wire:loading>{{ __('common.loading') }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <button wire:click="toggleApplicationForm"
                                class="w-full py-4 rounded-2xl font-bold text-lg
                                       bg-gradient-to-r from-primary-500 to-primary-600
                                       hover:from-primary-600 hover:to-primary-700
                                       text-white shadow-xl hover:shadow-2xl
                                       hover:-translate-y-1 transition-all duration-300
                                       flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="font-poem">{{ __('translations.apply_to_gig') }}</span>
                        </button>
                    @endif
                @endif
                
                <!-- Applications List (se sei il requester) -->
                @if($isRequester && $gig->applications->count() > 0)
                    <div class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                rounded-3xl shadow-xl border border-white/50 dark:border-neutral-700/50 p-8">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6 font-poem">
                            {{ __('translations.applications_received') }} ({{ $gig->applications->count() }})
                        </h2>
                        
                        <div class="space-y-6">
                            @foreach($gig->applications as $application)
                                <div class="p-6 rounded-2xl border-2
                                            {{ $application->status === 'accepted' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 
                                               ($application->status === 'rejected' ? 'border-red-300 bg-neutral-50 dark:bg-neutral-800' : 
                                               'border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900') }}">
                                    
                                    <div class="flex items-start justify-between mb-4">
                                        <x-ui.user-avatar :user="$application->translator" size="md" :showName="true" :link="false" />
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                                     {{ $application->status === 'accepted' ? 'bg-green-500 text-white' : 
                                                        ($application->status === 'rejected' ? 'bg-red-500 text-white' : 
                                                        'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300') }}">
                                            {{ __('translations.application_status.' . $application->status) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-neutral-700 dark:text-neutral-300 italic mb-4 font-poem">
                                        "{{ $application->cover_letter }}"
                                    </p>
                                    
                                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                        <div>
                                            <span class="text-neutral-500 dark:text-neutral-400">{{ __('translations.proposed_compensation') }}:</span>
                                            <span class="font-bold text-primary-600 dark:text-primary-400 ml-2">€{{ number_format($application->proposed_compensation, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-neutral-500 dark:text-neutral-400">{{ __('translations.estimated_delivery') }}:</span>
                                            <span class="font-medium ml-2">{{ $application->estimated_delivery->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($application->status === 'pending' && $gig->status === 'open')
                                        <div class="flex gap-3">
                                            <button wire:click="acceptApplication({{ $application->id }})"
                                                    class="flex-1 px-4 py-2 rounded-xl font-semibold
                                                           bg-green-500 hover:bg-green-600 text-white
                                                           transition-all duration-200">
                                                {{ __('translations.accept_application') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Your Application Status (se hai già applicato) -->
                @if($userApplication)
                    <div class="backdrop-blur-xl bg-blue-50/80 dark:bg-blue-900/20 
                                rounded-3xl shadow-xl border border-blue-200 dark:border-blue-800 p-8">
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-4 font-poem">
                            {{ __('translations.your_application') }}
                        </h2>
                        <div class="space-y-3 text-blue-800 dark:text-blue-200">
                            <p><strong>{{ __('translations.status') }}:</strong> {{ __('translations.application_status.' . $userApplication->status) }}</p>
                            <p><strong>{{ __('translations.proposed_compensation') }}:</strong> €{{ number_format($userApplication->proposed_compensation, 2) }}</p>
                            <p><strong>{{ __('translations.estimated_delivery') }}:</strong> {{ $userApplication->estimated_delivery->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar - Gig Info -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Gig Details Card -->
                <div class="sticky top-24 backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                            rounded-3xl shadow-xl border border-white/50 dark:border-neutral-700/50 p-6">
                    
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-6 font-poem">
                        {{ __('translations.gig_details') }}
                    </h3>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex items-center justify-between py-3 border-b border-neutral-200 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.target_language') }}</span>
                            <span class="font-bold text-lg">{{ config('poems.languages')[$gig->target_language] ?? $gig->target_language }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between py-3 border-b border-neutral-200 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.proposed_compensation') }}</span>
                            <span class="font-bold text-2xl text-primary-600 dark:text-primary-400">€{{ number_format($gig->proposed_compensation, 2) }}</span>
                        </div>
                        
                        @if($gig->deadline)
                            <div class="flex items-center justify-between py-3 border-b border-neutral-200 dark:border-neutral-700">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.deadline') }}</span>
                                <span class="font-medium">{{ $gig->deadline->format('d/m/Y') }}</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-between py-3">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('translations.applications_count_label') }}</span>
                            <span class="font-bold text-lg">{{ $gig->applications()->count() }}</span>
                        </div>
                    </div>
                    
                    <!-- Divisore -->
                    <div class="flex items-center justify-center my-6">
                        <div class="flex-1 h-px bg-neutral-300 dark:bg-neutral-600"></div>
                        <div class="px-3 text-neutral-400">❦</div>
                        <div class="flex-1 h-px bg-neutral-300 dark:bg-neutral-600"></div>
                    </div>
                    
                    <!-- Requester Info -->
                    <div>
                        <h4 class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 mb-3">
                            {{ __('translations.requested_by') }}
                        </h4>
                        <x-ui.user-avatar :user="$gig->requester" size="md" :showName="true" :link="false" />
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">
                            {{ $gig->created_at->diffForHumans() }}
                        </p>
                    </div>
                    
                    <!-- Cancel Button (se sei il requester e status è open) -->
                    @if($isRequester && $gig->status === 'open')
                        <button wire:click="cancelGig"
                                wire:confirm="{{ __('translations.confirm_cancel_gig') }}"
                                class="w-full mt-6 px-4 py-3 rounded-2xl font-medium
                                       bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400
                                       hover:bg-red-100 dark:hover:bg-red-900/30
                                       border-2 border-red-200 dark:border-red-800
                                       transition-all duration-200">
                            {{ __('translations.cancel_gig') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
