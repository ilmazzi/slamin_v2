<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Navigation Tabs --}}
        <div class="mb-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.gamification.badges') ?? '#' }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Badge
                </a>
                <a href="{{ route('admin.gamification.user-badges') ?? '#' }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Badge Utenti
                </a>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    {{ __('gamification.user_badges_management') }}
                </h2>
            </div>

            <div class="p-6">
                {{-- Filters --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('Filtra per Badge') }}
                        </label>
                        <select wire:model.live="filterBadge" 
                                class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">{{ __('Tutti i badge') }}</option>
                            @foreach($badges as $badge)
                                <option value="{{ $badge->id }}">{{ $badge->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('Cerca Utente') }}
                        </label>
                        <input type="text" 
                               wire:model.live.debounce.300ms="filterUser" 
                               class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                               placeholder="{{ __('Nome, nickname o email...') }}">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="$set('filterBadge', ''); $set('filterUser', '')" 
                                class="w-full px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ __('Pulisci Filtri') }}
                        </button>
                    </div>
                </div>

                @if($userBadges && $userBadges->count() > 0)
                    {{-- Mobile Card View --}}
                    <div class="lg:hidden space-y-4">
                        @foreach($userBadges as $userBadge)
                            <div class="bg-neutral-50 dark:bg-neutral-700/50 rounded-lg border border-neutral-200 dark:border-neutral-600 p-4">
                                <div class="flex items-start gap-3">
                                    @if($userBadge->user)
                                        <img src="{{ $userBadge->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                             alt="{{ $userBadge->user->getDisplayName() }}" 
                                             class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        @if($userBadge->user)
                                            <h3 class="font-semibold text-neutral-900 dark:text-white mb-1">
                                                {{ $userBadge->user->getDisplayName() }}
                                            </h3>
                                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-2">
                                                {{ $userBadge->user->email }}
                                            </p>
                                        @else
                                            <p class="text-neutral-500 dark:text-neutral-400">{{ __('Utente eliminato') }}</p>
                                        @endif

                                        @if($userBadge->badge)
                                            <div class="flex items-center gap-2 mb-2">
                                                <img src="{{ $userBadge->badge->icon_url }}" 
                                                     alt="{{ $userBadge->badge->name }}" 
                                                     class="w-8 h-8 rounded-full object-cover">
                                                <div>
                                                    <div class="font-semibold text-sm text-neutral-900 dark:text-white">
                                                        {{ $userBadge->badge->name }}
                                                    </div>
                                                    <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                        ⭐ {{ $userBadge->badge->points }} {{ __('punti') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex flex-wrap gap-2 mb-2">
                                            @if($userBadge->show_in_sidebar)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                                    </svg>
                                                    Sidebar
                                                </span>
                                            @endif
                                            @if($userBadge->show_in_profile)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    Profilo
                                                </span>
                                            @endif
                                            @if(!$userBadge->show_in_sidebar && !$userBadge->show_in_profile)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                                    </svg>
                                                    Nascosto
                                                </span>
                                            @endif
                                            @if($userBadge->awardedBy)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    {{ Str::limit($userBadge->awardedBy->getDisplayName(), 15) }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    🤖 Automatico
                                                </span>
                                            @endif
                                        </div>

                                        <div class="text-xs text-neutral-500 dark:text-neutral-400 mb-3">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $userBadge->earned_at->format('d/m/Y H:i') }}
                                            ({{ $userBadge->earned_at->diffForHumans() }})
                                        </div>

                                        <button wire:click="removeBadge({{ $userBadge->id }})" 
                                                onclick="return confirm('{{ __('Sei sicuro di voler rimuovere questo badge da') }} {{ $userBadge->user?->getDisplayName() }}?')"
                                                class="w-full px-4 py-2 bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/30 transition-colors">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            {{ __('Rimuovi Badge') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop Table View --}}
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                            <thead class="bg-neutral-50 dark:bg-neutral-900">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Avatar</th>
                                    <th wire:click="sortByColumn('user')" 
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                        <div class="flex items-center gap-2">
                                            {{ __('Utente') }}
                                            @if($sortBy === 'user')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $sortDirection === 'asc' ? '5' : '19' }} {{ $sortDirection === 'asc' ? '15' : '9' }}l-7-7m0 0l-7 7m7-7v18"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </th>
                                    <th wire:click="sortByColumn('badge')" 
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                        <div class="flex items-center gap-2">
                                            {{ __('Badge') }}
                                            @if($sortBy === 'badge')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $sortDirection === 'asc' ? '5' : '19' }} {{ $sortDirection === 'asc' ? '15' : '9' }}l-7-7m0 0l-7 7m7-7v18"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </th>
                                    <th wire:click="sortByColumn('earned_at')" 
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                        <div class="flex items-center gap-2">
                                            {{ __('Guadagnato') }}
                                            @if($sortBy === 'earned_at')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $sortDirection === 'asc' ? '5' : '19' }} {{ $sortDirection === 'asc' ? '15' : '9' }}l-7-7m0 0l-7 7m7-7v18"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Dove Visibile</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Assegnato Da</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider" style="width: 100px;">Azioni</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                                @foreach($userBadges as $userBadge)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($userBadge->user)
                                                <img src="{{ $userBadge->user->profile_photo_url ?? asset('assets/images/avatar/default-avatar.webp') }}" 
                                                     alt="{{ $userBadge->user->getDisplayName() }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($userBadge->user)
                                                <div class="font-semibold text-neutral-900 dark:text-white">
                                                    {{ $userBadge->user->getDisplayName() }}
                                                </div>
                                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                                    {{ $userBadge->user->email }}
                                                </div>
                                            @else
                                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('Utente eliminato') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($userBadge->badge)
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ $userBadge->badge->icon_url }}" 
                                                         alt="{{ $userBadge->badge->name }}" 
                                                         class="w-8 h-8 rounded-full object-cover">
                                                    <div>
                                                        <div class="font-semibold text-sm text-neutral-900 dark:text-white">
                                                            {{ $userBadge->badge->name }}
                                                        </div>
                                                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                            ⭐ {{ $userBadge->badge->points }} {{ __('punti') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <div class="text-neutral-900 dark:text-white">
                                                {{ $userBadge->earned_at->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                {{ $userBadge->earned_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @if($userBadge->show_in_sidebar)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                                        Sidebar
                                                    </span>
                                                @endif
                                                @if($userBadge->show_in_profile)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Profilo
                                                    </span>
                                                @endif
                                                @if(!$userBadge->show_in_sidebar && !$userBadge->show_in_profile)
                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200">
                                                        Nascosto
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if($userBadge->awardedBy)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">
                                                    {{ Str::limit($userBadge->awardedBy->getDisplayName(), 15) }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    🤖 Automatico
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <button wire:click="removeBadge({{ $userBadge->id }})" 
                                                    onclick="return confirm('{{ __('Sei sicuro di voler rimuovere questo badge da') }} {{ $userBadge->user?->getDisplayName() }}?')"
                                                    class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                    title="{{ __('Rimuovi Badge') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $userBadges->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🏆</div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('Nessun badge assegnato') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400">
                            @if($filterBadge || $filterUser)
                                {{ __('Nessun risultato con i filtri selezionati') }}
                            @else
                                {{ __('Non sono ancora stati assegnati badge agli utenti') }}
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</div>

