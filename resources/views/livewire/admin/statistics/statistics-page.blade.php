<div class="p-6 max-w-7xl mx-auto" x-data="{ 
    openSections: {
        overview: true,
        users: false,
        events: false,
        content: false,
        groups: false,
        forum: false,
        gigs: false,
        payments: false,
        other: false
    }
}">
    {{-- Header --}}
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
                {{ __('admin.statistics.title') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.description') }}</p>
        </div>
        <button wire:click="refresh" 
                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
            🔄 {{ __('admin.statistics.refresh') }}
        </button>
    </div>

    @if(session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
            <p class="text-green-800 dark:text-green-400 font-semibold">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Overview KPI --}}
    <div class="mb-6" x-show="openSections.overview" x-transition>
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.overview = !openSections.overview">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">📊 {{ __('admin.statistics.sections.overview') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.overview}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white">
                    <div class="text-3xl font-bold">{{ number_format($this->userStats['totals']['all']) }}</div>
                    <div class="text-sm opacity-90">{{ __('admin.statistics.users.total') }}</div>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white">
                    <div class="text-3xl font-bold">{{ number_format($this->eventStats['totals']['all']) }}</div>
                    <div class="text-sm opacity-90">{{ __('admin.statistics.events.total') }}</div>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white">
                    <div class="text-3xl font-bold">{{ number_format($this->contentStats['poems']['total'] + $this->contentStats['articles']['total'] + $this->contentStats['videos']['total']) }}</div>
                    <div class="text-sm opacity-90">{{ __('admin.statistics.content.total') }}</div>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 text-white">
                    <div class="text-3xl font-bold">{{ number_format($this->otherStats['payments']['total_revenue'], 2) }}€</div>
                    <div class="text-sm opacity-90">{{ __('admin.statistics.payments.revenue') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.users = !openSections.users">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">👥 {{ __('admin.statistics.sections.users') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.users}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.users" x-transition class="space-y-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->userStats['totals']['all']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.users.total') }}</div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($this->userStats['totals']['verified']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.users.verified') }}</div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($this->userStats['activity']['online_now']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.users.online_now') }}</div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($this->userStats['subscriptions']['active']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.users.premium') }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <h3 class="font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.statistics.users.registrations') }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.today') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->userStats['registrations']['today']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.this_week') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->userStats['registrations']['this_week']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.this_month') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->userStats['registrations']['this_month']) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <h3 class="font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.statistics.users.by_role') }}</h3>
                        <div class="space-y-2 text-sm">
                            @foreach($this->userStats['by_role'] as $role => $count)
                                <div class="flex justify-between">
                                    <span class="text-neutral-600 dark:text-neutral-400">{{ ucfirst($role) }}</span>
                                    <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($count) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Events Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.events = !openSections.events">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">📅 {{ __('admin.statistics.sections.events') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.events}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.events" x-transition class="space-y-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->eventStats['totals']['all']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.events.total') }}</div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($this->eventStats['totals']['upcoming']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.events.upcoming') }}</div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ number_format($this->eventStats['participants']['total']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.events.participants') }}</div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($this->eventStats['features']['total_invitations']) }}</div>
                        <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.events.invitations') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.content = !openSections.content">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">✍️ {{ __('admin.statistics.sections.content') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.content}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.content" x-transition class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <h3 class="font-bold text-neutral-900 dark:text-white mb-3">📝 {{ __('admin.statistics.content.poems') }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.total') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['poems']['total']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.this_month') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['poems']['this_month']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.comments') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['poems']['total_comments']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.likes') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['poems']['total_likes']) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <h3 class="font-bold text-neutral-900 dark:text-white mb-3">📰 {{ __('admin.statistics.content.articles') }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.total') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['articles']['total']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.this_month') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['articles']['this_month']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.comments') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['articles']['total_comments']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.likes') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['articles']['total_likes']) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                        <h3 class="font-bold text-neutral-900 dark:text-white mb-3">🎬 {{ __('admin.statistics.content.videos') }}</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.total') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['videos']['total']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.this_month') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['videos']['this_month']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.comments') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['videos']['total_comments']) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.views') }}</span>
                                <span class="font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['videos']['total_views']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-3">💬 {{ __('admin.statistics.content.engagement') }}</h3>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <div class="text-xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['engagement']['total_comments']) }}</div>
                            <div class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.total_comments') }}</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['engagement']['total_likes']) }}</div>
                            <div class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.total_likes') }}</div>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->contentStats['engagement']['total_views']) }}</div>
                            <div class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.content.total_views') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Groups Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.groups = !openSections.groups">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">👥 {{ __('admin.statistics.sections.groups') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.groups}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.groups" x-transition class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->groupStats['totals']['all']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.groups.total') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($this->groupStats['totals']['public']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.groups.public') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($this->groupStats['members']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.groups.members') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($this->groupStats['content']['total_announcements']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.groups.announcements') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Forum Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.forum = !openSections.forum">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">💬 {{ __('admin.statistics.sections.forum') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.forum}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.forum" x-transition class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->forumStats['subreddits']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.forum.subreddits') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($this->forumStats['posts']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.forum.posts') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($this->forumStats['comments']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.forum.comments') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($this->forumStats['votes']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.forum.votes') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gigs Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.gigs = !openSections.gigs">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">💼 {{ __('admin.statistics.sections.gigs') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.gigs}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.gigs" x-transition class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->gigStats['totals']['all']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.gigs.total') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($this->gigStats['totals']['open']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.gigs.open') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($this->gigStats['applications']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.gigs.applications') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-purple-600">{{ number_format($this->gigStats['positions']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.gigs.positions') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payments & Other Statistics --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.payments = !openSections.payments">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">💰 {{ __('admin.statistics.sections.payments') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.payments}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.payments" x-transition class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-green-600">{{ number_format($this->otherStats['payments']['total_revenue'], 2) }}€</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.payments.revenue') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-neutral-900 dark:text-white">{{ number_format($this->otherStats['payments']['total']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.payments.total') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-blue-600">{{ number_format($this->otherStats['payments']['completed']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.payments.completed') }}</div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <div class="text-2xl font-bold text-yellow-600">{{ number_format($this->otherStats['payments']['pending']) }}</div>
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.payments.pending') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Other Statistics (Carousels, Support, etc.) --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4 cursor-pointer" @click="openSections.other = !openSections.other">
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">⚙️ {{ __('admin.statistics.sections.other') }}</h2>
                <svg class="w-6 h-6 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="{'rotate-180': openSections.other}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div x-show="openSections.other" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-2">🎠 {{ __('admin.statistics.other.carousels') }}</h3>
                    <div class="text-sm space-y-1">
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.total') }}</span>
                            <span class="font-bold">{{ number_format($this->otherStats['carousels']['total']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.active') }}</span>
                            <span class="font-bold text-green-600">{{ number_format($this->otherStats['carousels']['active']) }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-2">🎫 {{ __('admin.statistics.other.support') }}</h3>
                    <div class="text-sm space-y-1">
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.total') }}</span>
                            <span class="font-bold">{{ number_format($this->otherStats['support_tickets']['total']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.open') }}</span>
                            <span class="font-bold text-yellow-600">{{ number_format($this->otherStats['support_tickets']['open']) }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
                    <h3 class="font-bold text-neutral-900 dark:text-white mb-2">🏆 {{ __('admin.statistics.other.gamification') }}</h3>
                    <div class="text-sm space-y-1">
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.other.badges') }}</span>
                            <span class="font-bold">{{ number_format($this->otherStats['gamification']['badges']['total']) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-600 dark:text-neutral-400">{{ __('admin.statistics.other.assigned') }}</span>
                            <span class="font-bold">{{ number_format($this->otherStats['gamification']['badges']['assigned']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

