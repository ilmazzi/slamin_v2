<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.moderation.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.moderation.description') }}</p>

    {{-- Statistiche --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.moderation.videos') }}</p>
            <p class="text-xl font-bold text-neutral-900 dark:text-white">{{ $this->moderationStats['videos']['pending'] }}</p>
            <p class="text-xs text-green-600 dark:text-green-400">{{ $this->moderationStats['videos']['approved'] }} {{ __('admin.moderation.approved') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.moderation.poems') }}</p>
            <p class="text-xl font-bold text-neutral-900 dark:text-white">{{ $this->moderationStats['poems']['pending'] }}</p>
            <p class="text-xs text-green-600 dark:text-green-400">{{ $this->moderationStats['poems']['approved'] }} {{ __('admin.moderation.approved') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.moderation.events') }}</p>
            <p class="text-xl font-bold text-neutral-900 dark:text-white">{{ $this->moderationStats['events']['pending'] }}</p>
            <p class="text-xs text-green-600 dark:text-green-400">{{ $this->moderationStats['events']['approved'] }} {{ __('admin.moderation.approved') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.moderation.photos') }}</p>
            <p class="text-xl font-bold text-neutral-900 dark:text-white">{{ $this->moderationStats['photos']['pending'] }}</p>
            <p class="text-xs text-green-600 dark:text-green-400">{{ $this->moderationStats['photos']['approved'] }} {{ __('admin.moderation.approved') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.moderation.articles') }}</p>
            <p class="text-xl font-bold text-neutral-900 dark:text-white">{{ $this->moderationStats['articles']['pending'] }}</p>
            <p class="text-xs text-green-600 dark:text-green-400">{{ $this->moderationStats['articles']['approved'] }} {{ __('admin.moderation.approved') }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.moderation.reports') }}</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $this->moderationStats['reports']['pending'] }}</p>
            <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $this->moderationStats['reports']['investigating'] }} {{ __('admin.moderation.investigating') }}</p>
        </div>
    </div>

    {{-- Filtri --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow mb-6 p-4 border border-neutral-200 dark:border-neutral-700">
        <div class="flex items-center gap-4 flex-wrap">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('admin.moderation.type') }}</label>
                <select wire:model.live="type" 
                        class="px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">{{ __('admin.moderation.all_types') }}</option>
                    <option value="videos">{{ __('admin.moderation.videos') }}</option>
                    <option value="poems">{{ __('admin.moderation.poems') }}</option>
                    <option value="events">{{ __('admin.moderation.events') }}</option>
                    <option value="photos">{{ __('admin.moderation.photos') }}</option>
                    <option value="articles">{{ __('admin.moderation.articles') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('admin.moderation.status') }}</label>
                <select wire:model.live="status" 
                        class="px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="pending">{{ __('admin.moderation.pending') }}</option>
                    <option value="approved">{{ __('admin.moderation.approved') }}</option>
                    <option value="rejected">{{ __('admin.moderation.rejected') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">{{ __('admin.moderation.sort') }}</label>
                <select wire:model.live="sort" 
                        class="px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="newest">{{ __('admin.moderation.newest') }}</option>
                    <option value="oldest">{{ __('admin.moderation.oldest') }}</option>
                    <option value="oldest_pending">{{ __('admin.moderation.oldest_pending') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Tab Report --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">{{ __('admin.moderation.active_reports') }}</h2>
            </div>
            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @forelse($this->activeReports as $report)
                    <div class="p-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        {{ __('admin.moderation.pending') }}
                                    </span>
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ ucfirst($report->reportable_type ?? 'N/A') }}
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white mb-1">
                                    {{ $report->content_title ?? __('admin.moderation.content_not_found') }}
                                </p>
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-2">
                                    {{ __('admin.moderation.reported_by') }}: {{ $report->user->name ?? 'N/A' }}
                                </p>
                                @if($report->reason)
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mb-1">
                                        <strong>{{ __('admin.moderation.reason') }}:</strong> {{ ucfirst($report->reason) }}
                                    </p>
                                @endif
                                @if($report->description)
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400">
                                        {{ $report->description }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 ml-4">
                                <button wire:click="openReportModal({{ $report->id }}, 'investigate')" 
                                        class="px-3 py-1.5 text-sm bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                    {{ __('admin.moderation.investigate') }}
                                </button>
                                <button wire:click="openReportModal({{ $report->id }}, 'resolve')" 
                                        class="px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    {{ __('admin.moderation.resolve') }}
                                </button>
                                <button wire:click="openReportModal({{ $report->id }}, 'dismiss')" 
                                        class="px-3 py-1.5 text-sm bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    {{ __('admin.moderation.dismiss') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <p class="text-neutral-500 dark:text-neutral-400">{{ __('admin.moderation.no_reports') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Lista Contenuti --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
            <h2 class="text-xl font-semibold text-neutral-900 dark:text-white">{{ __('admin.moderation.content_list') }}</h2>
        </div>
        <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
            @forelse($this->contents as $content)
                <div class="p-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if(($content->moderation_status ?? $content->status ?? 'pending') === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @elseif(($content->moderation_status ?? $content->status ?? 'pending') === 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @endif">
                                    @if(isset($content->type))
                                        {{ ucfirst($content->type) }}
                                    @else
                                        {{ ucfirst($this->type) }}
                                    @endif
                                    - {{ ucfirst($content->moderation_status ?? $content->status ?? 'pending') }}
                                </span>
                            </div>
                            <p class="text-lg font-medium text-neutral-900 dark:text-white mb-1">
                                {{ $content->title ?? $content->name ?? substr($content->content ?? '', 0, 100) ?? __('admin.moderation.untitled') }}
                            </p>
                            @if(isset($content->user))
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">
                                    {{ __('admin.moderation.created_by') }}: {{ $content->user->name ?? 'N/A' }}
                                </p>
                            @elseif(isset($content->organizer))
                                <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-1">
                                    {{ __('admin.moderation.organized_by') }}: {{ $content->organizer->name ?? 'N/A' }}
                                </p>
                            @endif
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                {{ __('admin.moderation.created_at') }}: {{ $content->created_at ? (\Carbon\Carbon::parse($content->created_at)->format('d/m/Y H:i')) : 'N/A' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            @if(($content->moderation_status ?? $content->status ?? 'pending') === 'pending')
                                <button wire:click="openNoteModal('{{ $content->type ?? $this->type }}', {{ $content->id }})" 
                                        class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    {{ __('admin.moderation.approve') }}
                                </button>
                                <button wire:click="openNoteModal('{{ $content->type ?? $this->type }}', {{ $content->id }})" 
                                        class="px-4 py-2 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    {{ __('admin.moderation.reject') }}
                                </button>
                            @else
                                <button wire:click="openNoteModal('{{ $content->type ?? $this->type }}', {{ $content->id }})" 
                                        class="px-3 py-1.5 text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors">
                                    {{ __('admin.moderation.view') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <p class="text-neutral-500 dark:text-neutral-400">{{ __('admin.moderation.no_content_found') }}</p>
                </div>
            @endforelse
        </div>
        @if($this->type !== 'all' && $this->contents->hasPages())
            <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
                {{ $this->contents->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Note Moderazione --}}
    @if($showNoteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
             wire:click="closeNoteModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-lg w-full"
                 wire:click.stop>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('admin.moderation.moderation_notes') }}</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.moderation.notes') }}
                        </label>
                        <textarea wire:model="moderationNotes"
                                  rows="4"
                                  class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                  placeholder="{{ __('admin.moderation.notes_placeholder') }}"></textarea>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" 
                                wire:click="closeNoteModal"
                                class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                            {{ __('admin.moderation.cancel') }}
                        </button>
                        <button wire:click="approveContent('{{ $selectedContentType }}', {{ $selectedContentId }})" 
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            {{ __('admin.moderation.approve') }}
                        </button>
                        <button wire:click="rejectContent('{{ $selectedContentType }}', {{ $selectedContentId }})" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            {{ __('admin.moderation.reject') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Report --}}
    @if($showReportModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
             wire:click="closeReportModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-lg w-full"
                 wire:click.stop>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        @if($reportAction === 'investigate')
                            {{ __('admin.moderation.investigate_report') }}
                        @elseif($reportAction === 'resolve')
                            {{ __('admin.moderation.resolve_report') }}
                        @else
                            {{ __('admin.moderation.dismiss_report') }}
                        @endif
                    </h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.moderation.resolution_notes') }}
                        </label>
                        <textarea wire:model="reportNotes"
                                  rows="4"
                                  class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                  placeholder="{{ __('admin.moderation.notes_placeholder') }}"></textarea>
                    </div>
                    
                    <div class="flex items-center justify-end gap-3">
                        <button type="button" 
                                wire:click="closeReportModal"
                                class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                            {{ __('admin.moderation.cancel') }}
                        </button>
                        <button wire:click="handleReport({{ $selectedReportId }}, '{{ $reportAction }}')" 
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            {{ __('admin.moderation.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Messaggi flash --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
