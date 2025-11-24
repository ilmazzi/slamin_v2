<div>
    @vite(['resources/css/forum.css', 'resources/js/forum.js'])

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ __('forum.banned_users') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('forum.bans_description') }}
                    </p>
                </div>
                <button @click="$wire.showBanForm = !$wire.showBanForm" 
                        class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold hover:shadow-lg transition-all">
                    + {{ __('forum.ban_user') }}
                </button>
            </div>

            {{-- Ban User Form --}}
            @if($showBanForm)
                <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 mb-6 border-2 border-orange-500">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ __('forum.ban_user') }}</h3>
                    <form wire:submit="banUser" class="space-y-4">
                        <div>
                            <label for="banUserId" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.user') }} *
                            </label>
                            <input type="text" 
                                   id="banUserId" 
                                   wire:model.live="banUserSearch" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                                   placeholder="Cerca utente...">
                            @error('banUserId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            
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
                            <label for="banReason" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.reason') }} *
                            </label>
                            <textarea id="banReason" 
                                      wire:model="banReason" 
                                      rows="3"
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                                      placeholder="Motivo del ban..."></textarea>
                            @error('banReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('forum.ban_type') }} *
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" wire:model="banType" value="temporary" class="mr-2">
                                    <span class="text-gray-900 dark:text-white">{{ __('forum.temporary') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" wire:model="banType" value="permanent" class="mr-2">
                                    <span class="text-gray-900 dark:text-white">{{ __('forum.permanent') }}</span>
                                </label>
                            </div>
                            @error('banType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if($banType === 'temporary')
                            <div>
                                <label for="banExpiresAt" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('forum.expires_at') }} *
                                </label>
                                <input type="datetime-local" 
                                       id="banExpiresAt" 
                                       wire:model="banExpiresAt" 
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                                @error('banExpiresAt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="px-6 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-all">
                                {{ __('forum.ban_user') }}
                            </button>
                            <button type="button" 
                                    @click="$wire.showBanForm = false" 
                                    class="px-6 py-3 bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold">
                                {{ __('forum.cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Bans List --}}
            <div class="space-y-4">
                @forelse($bans as $ban)
                    <div class="bg-white dark:bg-neutral-900 rounded-xl p-6 {{ $ban->isActive() ? 'border-l-4 border-red-500' : 'opacity-60' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-4 flex-1">
                                <img src="{{ \App\Helpers\AvatarHelper::getUserAvatarUrl($ban->user, 48) }}" 
                                     alt="{{ $ban->user->name }}" 
                                     class="w-12 h-12 rounded-full">
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <a href="{{ route('profile.show', $ban->user) }}" 
                                           class="text-lg font-bold text-gray-900 dark:text-white hover:underline">
                                            u/{{ $ban->user->name }}
                                        </a>
                                        @if($ban->isActive())
                                            <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 text-xs font-semibold rounded-full">
                                                {{ $ban->is_permanent ? __('forum.permanent') : __('forum.temporary') }}
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs font-semibold rounded-full">
                                                {{ __('forum.lifted') }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="text-sm text-gray-500 mb-2">
                                        Banned by <a href="{{ route('profile.show', $ban->bannedBy) }}" class="text-orange-500 hover:underline">u/{{ $ban->bannedBy->name }}</a>
                                        • {{ $ban->created_at->diffForHumans() }}
                                        @if(!$ban->is_permanent && $ban->expires_at)
                                            • {{ __('forum.expires') }}: {{ $ban->expires_at->format('d/m/Y H:i') }}
                                        @endif
                                    </div>
                                    
                                    <div class="p-3 bg-gray-50 dark:bg-neutral-800 rounded-lg">
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('forum.reason') }}:</p>
                                        <p class="text-gray-900 dark:text-white">{{ $ban->reason }}</p>
                                    </div>

                                    @if($ban->lifted_at)
                                        <div class="mt-2 text-sm text-gray-500">
                                            {{ __('forum.lifted_by') }} u/{{ $ban->liftedBy->name }} • {{ $ban->lifted_at->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($ban->isActive())
                                <button wire:click="liftBan({{ $ban->id }})" 
                                        wire:confirm="Sei sicuro di voler rimuovere questo ban?"
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-all">
                                    {{ __('forum.lift_ban') }}
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-neutral-900 rounded-xl p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <p class="text-gray-500 text-lg">{{ __('forum.no_bans') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $bans->links() }}
            </div>
        </div>
    </div>
</div>

