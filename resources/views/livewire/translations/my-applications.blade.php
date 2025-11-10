<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('gigs.applications.my_applications') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ __('gigs.applications.my_applications_description') }}
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">
                    {{ number_format($stats['total_applications']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.applications.total_applications') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">
                    {{ number_format($stats['pending']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.applications.status_pending') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
                    {{ number_format($stats['accepted']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.applications.status_accepted') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-red-600 dark:text-red-400 mb-2">
                    {{ number_format($stats['rejected']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.applications.status_rejected') }}
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50 mb-8">
            <div class="flex flex-wrap items-center gap-4">
                <button wire:click="$set('status_filter', 'all')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'all' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.filters.all') }}
                </button>

                <button wire:click="$set('status_filter', 'pending')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'pending' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.applications.status_pending') }}
                </button>

                <button wire:click="$set('status_filter', 'accepted')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'accepted' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.applications.status_accepted') }}
                </button>

                <button wire:click="$set('status_filter', 'rejected')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'rejected' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.applications.status_rejected') }}
                </button>
            </div>
        </div>

        <!-- Applications List -->
        <div class="space-y-4">
            @forelse($applications as $application)
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <!-- Status Badge -->
                            <div class="mb-3">
                                @if($application->status === 'pending')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                        {{ __('gigs.applications.status_pending') }}
                                    </span>
                                @elseif($application->status === 'accepted')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        ✓ {{ __('gigs.applications.status_accepted') }}
                                    </span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        ✗ {{ __('gigs.applications.status_rejected') }}
                                    </span>
                                @elseif($application->status === 'withdrawn')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200">
                                        {{ __('gigs.applications.status_withdrawn') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Gig Title -->
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                {{ $application->gig->title }}
                            </h3>

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400 mb-3">
                                <span>{{ __('gigs.categories.' . $application->gig->category) }}</span>
                                <span>•</span>
                                <span>{{ __('gigs.applications.applied_at') }}: {{ $application->created_at->format('d M Y') }}</span>
                                
                                @if($application->gig->user)
                                    <span>•</span>
                                    <span>{{ __('gigs.organizer') }}: {{ $application->gig->user->name }}</span>
                                @elseif($application->gig->requester)
                                    <span>•</span>
                                    <span>{{ __('gigs.organizer') }}: {{ $application->gig->requester->name }}</span>
                                @endif
                            </div>

                            <!-- Message Preview -->
                            <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4">
                                <p class="text-sm text-neutral-700 dark:text-neutral-300 line-clamp-3">
                                    {{ $application->message }}
                                </p>
                            </div>

                            <!-- Additional Info -->
                            @if($application->compensation_expectation)
                                <div class="mt-3 text-sm text-neutral-600 dark:text-neutral-400">
                                    <span class="font-semibold">{{ __('gigs.applications.compensation_expectation') }}:</span>
                                    {{ $application->compensation_expectation }}
                                </div>
                            @endif

                            @if($application->status === 'rejected' && $application->rejection_reason)
                                <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg text-sm text-red-800 dark:text-red-200">
                                    <span class="font-semibold">{{ __('gigs.applications.rejection_reason') }}:</span>
                                    {{ $application->rejection_reason }}
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col gap-2 min-w-[180px]">
                            <a href="{{ route('gigs.show', $application->gig) }}" 
                               class="px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white text-center font-medium transition-colors">
                                {{ __('gigs.view_gig') }}
                            </a>

                            @if($application->status === 'pending')
                                <button wire:click="withdrawApplication({{ $application->id }})" 
                                        wire:confirm="{{ __('gigs.applications.confirm_withdraw') }}"
                                        class="px-4 py-2 rounded-xl bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-900 dark:text-red-100 font-medium transition-colors">
                                    {{ __('gigs.applications.withdraw') }}
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-12 border border-white/20 dark:border-neutral-700/50 text-center">
                    <div class="text-6xl mb-4">📋</div>
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                        {{ __('gigs.applications.no_applications') }}
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6">
                        {{ __('gigs.applications.no_applications_description') }}
                    </p>
                    <a href="{{ route('gigs.index') }}" 
                       class="inline-block px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold transition-colors">
                        {{ __('gigs.browse_gigs') }}
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $applications->links() }}
        </div>

    </div>
</div>
