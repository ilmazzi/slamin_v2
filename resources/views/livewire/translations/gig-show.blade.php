<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('gigs.index') }}" 
               class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('gigs.back_to_list') }}
            </a>
        </div>

        <!-- Main Card -->
        <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-3xl shadow-2xl border border-white/20 dark:border-neutral-700/50 overflow-hidden">
            
            <!-- Header with Badges -->
            <div class="p-8 border-b border-neutral-200 dark:border-neutral-700">
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($gig->is_featured)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                            ⭐ {{ __('gigs.status.featured') }}
                        </span>
                    @endif
                    
                    @if($gig->is_urgent)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                            🔥 {{ __('gigs.status.urgent') }}
                        </span>
                    @endif

                    @if($gig->is_remote)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                            🌐 {{ __('gigs.remote') }}
                        </span>
                    @endif

                    @if($gig->is_closed)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                            🔒 {{ __('gigs.status.closed') }}
                        </span>
                    @endif
                </div>

                <h1 class="text-4xl font-bold text-neutral-900 dark:text-white mb-4">
                    {{ $gig->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ $gig->user ? $gig->user->name : ($gig->requester ? $gig->requester->name : __('gigs.anonymous')) }}
                    </span>

                    @if($gig->location)
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $gig->location }}
                        </span>
                    @endif

                    @if($gig->deadline)
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $gig->deadline->format('d M Y H:i') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                
                <!-- Description -->
                <div>
                    <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-3">
                        {{ __('gigs.fields.description') }}
                    </h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($gig->description)) !!}
                    </div>
                </div>

                <!-- Requirements -->
                @if($gig->requirements)
                    <div>
                        <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-3">
                            {{ __('gigs.fields.requirements') }}
                        </h2>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($gig->requirements)) !!}
                        </div>
                    </div>
                @endif

                <!-- Compensation -->
                @if($gig->compensation)
                    <div>
                        <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-3">
                            {{ __('gigs.fields.compensation') }}
                        </h2>
                        <div class="text-lg font-semibold text-primary-600 dark:text-primary-400">
                            {{ $gig->compensation }}
                        </div>
                    </div>
                @endif

                <!-- Category & Type -->
                <div class="flex flex-wrap gap-4">
                    <div>
                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('gigs.fields.category') }}:</span>
                        <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200">
                            {{ __('gigs.categories.' . $gig->category) }}
                        </span>
                    </div>

                    <div>
                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('gigs.fields.type') }}:</span>
                        <span class="ml-2 px-3 py-1 rounded-full text-sm font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200">
                            {{ __('gigs.types.' . $gig->type) }}
                        </span>
                    </div>
                </div>

                <!-- Applications Stats -->
                <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-neutral-700 dark:text-neutral-300">
                            {{ __('gigs.applications.total_applications') }}:
                        </span>
                        <span class="font-semibold text-neutral-900 dark:text-white">
                            {{ $gig->application_count }}
                        </span>
                    </div>

                    @if($gig->max_applications)
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-neutral-700 dark:text-neutral-300">
                                {{ __('gigs.fields.max_applications') }}:
                            </span>
                            <span class="font-semibold text-neutral-900 dark:text-white">
                                {{ $gig->max_applications }}
                            </span>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Actions -->
            <div class="p-8 bg-neutral-50 dark:bg-neutral-900/50 border-t border-neutral-200 dark:border-neutral-700">
                
                @if($userApplication)
                    <!-- Already Applied -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-1">
                                    {{ __('gigs.applications.already_applied') }}
                                </h3>
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    {{ __('gigs.applications.status') }}: 
                                    <span class="font-semibold">{{ __('gigs.applications.status_' . $userApplication->status) }}</span>
                                </p>
                                <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                    {{ __('gigs.applications.applied_at') }}: {{ $userApplication->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                @elseif($isOwner)
                    <!-- Owner Actions -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('gigs.edit', $gig) }}" 
                           class="px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                            {{ __('gigs.edit') }}
                        </a>

                        <a href="{{ route('gigs.applications', $gig) }}" 
                           class="px-6 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors">
                            {{ __('gigs.applications.manage_applications') }} ({{ $gig->application_count }})
                        </a>

                        @if($gig->is_closed)
                            <button wire:click="reopenGig" 
                                    class="px-6 py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold transition-colors">
                                {{ __('gigs.actions.reopen_gig') }}
                            </button>
                        @else
                            <button wire:click="closeGig" 
                                    class="px-6 py-3 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-semibold transition-colors">
                                {{ __('gigs.actions.close_gig') }}
                            </button>
                        @endif
                    </div>

                @elseif($canApply && !$showApplicationForm)
                    <!-- Apply Button -->
                    <button wire:click="toggleApplicationForm" 
                            class="w-full md:w-auto px-8 py-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold text-lg transition-colors">
                        {{ __('gigs.applications.apply') }}
                    </button>

                @elseif(!$canApply && !auth()->check())
                    <!-- Login Required -->
                    <a href="{{ route('login') }}" 
                       class="block w-full md:w-auto text-center px-8 py-4 rounded-xl bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white font-semibold text-lg">
                        {{ __('gigs.messages.login_to_interact') }}
                    </a>

                @elseif(!$canApply)
                    <!-- Cannot Apply -->
                    <div class="bg-neutral-100 dark:bg-neutral-800 rounded-xl p-4 text-center text-neutral-600 dark:text-neutral-400">
                        {{ __('gigs.applications.cannot_apply') }}
                    </div>
                @endif

                <!-- Application Form -->
                @if($showApplicationForm)
                    <div class="mt-6 p-6 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-6">
                            {{ __('gigs.applications.submit_application') }}
                        </h3>

                        <form wire:submit.prevent="submitApplication" class="space-y-4">
                            
                            <!-- Message (Required) -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.message') }} *
                                </label>
                                <textarea wire:model="applicationMessage" 
                                          rows="4" 
                                          class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                          placeholder="{{ __('gigs.applications.message_placeholder') }}"></textarea>
                                @error('applicationMessage') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Experience -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.experience') }}
                                </label>
                                <textarea wire:model="applicationExperience" 
                                          rows="3" 
                                          class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                          placeholder="{{ __('gigs.applications.experience_placeholder') }}"></textarea>
                                @error('applicationExperience') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Portfolio URL -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.portfolio_url') }}
                                </label>
                                <input type="url" 
                                       wire:model="applicationPortfolioUrl" 
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                       placeholder="https://...">
                                @error('applicationPortfolioUrl') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Availability -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.availability') }}
                                </label>
                                <textarea wire:model="applicationAvailability" 
                                          rows="2" 
                                          class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                          placeholder="{{ __('gigs.applications.availability_placeholder') }}"></textarea>
                                @error('applicationAvailability') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Compensation Expectation -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.compensation_expectation') }}
                                </label>
                                <input type="text" 
                                       wire:model="applicationCompensationExpectation" 
                                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                       placeholder="{{ __('gigs.applications.compensation_expectation_placeholder') }}">
                                @error('applicationCompensationExpectation') 
                                    <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-3 pt-4">
                                <button type="submit" 
                                        class="flex-1 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                                    {{ __('gigs.applications.submit_application') }}
                                </button>

                                <button type="button" 
                                        wire:click="toggleApplicationForm" 
                                        class="px-6 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold transition-colors">
                                    {{ __('gigs.cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
