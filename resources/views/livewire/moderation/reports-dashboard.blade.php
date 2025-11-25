<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2">
                🛡️ {{ __('report.moderation_title') }}
            </h1>
            <p class="text-neutral-600 dark:text-neutral-400">
                {{ __('report.moderation_subtitle') }}
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-4 shadow-sm border border-neutral-200 dark:border-neutral-800">
                <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $stats['total'] }}</div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('report.all_reports') }}</div>
            </div>
            
            <!-- Pending -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 shadow-sm border border-yellow-200 dark:border-yellow-800">
                <div class="text-2xl font-bold text-yellow-900 dark:text-yellow-300">{{ $stats['pending'] }}</div>
                <div class="text-sm text-yellow-700 dark:text-yellow-400">{{ __('report.pending_reports') }}</div>
            </div>
            
            <!-- Investigating -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 shadow-sm border border-blue-200 dark:border-blue-800">
                <div class="text-2xl font-bold text-blue-900 dark:text-blue-300">{{ $stats['investigating'] }}</div>
                <div class="text-sm text-blue-700 dark:text-blue-400">{{ __('report.active_reports') }}</div>
            </div>
            
            <!-- Resolved -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 shadow-sm border border-green-200 dark:border-green-800">
                <div class="text-2xl font-bold text-green-900 dark:text-green-300">{{ $stats['resolved'] }}</div>
                <div class="text-sm text-green-700 dark:text-green-400">{{ __('report.resolved_reports') }}</div>
            </div>
            
            <!-- Dismissed -->
            <div class="bg-neutral-100 dark:bg-neutral-800 rounded-xl p-4 shadow-sm border border-neutral-300 dark:border-neutral-700">
                <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-300">{{ $stats['dismissed'] }}</div>
                <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('report.dismissed_reports') }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-800 p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('common.search') }}
                    </label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="searchTerm"
                           placeholder="{{ __('report.search_placeholder') }}"
                           class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('report.filter_by_status') }}
                    </label>
                    <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        <option value="all">{{ __('report.all_statuses') }}</option>
                        <option value="{{ \App\Models\Report::STATUS_PENDING }}">{{ __('report.status_pending') }}</option>
                        <option value="{{ \App\Models\Report::STATUS_INVESTIGATING }}">{{ __('report.status_investigating') }}</option>
                        <option value="{{ \App\Models\Report::STATUS_RESOLVED }}">{{ __('report.status_resolved') }}</option>
                        <option value="{{ \App\Models\Report::STATUS_DISMISSED }}">{{ __('report.status_dismissed') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="space-y-4">
            @forelse($reports as $report)
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <!-- Reporter Info -->
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <img src="{{ $report->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($report->user->name) }}" 
                                 alt="{{ $report->user->name }}"
                                 class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <div class="font-medium text-neutral-900 dark:text-white">
                                    {{ $report->user->name }}
                                </div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ $report->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <!-- Report Details -->
                        <div class="flex-1 min-w-0">
                            <!-- Status Badge -->
                            <div class="flex items-center gap-2 mb-2">
                                @php
                                $statusColors = [
                                    \App\Models\Report::STATUS_PENDING => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    \App\Models\Report::STATUS_INVESTIGATING => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                    \App\Models\Report::STATUS_RESOLVED => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    \App\Models\Report::STATUS_DISMISSED => 'bg-neutral-100 text-neutral-800 dark:bg-neutral-800 dark:text-neutral-300',
                                ];
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$report->status] ?? '' }}">
                                    {{ __('report.status_' . $report->status) }}
                                </span>
                                
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    {{ __('report.reasons.' . $report->reason) }}
                                </span>
                                
                                <span class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ class_basename($report->reportable_type) }} #{{ $report->reportable_id }}
                                </span>
                            </div>

                            <!-- Description -->
                            @if($report->description)
                            <p class="text-sm text-neutral-700 dark:text-neutral-300 mb-3">
                                {{ $report->description }}
                            </p>
                            @endif

                            <!-- Content Preview -->
                            @if($report->reportable)
                            <div class="mt-3 p-3 bg-neutral-50 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
                                <div class="text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1">
                                    {{ __('report.reported_content') }}:
                                </div>
                                <div class="text-sm text-neutral-900 dark:text-white line-clamp-2">
                                    @if(method_exists($report->reportable, 'getContentPreviewAttribute'))
                                        {{ $report->reportable->content_preview }}
                                    @elseif(isset($report->reportable->title))
                                        <strong>{{ $report->reportable->title }}</strong>
                                    @elseif(isset($report->reportable->content))
                                        {{ \Str::limit($report->reportable->content, 100) }}
                                    @elseif(isset($report->reportable->body))
                                        {{ \Str::limit($report->reportable->body, 100) }}
                                    @else
                                        {{ class_basename($report->reportable_type) }} #{{ $report->reportable_id }}
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="mt-3 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                <div class="text-xs text-red-700 dark:text-red-300">
                                    ⚠️ {{ __('report.content_deleted_or_unavailable') }}
                                </div>
                            </div>
                            @endif

                            <!-- Resolution Notes -->
                            @if($report->resolution_notes && in_array($report->status, [\App\Models\Report::STATUS_RESOLVED, \App\Models\Report::STATUS_DISMISSED]))
                            <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="text-xs font-semibold text-blue-700 dark:text-blue-300 mb-1">
                                    {{ __('report.resolution_notes') }}:
                                </div>
                                <div class="text-sm text-blue-900 dark:text-blue-200">
                                    {{ $report->resolution_notes }}
                                </div>
                                @if($report->resolver)
                                <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                    — {{ $report->resolver->name }}, {{ $report->resolved_at->diffForHumans() }}
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        @if(in_array($report->status, [\App\Models\Report::STATUS_PENDING, \App\Models\Report::STATUS_INVESTIGATING]))
                        <div class="flex flex-col gap-2 flex-shrink-0">
                            @if($report->status === \App\Models\Report::STATUS_PENDING)
                            <button wire:click="markInvestigating({{ $report->id }})"
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                🔍 {{ __('report.mark_investigating') }}
                            </button>
                            @endif
                            
                            <button wire:click="openResolveModal({{ $report->id }})"
                                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                ✅ {{ __('report.mark_resolved') }}
                            </button>
                            
                            <button wire:click="dismissReport({{ $report->id }})"
                                    wire:confirm="{{ __('report.confirm_dismiss') }}"
                                    class="px-4 py-2 bg-neutral-600 text-white text-sm font-medium rounded-lg hover:bg-neutral-700 transition-colors">
                                ❌ {{ __('report.mark_dismissed') }}
                            </button>
                            
                            @if($report->reportable)
                            <button wire:click="deleteContent({{ $report->id }})"
                                    wire:confirm="{{ __('report.confirm_delete_content') }}"
                                    class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                🗑️ {{ __('report.delete_content') }}
                            </button>
                            @endif
                            
                            @if($report->reportable)
                                @php
                                    $contentType = class_basename($report->reportable_type);
                                @endphp
                                
                                @if($contentType === 'Event')
                                    {{-- Eventi: link diretto alla pagina --}}
                                    <a href="{{ route('events.show', $report->reportable_id) }}" 
                                       target="_blank"
                                       class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors inline-flex items-center gap-2">
                                        👁️ {{ __('report.view_content') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                @else
                                    {{-- Altri contenuti: modal preview --}}
                                    <button wire:click="viewContent({{ $report->id }})"
                                            class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                        👁️ {{ __('report.view_content') }}
                                    </button>
                                @endif
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-800 p-12 text-center">
                <div class="text-6xl mb-4">🎉</div>
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                    {{ __('report.no_reports') }}
                </h3>
                <p class="text-neutral-600 dark:text-neutral-400">
                    {{ __('report.no_reports_message') }}
                </p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- Resolve Modal -->
    @if($showResolveModal && $selectedReport)
    <div class="fixed inset-0 z-[9999] overflow-y-auto" 
         x-data="{ show: @entangle('showResolveModal') }"
         x-show="show"
         x-cloak
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
             @click="$wire.closeResolveModal()">
        </div>

        <!-- Modal -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-lg w-full p-6"
                 @click.stop>
                
                <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                    {{ __('report.resolve_report') }}
                </h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('report.resolution_notes') }}
                        <span class="text-neutral-500 font-normal">({{ __('common.optional') }})</span>
                    </label>
                    <textarea wire:model="resolutionNotes"
                              rows="3"
                              placeholder="{{ __('report.resolution_notes_placeholder') }}"
                              class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all"></textarea>
                </div>

                <div class="flex gap-3">
                    <button @click="$wire.closeResolveModal()"
                            class="flex-1 px-6 py-3 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-semibold rounded-xl hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                        {{ __('common.cancel') }}
                    </button>
                    <button wire:click="resolveReport"
                            class="flex-1 px-6 py-3 bg-gradient-to-br from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                        {{ __('report.resolve') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Content Preview Modal -->
    @if($showContentModal && $selectedContent)
    <div class="fixed inset-0 z-[9999] overflow-y-auto" 
         x-data="{ show: @entangle('showContentModal') }"
         x-show="show"
         x-cloak
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity"
             @click="$wire.closeContentModal()">
        </div>

        <!-- Modal -->
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                 @click.stop>
                
                <!-- Header -->
                <div class="sticky top-0 bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-800 px-6 py-4 flex items-center justify-between z-10">
                    <div>
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white">
                            {{ __('report.reported_content') }}
                        </h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                            {{ ucfirst($selectedContent['type']) }} #{{ $selectedContent['report']->reportable_id }}
                        </p>
                    </div>
                    <button @click="$wire.closeContentModal()"
                            class="p-2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6">
                    @php
                        $content = $selectedContent['data'];
                        $type = $selectedContent['type'];
                    @endphp

                    @if($type === 'Poem')
                        <!-- Poem Content -->
                        <div class="prose dark:prose-invert max-w-none">
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">{{ $content->title }}</h2>
                            <div class="bg-neutral-50 dark:bg-neutral-800 rounded-lg p-6 whitespace-pre-wrap">
                                {{ $content->content }}
                            </div>
                            @if($content->tags && count($content->tags) > 0)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($content->tags as $tag)
                                <span class="px-3 py-1 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-sm rounded-full">
                                    #{{ $tag }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>

                    @elseif($type === 'Article')
                        <!-- Article Content -->
                        <div class="prose dark:prose-invert max-w-none">
                            @php
                                $locale = app()->getLocale();
                                $title = is_array($content->title) ? ($content->title[$locale] ?? $content->title['it'] ?? '') : $content->title;
                                $body = is_array($content->body) ? ($content->body[$locale] ?? $content->body['it'] ?? '') : $content->body;
                            @endphp
                            
                            @if($content->featured_image_url)
                            <img src="{{ $content->featured_image_url }}" 
                                 alt="{{ $title }}"
                                 class="w-full h-64 object-cover rounded-lg mb-6">
                            @endif
                            
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">{{ $title }}</h2>
                            <div class="text-neutral-700 dark:text-neutral-300">
                                {!! nl2br(e($body)) !!}
                            </div>
                        </div>

                    @elseif($type === 'Event')
                        <!-- Event Content -->
                        <div>
                            @if($content->image_url)
                            <img src="{{ $content->image_url }}" 
                                 alt="{{ $content->title }}"
                                 class="w-full h-64 object-cover rounded-lg mb-6">
                            @endif
                            
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">{{ $content->title }}</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($content->start_datetime)->format('d/m/Y H:i') }}
                                </div>
                                
                                @if($content->venue_name || $content->city)
                                <div class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $content->venue_name ?? '' }}{{ $content->city ? ', ' . $content->city : '' }}
                                </div>
                                @endif
                            </div>
                            
                            @if($content->description)
                            <div class="prose dark:prose-invert max-w-none text-neutral-700 dark:text-neutral-300">
                                {!! nl2br(e($content->description)) !!}
                            </div>
                            @endif
                        </div>

                    @elseif($type === 'Video')
                        <!-- Video Content -->
                        <div>
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">{{ $content->title }}</h2>
                            
                            @if($content->thumbnail_url)
                            <img src="{{ $content->thumbnail_url }}" 
                                 alt="{{ $content->title }}"
                                 class="w-full h-64 object-cover rounded-lg mb-4">
                            @endif
                            
                            @if($content->description)
                            <p class="text-neutral-700 dark:text-neutral-300 mb-4">{{ $content->description }}</p>
                            @endif
                            
                            <div class="flex items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span>👁️ {{ number_format($content->view_count ?? 0) }} {{ __('common.views') }}</span>
                                <span>❤️ {{ number_format($content->like_count ?? 0) }} {{ __('common.likes') }}</span>
                            </div>
                        </div>

                    @elseif($type === 'Photo')
                        <!-- Photo Content -->
                        <div>
                            @if($content->title)
                            <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">{{ $content->title }}</h2>
                            @endif
                            
                            <img src="{{ $content->url ?? $content->image_url }}" 
                                 alt="{{ $content->title ?? 'Photo' }}"
                                 class="w-full rounded-lg mb-4">
                            
                            @if($content->description)
                            <p class="text-neutral-700 dark:text-neutral-300 mb-4">{{ $content->description }}</p>
                            @endif
                            
                            <div class="flex items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span>❤️ {{ number_format($content->like_count ?? 0) }} {{ __('common.likes') }}</span>
                            </div>
                        </div>

                    @else
                        <!-- Fallback -->
                        <div class="text-center py-12">
                            <p class="text-neutral-600 dark:text-neutral-400">
                                {{ __('report.content_type_not_supported') }}
                            </p>
                        </div>
                    @endif

                    <!-- Report Info -->
                    <div class="mt-8 pt-6 border-t border-neutral-200 dark:border-neutral-800">
                        <h4 class="font-semibold text-neutral-900 dark:text-white mb-3">
                            {{ __('report.report_details') }}
                        </h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('report.reason') }}:</span>
                                <span class="font-medium text-neutral-900 dark:text-white">
                                    {{ __('report.reasons.' . $selectedContent['report']->reason) }}
                                </span>
                            </div>
                            @if($selectedContent['report']->description)
                            <div class="mt-3">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('report.description') }}:</span>
                                <p class="mt-1 text-neutral-900 dark:text-white">{{ $selectedContent['report']->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Footer with Actions -->
                <div class="sticky bottom-0 bg-white dark:bg-neutral-900 border-t border-neutral-200 dark:border-neutral-800 px-6 py-4 flex justify-end gap-3">
                    <button @click="$wire.closeContentModal()"
                            class="px-6 py-2 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-medium rounded-lg hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                        {{ __('common.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

