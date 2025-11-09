<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                {{ __('translations.my_gigs') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400 font-poem italic">
                {{ __('translations.manage_your_requests') }}
            </p>
        </div>
        
        <!-- Filters -->
        <div class="mb-8 flex gap-3 justify-center flex-wrap">
            <button wire:click="$set('filter', 'all')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'all' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('common.all') }}
            </button>
            <button wire:click="$set('filter', 'open')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'open' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('translations.status.open') }}
            </button>
            <button wire:click="$set('filter', 'in_progress')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'in_progress' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('translations.status.in_progress') }}
            </button>
            <button wire:click="$set('filter', 'completed')"
                    class="px-6 py-3 rounded-2xl font-medium transition-all duration-200
                           {{ $filter === 'completed' ? 'bg-primary-500 text-white shadow-lg' : 'bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700' }}">
                {{ __('translations.status.completed') }}
            </button>
        </div>
        
        <!-- Gigs List -->
        @if($gigs->count() > 0)
            <div class="space-y-6 mb-12">
                @foreach($gigs as $gig)
                    <article class="backdrop-blur-xl bg-white/85 dark:bg-neutral-800/85 
                                   rounded-3xl shadow-xl hover:shadow-2xl
                                   border border-white/50 dark:border-neutral-700/50
                                   p-6 md:p-8 cursor-pointer group
                                   hover:-translate-y-1 transition-all duration-300"
                            onclick="window.location='{{ route('translations.gig.show', $gig) }}'">
                        
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2 font-poem
                                           group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    "{{ $gig->poem->title ?: __('poems.untitled') }}"
                                </h3>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                                    {{ config('poems.languages')[$gig->target_language] ?? $gig->target_language }} • 
                                    {{ $gig->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <span class="px-4 py-2 rounded-full text-sm font-bold
                                         {{ $gig->status === 'open' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 
                                            ($gig->status === 'in_progress' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 
                                            ($gig->status === 'completed' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : 
                                            'bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300')) }}">
                                {{ __('translations.status.' . $gig->status) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div class="text-center p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.proposed_compensation') }}</p>
                                <p class="font-bold text-lg text-primary-600 dark:text-primary-400">€{{ number_format($gig->proposed_compensation, 2) }}</p>
                            </div>
                            <div class="text-center p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.applications_count_label') }}</p>
                                <p class="font-bold text-lg">{{ $gig->applications->count() }}</p>
                            </div>
                            @if($gig->deadline)
                                <div class="text-center p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                    <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.deadline') }}</p>
                                    <p class="font-medium">{{ $gig->deadline->format('d/m/Y') }}</p>
                                </div>
                            @endif
                            @if($gig->acceptedTranslator)
                                <div class="text-center p-3 rounded-xl bg-neutral-50 dark:bg-neutral-900">
                                    <p class="text-neutral-500 dark:text-neutral-400 mb-1">{{ __('translations.translator') }}</p>
                                    <p class="font-medium truncate">{{ $gig->acceptedTranslator->name }}</p>
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
            
            {{ $gigs->links() }}
        @else
            <div class="text-center py-20">
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4 font-poem">
                    {{ __('translations.no_gigs_created') }}
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400 font-poem italic">
                    {{ __('translations.create_first_request') }}
                </p>
            </div>
        @endif
    </div>
</div>
