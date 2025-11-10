<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('gigs.applications.manage_applications') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ $gig->title }}
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">
                    {{ number_format($stats['total']) }}
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
        <div class="space-y-6">
            @forelse($applications as $application)
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        
                        <!-- User Info -->
                        <div class="flex items-start gap-4">
                            @if($application->user->profile_photo_path)
                                <img src="{{ asset('storage/' . $application->user->profile_photo_path) }}" 
                                     alt="{{ $application->user->name }}"
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-xl">
                                    {{ strtoupper(substr($application->user->name, 0, 2)) }}
                                </div>
                            @endif

                            <div>
                                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-1">
                                    {{ $application->user->name }}
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ __('gigs.applications.applied_at') }}: {{ $application->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Application Content -->
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
                                @endif
                            </div>

                            <!-- Message -->
                            <div class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl p-4 mb-3">
                                <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gigs.applications.message') }}:
                                </h4>
                                <p class="text-sm text-neutral-700 dark:text-neutral-300">
                                    {{ $application->message }}
                                </p>
                            </div>

                            <!-- Additional Info -->
                            @if($application->experience)
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('gigs.applications.experience') }}:</span>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">{{ $application->experience }}</p>
                                </div>
                            @endif

                            @if($application->portfolio_url)
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('gigs.applications.portfolio_url') }}:</span>
                                    <a href="{{ $application->portfolio_url }}" 
                                       target="_blank"
                                       class="text-sm text-primary-600 dark:text-primary-400 hover:underline ml-2">
                                        {{ $application->portfolio_url }}
                                    </a>
                                </div>
                            @endif

                            @if($application->availability)
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('gigs.applications.availability') }}:</span>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">{{ $application->availability }}</p>
                                </div>
                            @endif

                            @if($application->compensation_expectation)
                                <div class="mb-2">
                                    <span class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('gigs.applications.compensation_expectation') }}:</span>
                                    <span class="text-sm text-neutral-600 dark:text-neutral-400 ml-2">{{ $application->compensation_expectation }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        @if($application->status === 'pending')
                            <div class="flex flex-col gap-2 min-w-[180px]">
                                <button wire:click="acceptApplication({{ $application->id }})" 
                                        wire:confirm="{{ __('gigs.messages.confirm_accept') }}"
                                        class="px-4 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold transition-colors">
                                    ✓ {{ __('gigs.applications.accept') }}
                                </button>

                                <button wire:click="rejectApplication({{ $application->id }})" 
                                        wire:confirm="{{ __('gigs.messages.confirm_reject') }}"
                                        class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors">
                                    ✗ {{ __('gigs.applications.reject') }}
                                </button>
                            </div>
                        @endif

                    </div>
                </div>
            @empty
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-12 border border-white/20 dark:border-neutral-700/50 text-center">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                        {{ __('gigs.applications.no_applications') }}
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        {{ __('gigs.applications.no_applications_yet') }}
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $applications->links() }}
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('gigs.show', $gig) }}" 
               class="inline-flex items-center gap-2 text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('gigs.back_to_gig') }}
            </a>
        </div>

    </div>
</div>
