<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 dark:from-primary-700 dark:to-primary-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ __('groups.community_title') }}</h1>
                    <p class="text-primary-100">{{ __('groups.community_subtitle') }}</p>
                </div>
                @auth
                <a href="{{ route('groups.create') }}" wire:navigate
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-600 rounded-xl font-semibold hover:bg-primary-50 transition-all shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('groups.create_group') }}
                </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Tab Switcher --}}
        <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-2 mb-6">
            <div class="flex gap-2">
                <button wire:click="switchTab('groups')"
                        class="flex-1 px-6 py-3 rounded-xl font-semibold transition-all {{ $activeTab === 'groups' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        {{ __('groups.groups_tab') }}
                    </span>
                </button>
                <button wire:click="switchTab('users')"
                        class="flex-1 px-6 py-3 rounded-xl font-semibold transition-all {{ $activeTab === 'users' ? 'bg-primary-600 text-white shadow-lg' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('groups.users_tab') }}
                    </span>
                </button>
            </div>
        </div>

        @if($activeTab === 'groups')
            {{-- Groups Tab --}}
            <div>
                {{-- Filters --}}
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" wire:model.live.debounce.300ms="groupSearch"
                                   placeholder="{{ __('groups.search_groups') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <select wire:model.live="groupFilter"
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                <option value="">{{ __('groups.all_groups_filter') }}</option>
                                <option value="my_groups">{{ __('groups.my_groups_filter') }}</option>
                                <option value="my_admin_groups">{{ __('groups.my_admin_groups_filter') }}</option>
                                <option value="public">{{ __('groups.public_filter') }}</option>
                            </select>
                        </div>
                        <div>
                            <button wire:click="clearGroupFilters"
                                    class="w-full px-4 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-700 transition-colors font-medium">
                                {{ __('groups.reset_filters') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Groups Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($groups as $group)
                        <a href="{{ route('groups.show', $group) }}" wire:navigate
                           class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm hover:shadow-xl transition-all overflow-hidden group">
                            @if($group->image)
                                <img src="{{ Storage::url($group->image) }}" alt="{{ $group->name }}"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        {{ $group->name }}
                                    </h3>
                                    @if($group->visibility === 'private')
                                        <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 text-xs font-semibold rounded-lg">
                                            Privato
                                        </span>
                                    @endif
                                </div>
                                <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4 line-clamp-2">
                                    {{ $group->description }}
                                </p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-neutral-500 dark:text-neutral-500">
                                        {{ $group->members_count }} {{ $group->members_count === 1 ? 'membro' : 'membri' }}
                                    </span>
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">
                                        {{ __('groups.view_more') }} →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-20 h-20 mx-auto text-neutral-300 dark:text-neutral-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-neutral-500 dark:text-neutral-500 text-lg">{{ __('groups.no_groups') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $groups->links() }}
                </div>
            </div>
        @else
            {{-- Users Tab --}}
            <div>
                {{-- Filters --}}
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" wire:model.live.debounce.300ms="userSearch"
                                   placeholder="{{ __('groups.search_users') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <select wire:model.live="userFilter"
                                    class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                <option value="">{{ __('groups.all_users_filter') }}</option>
                                <option value="poets">{{ __('groups.poets_filter') }}</option>
                                <option value="organizers">{{ __('groups.organizers_filter') }}</option>
                            </select>
                        </div>
                        <div>
                            <button wire:click="clearUserFilters"
                                    class="w-full px-4 py-3 rounded-xl bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-300 dark:hover:bg-neutral-700 transition-colors font-medium">
                                {{ __('groups.reset_filters') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Users Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($users as $user)
                        <a href="{{ route('user.show', $user) }}"
                           onclick="window.location.href = this.href; return false;"
                           class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm hover:shadow-xl transition-all p-6 group">
                            <div class="flex items-center gap-4 mb-4">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 100) }}"
                                     alt="{{ $user->name }}"
                                     class="w-16 h-16 rounded-full object-cover ring-4 ring-primary-100 dark:ring-primary-900 group-hover:ring-primary-200 dark:group-hover:ring-primary-800 transition-all">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        {{ $user->name }}
                                    </h3>
                                    @if($user->nickname)
                                        <p class="text-sm text-neutral-500 dark:text-neutral-500 truncate">{{ $user->nickname }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-neutral-600 dark:text-neutral-400">
                                <span>{{ $user->poems_count }} poesie</span>
                                <span>•</span>
                                <span>{{ $user->articles_count }} articoli</span>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="w-20 h-20 mx-auto text-neutral-300 dark:text-neutral-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <p class="text-neutral-500 dark:text-neutral-500 text-lg">{{ __('groups.no_users') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
