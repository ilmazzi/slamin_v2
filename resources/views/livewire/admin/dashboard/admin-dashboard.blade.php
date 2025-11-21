<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.dashboard.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-8">{{ __('admin.dashboard.description') }}</p>
    
    {{-- Utenti Online --}}
    <div class="mb-6">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-lg">
            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-sm font-medium">{{ __('admin.dashboard.online_users') }}: {{ $this->onlineUsers }}</span>
        </div>
    </div>
    
    {{-- Statistiche Generali --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.dashboard.general_stats') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.total_users') }}</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->generalStats['total_users']) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.total_events') }}</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->generalStats['total_events']) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.total_videos') }}</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->generalStats['total_videos']) }}</p>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-6 border border-neutral-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.total_poems') }}</p>
                        <p class="text-3xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->generalStats['total_poems']) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Statistiche Utenti --}}
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.dashboard.user_stats') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.new_today') }}</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->userStats['new_today'] }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.new_this_week') }}</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->userStats['new_this_week'] }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.new_this_month') }}</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->userStats['new_this_month'] }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.active_users') }}</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->userStats['active_users'] }}</p>
            </div>
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.dashboard.active_gigs') }}</p>
                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->eventStats['active_gigs'] }}</p>
            </div>
        </div>
    </div>
    
    {{-- Attività Recente --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Utenti Recenti --}}
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700">
            <div class="p-4 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">{{ __('admin.dashboard.recent_users') }}</h3>
            </div>
            <div class="p-4">
                @forelse($this->recentActivity['recent_users'] as $user)
                    <div class="flex items-center justify-between py-2 border-b border-neutral-100 dark:border-neutral-700 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                                <span class="text-primary-600 dark:text-primary-400 font-medium">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 text-center py-4">{{ __('admin.dashboard.no_recent_users') }}</p>
                @endforelse
            </div>
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-700">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    {{ __('admin.dashboard.view_all_users') }} →
                </a>
            </div>
        </div>
        
        {{-- Eventi Recenti --}}
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700">
            <div class="p-4 border-b border-neutral-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">{{ __('admin.dashboard.recent_events') }}</h3>
            </div>
            <div class="p-4">
                @forelse($this->recentActivity['recent_events'] as $event)
                    <div class="flex items-center justify-between py-2 border-b border-neutral-100 dark:border-neutral-700 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white">{{ $event->title ?? 'N/A' }}</p>
                            @if($event->start_datetime)
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">{{ $event->start_datetime->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">{{ $event->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 text-center py-4">{{ __('admin.dashboard.no_recent_events') }}</p>
                @endforelse
            </div>
            <div class="p-4 border-t border-neutral-200 dark:border-neutral-700">
                <a href="{{ route('events.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                    {{ __('admin.dashboard.view_all_events') }} →
                </a>
            </div>
        </div>
    </div>
</div>
