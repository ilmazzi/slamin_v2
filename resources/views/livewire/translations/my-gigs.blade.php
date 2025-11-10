<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('gigs.my_gigs') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ __('gigs.my_gigs_description') }}
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400 mb-2">
                    {{ number_format($stats['total_gigs']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.total_gigs') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
                    {{ number_format($stats['open_gigs']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.open_gigs') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                    {{ number_format($stats['total_applications']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.total_applications') }}
                </div>
            </div>
            
            <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50">
                <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">
                    {{ number_format($stats['pending_applications']) }}
                </div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('gigs.stats.pending_applications') }}
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

                <button wire:click="$set('status_filter', 'open')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'open' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.filters.open') }}
                </button>

                <button wire:click="$set('status_filter', 'closed')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'closed' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.filters.closed') }}
                </button>

                <button wire:click="$set('status_filter', 'expired')" 
                        class="px-4 py-2 rounded-xl font-medium transition-colors {{ $status_filter === 'expired' ? 'bg-primary-600 text-white' : 'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-600' }}">
                    {{ __('gigs.filters.expired') }}
                </button>
            </div>
        </div>

        <!-- Gigs List -->
        <div class="space-y-4">
            @forelse($gigs as $gig)
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-6 border border-white/20 dark:border-neutral-700/50 hover:shadow-2xl transition-all duration-300">
                    <div class="flex flex-col md:flex-row md:items-center gap-6">
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <!-- Badges -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                @if($gig->is_featured)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        {{ __('gigs.status.featured') }}
                                    </span>
                                @endif
                                
                                @if($gig->is_urgent)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                        {{ __('gigs.status.urgent') }}
                                    </span>
                                @endif

                                @if($gig->is_closed)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        {{ __('gigs.status.closed') }}
                                    </span>
                                @elseif($gig->is_expired)
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200">
                                        {{ __('gigs.status.expired') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        {{ __('gigs.status.open') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                {{ $gig->title }}
                            </h3>

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span>{{ __('gigs.categories.' . $gig->category) }}</span>
                                <span>•</span>
                                <span>{{ $gig->application_count }} {{ __('gigs.applications.applications') }}</span>
                                
                                @if($gig->deadline)
                                    <span>•</span>
                                    <span>{{ $gig->deadline->format('d M Y') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('gigs.show', $gig) }}" 
                               class="px-4 py-2 rounded-xl bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-medium transition-colors">
                                {{ __('gigs.view') }}
                            </a>

                            <a href="{{ route('gigs.edit', $gig) }}" 
                               class="px-4 py-2 rounded-xl bg-primary-100 dark:bg-primary-900 hover:bg-primary-200 dark:hover:bg-primary-800 text-primary-900 dark:text-primary-100 font-medium transition-colors">
                                {{ __('gigs.edit') }}
                            </a>

                            <a href="{{ route('gigs.applications', $gig) }}" 
                               class="px-4 py-2 rounded-xl bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-900 dark:text-blue-100 font-medium transition-colors">
                                {{ __('gigs.applications.manage_applications') }} ({{ $gig->application_count }})
                            </a>

                            @if($gig->is_closed)
                                <button wire:click="reopenGig({{ $gig->id }})" 
                                        class="px-4 py-2 rounded-xl bg-green-100 dark:bg-green-900 hover:bg-green-200 dark:hover:bg-green-800 text-green-900 dark:text-green-100 font-medium transition-colors">
                                    {{ __('gigs.actions.reopen_gig') }}
                                </button>
                            @else
                                <button wire:click="closeGig({{ $gig->id }})" 
                                        class="px-4 py-2 rounded-xl bg-orange-100 dark:bg-orange-900 hover:bg-orange-200 dark:hover:bg-orange-800 text-orange-900 dark:text-orange-100 font-medium transition-colors">
                                    {{ __('gigs.actions.close_gig') }}
                                </button>
                            @endif

                            <button wire:click="deleteGig({{ $gig->id }})" 
                                    wire:confirm="{{ __('gigs.messages.confirm_delete') }}"
                                    class="px-4 py-2 rounded-xl bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-900 dark:text-red-100 font-medium transition-colors">
                                {{ __('gigs.delete') }}
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-2xl p-12 border border-white/20 dark:border-neutral-700/50 text-center">
                    <div class="text-6xl mb-4">📝</div>
                    <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                        {{ __('gigs.no_gigs_found') }}
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400">
                        {{ __('gigs.no_gigs_description') }}
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $gigs->links() }}
        </div>

    </div>
</div>
