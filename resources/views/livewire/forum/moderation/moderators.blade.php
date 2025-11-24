<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('forum.subreddit.show', $subreddit) }}" wire:navigate
                   class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to r/{{ $subreddit->name }}
                </a>
                
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('forum.moderators') }} - r/{{ $subreddit->name }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('forum.moderators_description') }}
                </p>
            </div>

            {{-- Add Moderator Form --}}
            @if($isOwner)
                <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('forum.add_moderator') }}</h3>
                    <form wire:submit="addModerator" class="space-y-4">
                        <div>
                            <label for="newModSearch" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.search_user') }}
                            </label>
                            <input type="text" 
                                   id="newModSearch" 
                                   wire:model.live="newModSearch" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                                   placeholder="Cerca utente per nome...">
                            @error('newModUserId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
                            @if($userSearchResults && count($userSearchResults) > 0)
                                <div class="mt-2 border border-gray-300 dark:border-gray-700 rounded-lg max-h-48 overflow-y-auto">
                                    @foreach($userSearchResults as $user)
                                        <button type="button" 
                                                wire:click="selectUser({{ $user->id }})"
                                                class="w-full px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-neutral-800 flex items-center gap-3">
                                            <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($user, 32) }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="w-8 h-8 rounded-full">
                                            <span class="text-gray-900 dark:text-white">u/{{ $user->name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.moderator_role') }}
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-start p-3 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800">
                                    <input type="radio" wire:model="newModRole" value="moderator" class="mt-1 mr-3">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ __('forum.moderator') }}</div>
                                        <div class="text-sm text-gray-500">{{ __('forum.moderator_permissions') }}</div>
                                    </div>
                                </label>
                                <label class="flex items-start p-3 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-neutral-800">
                                    <input type="radio" wire:model="newModRole" value="admin" class="mt-1 mr-3">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ __('forum.admin') }}</div>
                                        <div class="text-sm text-gray-500">{{ __('forum.admin_permissions') }}</div>
                                    </div>
                                </label>
                            </div>
                            @error('newModRole') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                            {{ __('forum.add_moderator') }}
                        </button>
                    </form>
                </div>
            @endif

            {{-- Moderators List --}}
            <div class="bg-white dark:bg-neutral-900 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('forum.current_moderators') }} ({{ $moderators->count() }})
                </h3>
                
                <div class="space-y-3">
                    {{-- Creator --}}
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-lg border-2 border-orange-200 dark:border-orange-800">
                        <div class="flex items-center gap-4">
                            <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($subreddit->creator, 48) }}" 
                                 alt="{{ $subreddit->creator->name }}" 
                                 class="w-12 h-12 rounded-full">
                            <div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('profile.show', $subreddit->creator) }}" 
                                       class="font-bold text-gray-900 dark:text-white hover:underline">
                                        u/{{ $subreddit->creator->name }}
                                    </a>
                                    <span class="px-3 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full">
                                        {{ __('forum.creator') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">{{ __('forum.created') }} {{ $subreddit->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Moderators --}}
                    @forelse($moderators as $moderator)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg">
                            <div class="flex items-center gap-4">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($moderator->user, 48) }}" 
                                     alt="{{ $moderator->user->name }}" 
                                     class="w-12 h-12 rounded-full">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('profile.show', $moderator->user) }}" 
                                           class="font-bold text-gray-900 dark:text-white hover:underline">
                                            u/{{ $moderator->user->name }}
                                        </a>
                                        <span class="px-3 py-1 {{ $moderator->role === 'admin' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400' }} text-xs font-semibold rounded-full">
                                            {{ __('forum.' . $moderator->role) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        {{ __('forum.added_by') }} u/{{ $moderator->addedBy->name }} • {{ $moderator->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if($isOwner)
                                <button wire:click="removeModerator({{ $moderator->id }})" 
                                        wire:confirm="Sei sicuro di voler rimuovere questo moderatore?"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all">
                                    {{ __('forum.remove') }}
                                </button>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-6">{{ __('forum.no_moderators_yet') }}</p>
                    @endforelse
                </div>
            </div>

            {{-- Permissions Info --}}
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                <h3 class="text-lg font-bold text-blue-900 dark:text-blue-300 mb-3">{{ __('forum.permissions_info') }}</h3>
                <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                    <div>
                        <strong>{{ __('forum.creator') }}:</strong> {{ __('forum.creator_permissions_desc') }}
                    </div>
                    <div>
                        <strong>{{ __('forum.admin') }}:</strong> {{ __('forum.admin_permissions_desc') }}
                    </div>
                    <div>
                        <strong>{{ __('forum.moderator') }}:</strong> {{ __('forum.moderator_permissions_desc') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

