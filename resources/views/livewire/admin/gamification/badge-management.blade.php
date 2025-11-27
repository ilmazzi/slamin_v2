<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Navigation Tabs --}}
        <div class="mb-6">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.gamification.badges') ?? '#' }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Badge
                </a>
                <a href="{{ route('admin.gamification.user-badges') ?? '#' }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Badge Utenti
                </a>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    {{ __('gamification.badges_management') }}
                </h2>
                <button wire:click="create" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('gamification.create_badge') }}
                </button>
            </div>

            <div class="p-6">
                @if($badges && $badges->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                            <thead class="bg-neutral-50 dark:bg-neutral-900">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider" style="width: 60px;">Icona</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nome</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Tipo</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Categoria</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Criterio</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Punti</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Stato</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider" style="width: 200px;">Azioni</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                                @foreach($badges as $badge)
                                    <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <img src="{{ $badge->icon_url }}" alt="{{ $badge->name }}" 
                                                 class="w-8 h-8 rounded-full object-cover">
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="font-semibold text-neutral-900 dark:text-white">{{ $badge->name }}</div>
                                            @if($badge->description)
                                                <div class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                                                    {{ Str::limit($badge->description, 50) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge->type === 'portal' ? 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                                                {{ __('gamification.type_' . $badge->type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200">
                                                {{ __('gamification.category_' . $badge->category) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-400">
                                            <span class="text-neutral-500 dark:text-neutral-400">{{ $badge->criteria_value }}x</span>
                                            {{ __('gamification.criteria_' . $badge->criteria_type) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">
                                                ⭐ {{ $badge->points }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       wire:click="toggleActive({{ $badge->id }})"
                                                       {{ $badge->is_active ? 'checked' : '' }}
                                                       class="sr-only peer">
                                                <div class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                                            </label>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <button wire:click="edit({{ $badge->id }})" 
                                                        class="p-2 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors"
                                                        title="{{ __('gamification.edit_badge') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                                <button wire:click="openAssignModal({{ $badge->id }})" 
                                                        class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                                        title="{{ __('gamification.assign_badge') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                    </svg>
                                                </button>
                                                <button wire:click="delete({{ $badge->id }})" 
                                                        onclick="return confirm('{{ __('Sei sicuro di voler eliminare questo badge?') }}')"
                                                        class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                        title="{{ __('Elimina') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🏆</div>
                        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('gamification.no_badges') }}
                        </h3>
                        <p class="text-neutral-600 dark:text-neutral-400">
                            {{ __('Crea il tuo primo badge per iniziare!') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-neutral-500 bg-opacity-75" wire:click="$set('showModal', false)"></div>
                
                <div class="relative inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full z-50">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">
                            {{ $isEditing ? __('gamification.edit_badge') : __('gamification.create_badge') }}
                        </h3>
                        <button wire:click="$set('showModal', false)" 
                                class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="save" class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_type') }} *
                                </label>
                                <select wire:model="type" 
                                        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                        required>
                                    <option value="portal">{{ __('gamification.type_portal') }}</option>
                                    <option value="event">{{ __('gamification.type_event') }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_category') }} *
                                </label>
                                <select wire:model="category" 
                                        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                        required>
                                    <option value="videos">{{ __('gamification.category_videos') }}</option>
                                    <option value="articles">{{ __('gamification.category_articles') }}</option>
                                    <option value="poems">{{ __('gamification.category_poems') }}</option>
                                    <option value="photos">{{ __('gamification.category_photos') }}</option>
                                    <option value="likes">{{ __('gamification.category_likes') }}</option>
                                    <option value="comments">{{ __('gamification.category_comments') }}</option>
                                    <option value="posts">{{ __('gamification.category_posts') }}</option>
                                    <option value="event_participation">{{ __('gamification.category_event_participation') }}</option>
                                    <option value="event_wins">{{ __('gamification.category_event_wins') }}</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_name') }} *
                                </label>
                                <input type="text" wire:model="name" 
                                       class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_description') }}
                                </label>
                                <textarea wire:model="description" 
                                          rows="2"
                                          class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_criteria_type') }} *
                                </label>
                                <select wire:model="criteria_type" 
                                        class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                        required>
                                    <option value="count">{{ __('gamification.criteria_count') }}</option>
                                    <option value="milestone">{{ __('gamification.criteria_milestone') }}</option>
                                    <option value="first_time">{{ __('gamification.criteria_first_time') }}</option>
                                    <option value="special">{{ __('gamification.criteria_special') }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_criteria_value') }} *
                                </label>
                                <input type="number" wire:model="criteria_value" 
                                       min="1"
                                       class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_points') }} *
                                </label>
                                <input type="number" wire:model="points" 
                                       min="0"
                                       class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_order') }}
                                </label>
                                <input type="number" wire:model="order" 
                                       min="0"
                                       class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('gamification.badge_icon') }}
                                </label>
                                <input type="file" wire:model="icon" 
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                @if($existing_icon)
                                    <div class="mt-2 flex items-center gap-2">
                                        <img src="{{ asset($existing_icon) }}" alt="Current icon" class="w-8 h-8 rounded-full">
                                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('Icona attuale') }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="is_active" 
                                           class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                    <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        {{ __('gamification.badge_active') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </form>

                    <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end gap-3">
                        <button type="button" 
                                wire:click="$set('showModal', false)"
                                class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors">
                            {{ __('gamification.cancel') }}
                        </button>
                        <button type="button" 
                                wire:click="save"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('gamification.save_badge') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Assign Badge Modal --}}
    @if($showAssignModal)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-neutral-500 bg-opacity-75" wire:click="$set('showAssignModal', false)"></div>
                
                <div class="relative inline-block align-bottom bg-white dark:bg-neutral-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full z-50">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">
                            {{ __('gamification.assign_to_user') }}
                        </h3>
                        <button wire:click="$set('showAssignModal', false)" 
                                class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('Cerca Utente') }} *
                            </label>
                            
                            @if($selectedUser)
                                <div class="bg-neutral-50 dark:bg-neutral-700 rounded-lg p-3 border border-neutral-200 dark:border-neutral-600">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $selectedUser->profile_photo ? asset('storage/' . $selectedUser->profile_photo) : asset('assets/images/draghetto.png') }}" 
                                                 alt="{{ $selectedUser->name }}" 
                                                 class="w-12 h-12 rounded-full object-cover">
                                            <div>
                                                <div class="font-semibold text-neutral-900 dark:text-white">{{ $selectedUser->name }}</div>
                                                <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $selectedUser->email }}</div>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                wire:click="$set('selectedUser', null)" 
                                                class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="relative">
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="userSearch" 
                                           class="w-full px-3 py-2 pr-10 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                           placeholder="{{ __('Cerca per nome, nickname o email...') }}"
                                           autocomplete="off">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        @if(strlen($userSearch) > 0)
                                            <button type="button" 
                                                    wire:click="$set('userSearch', '')" 
                                                    class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        @else
                                            <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(strlen($userSearch) >= 2)
                                    @if(count($searchResults) > 0)
                                        <div class="mt-2 max-h-60 overflow-y-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                            @foreach($searchResults as $result)
                                                <button type="button" 
                                                        wire:click="selectUser({{ $result->id }})" 
                                                        class="w-full px-4 py-3 text-left hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors border-b border-neutral-200 dark:border-neutral-700 last:border-b-0">
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ $result->profile_photo ? asset('storage/' . $result->profile_photo) : asset('assets/images/draghetto.png') }}" 
                                                             alt="{{ $result->name }}" 
                                                             class="w-10 h-10 rounded-full object-cover">
                                                        <div>
                                                            <div class="font-semibold text-neutral-900 dark:text-white">{{ $result->name }}</div>
                                                            <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $result->email }}</div>
                                                        </div>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="mt-2 p-3 bg-neutral-50 dark:bg-neutral-700 rounded-lg text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ __('Nessun utente trovato per') }} "{{ $userSearch }}"
                                        </div>
                                    @endif
                                @elseif(strlen($userSearch) > 0 && strlen($userSearch) < 2)
                                    <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ __('Digita almeno 2 caratteri per cercare...') }}
                                    </p>
                                @endif
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('Note') }}
                            </label>
                            <textarea wire:model="assignNotes" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent" 
                                      placeholder="{{ __('Note sull\'assegnazione manuale (opzionale)') }}"></textarea>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end gap-3">
                        <button type="button" 
                                wire:click="$set('showAssignModal', false)"
                                class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600 transition-colors">
                            {{ __('gamification.cancel') }}
                        </button>
                        <button type="button" 
                                wire:click="assignBadge"
                                @if(!$selectedUser) disabled @endif
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ __('gamification.assign_badge') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

