<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('forum.reports') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('forum.reports_description') }}
                </p>
            </div>

            {{-- Filters --}}
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 mb-6 flex flex-wrap gap-4">
                <div class="flex gap-2">
                    <button wire:click="$set('filterStatus', 'all')" 
                            class="px-4 py-2 rounded-lg font-semibold {{ $filterStatus === 'all' ? 'bg-orange-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.all') }}
                    </button>
                    <button wire:click="$set('filterStatus', 'pending')" 
                            class="px-4 py-2 rounded-lg font-semibold {{ $filterStatus === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.pending') }}
                    </button>
                    <button wire:click="$set('filterStatus', 'resolved')" 
                            class="px-4 py-2 rounded-lg font-semibold {{ $filterStatus === 'resolved' ? 'bg-orange-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.resolved') }}
                    </button>
                </div>

                <div class="flex gap-2">
                    <button wire:click="$set('filterType', 'all')" 
                            class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'all' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.all_types') }}
                    </button>
                    <button wire:click="$set('filterType', 'post')" 
                            class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'post' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.posts') }}
                    </button>
                    <button wire:click="$set('filterType', 'comment')" 
                            class="px-4 py-2 rounded-lg font-semibold {{ $filterType === 'comment' ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300' }}">
                        {{ __('forum.comments') }}
                    </button>
                </div>
            </div>

            {{-- Reports List --}}
            <div class="space-y-4">
                @forelse($reports as $report)
                    <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 border-l-4 {{ $report->status === 'pending' ? 'border-yellow-500' : 'border-green-500' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-3 py-1 {{ $report->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' }} text-xs font-semibold rounded-full">
                                        {{ __('forum.' . $report->status) }}
                                    </span>
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-full">
                                        {{ __('forum.' . $report->reportable_type) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Reported by <a href="{{ route('profile.show', $report->reporter) }}" class="text-orange-500 hover:underline">u/{{ $report->reporter->name }}</a>
                                    • {{ $report->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        {{-- Report Reason --}}
                        <div class="mb-4 p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('forum.reason') }}:</p>
                            <p class="text-gray-900 dark:text-white">{{ $report->reason }}</p>
                        </div>

                        {{-- Reported Content --}}
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-lg">
                            @if($report->reportable_type === 'post')
                                <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $report->reportable->title }}</h3>
                                @if($report->reportable->content)
                                    <p class="text-gray-700 dark:text-gray-300 line-clamp-3">{{ $report->reportable->content }}</p>
                                @endif
                                <div class="mt-2 text-sm text-gray-500">
                                    by u/{{ $report->reportable->user->name }} in r/{{ $report->reportable->subreddit->name }}
                                </div>
                            @else
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $report->reportable->content }}</p>
                                <div class="mt-2 text-sm text-gray-500">
                                    Comment by u/{{ $report->reportable->user->name }}
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        @if($report->status === 'pending')
                            <div class="flex gap-2">
                                <button wire:click="removeContent({{ $report->id }})" 
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('forum.remove_content') }}
                                </button>
                                <button wire:click="dismissReport({{ $report->id }})" 
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-all">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ __('forum.dismiss_report') }}
                                </button>
                                @if($report->reportable_type === 'post')
                                    <a href="{{ route('forum.post.show', [$report->reportable->subreddit, $report->reportable]) }}" 
                                       wire:navigate
                                       class="px-4 py-2 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-all">
                                        {{ __('forum.view_post') }}
                                    </a>
                                @else
                                    <a href="{{ route('forum.post.show', [$report->reportable->post->subreddit, $report->reportable->post]) }}" 
                                       wire:navigate
                                       class="px-4 py-2 bg-gray-100 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-neutral-700 transition-all">
                                        {{ __('forum.view_context') }}
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="text-sm text-gray-500">
                                {{ __('forum.resolved_by') }} u/{{ $report->handledBy->name }} • {{ $report->resolved_at->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-white dark:bg-neutral-900 rounded-xl p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 text-lg">{{ __('forum.no_reports') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>

