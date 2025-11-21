<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.permissions.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.permissions.description') }}</p>

    {{-- Statistiche --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 mb-6 border border-neutral-200 dark:border-neutral-700">
        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.permissions.total') }}</p>
        <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['total'] }}</p>
    </div>

    {{-- Filtri e ricerca --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow mb-6 p-4 border border-neutral-200 dark:border-neutral-700">
        <div class="flex items-center gap-4 mb-4">
            <button wire:click="openCreateModal" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                {{ __('admin.permissions.create') }}
            </button>
            <div class="flex-1">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="{{ __('admin.permissions.search_placeholder') }}"
                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div class="w-48">
                <select wire:model.live="group" 
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">{{ __('admin.permissions.all_groups') }}</option>
                    @foreach($this->availableGroups as $groupName)
                        <option value="{{ $groupName }}">{{ ucfirst($groupName) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Tabella permessi --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-700/50 border-b border-neutral-200 dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors"
                            wire:click="sortByColumn('name')">
                            <div class="flex items-center gap-2">
                                {{ __('admin.permissions.name') }}
                                @if($sortBy === 'name')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.permissions.display_name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.permissions.group') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.permissions.roles_count') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.permissions.users_count') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.permissions.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($permissions as $permission)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ $permission->name }}
                                </div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ $permission->guard_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-white">
                                    {{ $permission->display_name ?? $permission->name }}
                                </div>
                                @if($permission->description)
                                    <div class="text-xs text-neutral-500 dark:text-neutral-400 max-w-md truncate">
                                        {{ $permission->description }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($permission->group)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                        {{ ucfirst($permission->group) }}
                                    </span>
                                @else
                                    <span class="text-xs text-neutral-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $permission->roles_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ $permission->users_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="openEditModal({{ $permission->id }})" 
                                            class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 transition-colors"
                                            title="{{ __('admin.permissions.edit') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="deletePermission({{ $permission->id }})" 
                                            wire:confirm="{{ __('admin.permissions.delete_confirm') }}"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors"
                                            title="{{ __('admin.permissions.delete') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-neutral-500 dark:text-neutral-400">{{ __('admin.permissions.no_permissions_found') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $permissions->links() }}
        </div>
    </div>

    {{-- Modal Crea/Modifica --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
             wire:click="closeModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto"
                 wire:click.stop>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        {{ $editingPermission ? __('admin.permissions.edit_permission') : __('admin.permissions.create_permission') }}
                    </h2>
                    
                    <form wire:submit.prevent="save">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.permissions.name') }} *
                                    </label>
                                    <input type="text" 
                                           wire:model="name"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="es. edit.articles, delete.users">
                                    @error('name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.permissions.guard_name') }} *
                                    </label>
                                    <input type="text" 
                                           wire:model="guard_name"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           value="web" readonly>
                                    @error('guard_name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.permissions.display_name') }}
                                </label>
                                <input type="text" 
                                       wire:model="display_name"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Nome visualizzato">
                                @error('display_name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.permissions.group_label') }}
                                </label>
                                <input type="text" 
                                       wire:model="permissionGroup"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="es. articles, users, admin">
                                @error('permissionGroup') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Usato per raggruppare i permessi nella visualizzazione</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.permissions.description') }}
                                </label>
                                <textarea wire:model="description"
                                          rows="3"
                                          class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                          placeholder="Descrizione del permesso"></textarea>
                                @error('description') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end gap-3 mt-6">
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                                {{ __('admin.permissions.cancel') }}
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                {{ __('admin.permissions.save') }}
                            </button>
                        </div>
                    </form>
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

