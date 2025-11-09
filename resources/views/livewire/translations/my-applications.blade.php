<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                {{ __('translations.my_applications') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400 font-poem italic">
                {{ __('translations.track_your_applications') }}
            </p>
        </div>
        
        <!-- Filters -->
        <div class="mb-8 flex gap-3 justify-center flex-wrap">
            <button wire:click="$set('filter', 'all')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'all' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('common.all') }}
            </button>
            <button wire:click="$set('filter', 'pending')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'pending' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('translations.application_status.pending') }}
            </button>
            <button wire:click="$set('filter', 'accepted')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'accepted' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('translations.application_status.accepted') }}
            </button>
            <button wire:click="$set('filter', 'rejected')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'rejected' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('translations.application_status.rejected') }}
            </button>
        </div>
        
        <!-- Applications List -->
        @if($applications->count() > 0)
            <div class="space-y-6 mb-12">
                @foreach($applications as $application)
                    <article class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                   rounded-3xl shadow-xl hover:shadow-2xl
                                   border border-white/50 dark:border-neutral-700/50
                                   p-6 md:p-8 cursor-pointer group
                                   hover:-translate-y-1 transition-all duration-300"
                            onclick="window.location='{{ route('translations.gig.show', $application->gig) }}'">
                        
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2 font-poem
                                           group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    "{{ $application->gig->poem->title ?: __('poems.untitled') }}"
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ config('poems.languages')[$application->gig->target_language] ?? $application->gig->target_language }} • 
                                    {{ $application->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <span class="px-4 py-2 rounded-full text-sm font-bold
                                         {{ $application->status === 'accepted' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 
                                            ($application->status === 'rejected' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : 
                                            ($application->status === 'withdrawn' ? 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300' : 
                                            'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300')) }}">
                                {{ __('translations.application_status.' . $application->status) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div class="p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.your_compensation') }}</p>
                                <p class="font-bold text-primary-600 dark:text-primary-400">€{{ number_format($application->proposed_compensation, 2) }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.requested_compensation') }}</p>
                                <p class="font-medium">€{{ number_format($application->gig->proposed_compensation, 2) }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.delivery') }}</p>
                                <p class="font-medium">{{ $application->estimated_delivery->format('d/m/Y') }}</p>
                            </div>
                            <div class="p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.gig_status') }}</p>
                                <p class="font-medium">{{ __('translations.status.' . $application->gig->status) }}</p>
                            </div>
                        </div>
                        
                        @if($application->status === 'pending')
                            <div class="mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700" @click.stop>
                                <button wire:click="withdrawApplication({{ $application->id }})"
                                        wire:confirm="{{ __('translations.confirm_withdraw') }}"
                                        class="px-4 py-2 rounded-xl font-medium text-sm
                                               bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400
                                               hover:bg-red-100 dark:hover:bg-red-900/30
                                               border border-red-200 dark:border-red-800
                                               transition-all duration-200">
                                    {{ __('translations.withdraw_application') }}
                                </button>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
            
            {{ $applications->links() }}
        @else
            <div class="text-center py-20">
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                    {{ __('translations.no_applications') }}
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 font-poem italic mb-8">
                    {{ __('translations.browse_gigs_to_apply') }}
                </p>
                <a href="{{ route('translations.gigs.index') }}"
                   class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl
                          bg-gradient-to-r from-primary-500 to-primary-600
                          hover:from-primary-600 hover:to-primary-700
                          text-white font-semibold shadow-lg hover:shadow-xl
                          hover:-translate-y-1 transition-all duration-300">
                    {{ __('translations.browse_gigs') }}
                </a>
            </div>
        @endif
    </div>
</div>
