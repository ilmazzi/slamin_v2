<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 dark:text-white mb-2 flex items-center gap-3">
                        <span class="text-amber-500">🏆</span>
                        {{ __('badge.manage_display') }}
                    </h1>
                    <p class="text-neutral-600 dark:text-neutral-400 hidden md:block">
                        {{ __('badge.manage_display_desc') }}
                    </p>
                </div>
                <a href="{{ route('profile.show') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('common.back') }}</span>
                    <span class="sm:hidden">{{ __('profile.show') }}</span>
                </a>
            </div>
        </div>

        <!-- Current Display Settings -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Profile Badges -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('badge.profile_badges') }}
                        </h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('badge.profile_badges_desc') }}
                        </p>
                    </div>
                    <button wire:click="toggleProfileForm"
                            class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium transition">
                        {{ $showProfileForm ? __('common.cancel') : __('common.manage') }}
                    </button>
                </div>

                @if($profileBadges->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($profileBadges as $userBadge)
                        <div class="flex items-center gap-2 bg-primary-50 dark:bg-primary-900/20 px-3 py-2 rounded-lg border border-primary-200 dark:border-primary-700">
                            <img src="{{ $userBadge->badge->icon_url }}"
                                 alt="{{ $userBadge->badge->name }}"
                                 class="w-6 h-6 rounded-full">
                            <span class="text-sm font-medium text-primary-800 dark:text-primary-200">
                                {{ $userBadge->badge->name }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="text-4xl mb-2">👤</div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                            {{ __('badge.no_profile_badges') }}
                        </p>
                    </div>
                @endif

                {{-- Profile Badge Management Form --}}
                @if($showProfileForm)
                <div class="mt-4 border-t border-neutral-200 dark:border-neutral-700 pt-4">
                    <form wire:submit.prevent="updateProfileBadges">
                        <div class="space-y-3">
                            @if($badges->count() > 0)
                                <div class="max-h-60 overflow-y-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                    @foreach($badges as $userBadge)
                                    <label class="flex items-center p-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 cursor-pointer">
                                        <input type="checkbox"
                                               wire:model="selectedProfileBadges"
                                               value="{{ $userBadge->id }}"
                                               class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                                        <img src="{{ $userBadge->badge->icon_url }}"
                                             alt="{{ $userBadge->badge->name }}"
                                             class="w-8 h-8 rounded-full ml-3 mr-3">
                                        <div class="flex-1">
                                            <div class="font-medium text-neutral-900 dark:text-white">
                                                {{ $userBadge->badge->name }}
                                            </div>
                                            <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                                +{{ $userBadge->badge->points }} {{ __('badge.points') }} • {{ $userBadge->earned_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6 text-neutral-500 dark:text-neutral-400">
                                    {{ __('badge.no_badges_earned') }}
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-3 mt-4">
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-medium transition">
                                {{ __('common.save') }}
                            </button>
                            <button type="button"
                                    wire:click="hideAllProfileBadges"
                                    class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white rounded-lg font-medium transition">
                                {{ __('badge.hide_all') }}
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>

            <!-- Sidebar Badges -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            {{ __('badge.sidebar_badges') }}
                        </h3>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('badge.sidebar_badges_desc') }}
                        </p>
                    </div>
                    <button wire:click="toggleSidebarForm"
                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition">
                        {{ $showSidebarForm ? __('common.cancel') : __('common.manage') }}
                    </button>
                </div>

                @if($sidebarBadges->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($sidebarBadges as $userBadge)
                        <div class="flex items-center gap-2 bg-yellow-50 dark:bg-yellow-900/20 px-3 py-2 rounded-lg border border-yellow-200 dark:border-yellow-700">
                            <img src="{{ $userBadge->badge->icon_url }}"
                                 alt="{{ $userBadge->badge->name }}"
                                 class="w-6 h-6 rounded-full">
                            <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ $userBadge->badge->name }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="text-4xl mb-2">📊</div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                            {{ __('badge.no_sidebar_badges') }}
                        </p>
                    </div>
                @endif

                {{-- Sidebar Badge Management Form --}}
                @if($showSidebarForm)
                <div class="mt-4 border-t border-neutral-200 dark:border-neutral-700 pt-4">
                    <form wire:submit.prevent="updateSidebarBadges">
                        <div class="space-y-3">
                            @if($badges->count() > 0)
                                <div class="max-h-60 overflow-y-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                    @foreach($badges as $userBadge)
                                    <label class="flex items-center p-3 hover:bg-neutral-50 dark:hover:bg-neutral-700 cursor-pointer">
                                        <input type="checkbox"
                                               wire:model="selectedSidebarBadges"
                                               value="{{ $userBadge->id }}"
                                               class="rounded border-neutral-300 dark:border-neutral-600 text-yellow-600 focus:ring-yellow-500">
                                        <img src="{{ $userBadge->badge->icon_url }}"
                                             alt="{{ $userBadge->badge->name }}"
                                             class="w-8 h-8 rounded-full ml-3 mr-3">
                                        <div class="flex-1">
                                            <div class="font-medium text-neutral-900 dark:text-white">
                                                {{ $userBadge->badge->name }}
                                            </div>
                                            <div class="text-sm text-neutral-600 dark:text-neutral-400">
                                                +{{ $userBadge->badge->points }} {{ __('badge.points') }} • {{ $userBadge->earned_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6 text-neutral-500 dark:text-neutral-400">
                                    {{ __('badge.no_badges_earned') }}
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-3 mt-4">
                            <button type="submit"
                                    class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-medium transition">
                                {{ __('common.save') }}
                            </button>
                            <button type="button"
                                    wire:click="hideAllSidebarBadges"
                                    class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white rounded-lg font-medium transition">
                                {{ __('badge.hide_all') }}
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <!-- Complete Collection -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    {{ __('badge.complete_collection') }}
                </h2>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 mt-1">
                    {{ __('badge.complete_collection_desc') }}
                </p>
            </div>
            <div class="p-6">
                @if($badges && $badges->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @foreach($badges as $userBadge)
                            <div class="group relative bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl p-4 border-2 border-amber-200 dark:border-amber-700 hover:border-amber-400 dark:hover:border-amber-500 transition-all hover:scale-105 hover:shadow-lg">
                                <div class="text-center">
                                    <img src="{{ $userBadge->badge->icon_url ?? asset('assets/images/draghetto.png') }}"
                                         alt="{{ $userBadge->badge->name }}"
                                         class="w-16 h-16 mx-auto mb-2 rounded-full object-cover">
                                    <h3 class="font-semibold text-sm text-neutral-900 dark:text-white mb-1 line-clamp-2">
                                        {{ $userBadge->badge->name }}
                                    </h3>
                                    <p class="text-xs text-neutral-600 dark:text-neutral-400 mb-2">
                                        +{{ $userBadge->badge->points }} {{ __('badge.points') }}
                                    </p>
                                    <div class="text-xs text-amber-600 dark:text-amber-400">
                                        {{ $userBadge->earned_at->format('d/m/Y') }}
                                    </div>

                                    {{-- Show status indicators --}}
                                    @if($userBadge->show_in_profile)
                                        <div class="absolute top-2 right-2 w-3 h-3 bg-primary-500 rounded-full" title="{{ __('badge.shown_in_profile') }}"></div>
                                    @endif
                                    @if($userBadge->show_in_sidebar)
                                        <div class="absolute top-2 left-2 w-3 h-3 bg-yellow-500 rounded-full" title="{{ __('badge.shown_in_sidebar') }}"></div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Stats Footer --}}
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $badges->count() }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('badge.total_badges') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $badges->sum(fn($b) => $b->badge->points ?? 0) }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('badge.total_points') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $profileBadges->count() }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('badge.profile_displayed') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $sidebarBadges->count() }}</div>
                            <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('badge.sidebar_displayed') }}</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🎯</div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('badge.no_badges_earned') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400 mb-4">
                            {{ __('badge.start_interacting') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

