<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.roles.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.roles.description') }}</p>

    {{-- Statistiche --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.roles.total') }}</p>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.roles.with_permissions') }}</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $this->stats['with_permissions'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.roles.total_users') }}</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $this->stats['total_users'] }}</p>
        </div>
    </div>

    {{-- Filtri e ricerca --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow mb-6 p-4 border border-neutral-200 dark:border-neutral-700">
        <div class="flex items-center justify-between mb-4">
            <button wire:click="openCreateModal" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                {{ __('admin.roles.create') }}
            </button>
            <div class="w-64">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="{{ __('admin.roles.search_placeholder') }}"
                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
        </div>
    </div>

    {{-- Tabella ruoli --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-700/50 border-b border-neutral-200 dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors"
                            wire:click="sortByColumn('name')">
                            <div class="flex items-center gap-2">
                                {{ __('admin.roles.name') }}
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
                            {{ __('admin.roles.display_name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.roles.description') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.roles.permissions_count') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.roles.users_count') }}
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.roles.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($roles as $role)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                    {{ $role->name }}
                                </div>
                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ $role->guard_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-white">
                                    {{ $role->display_name ?? $role->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-neutral-600 dark:text-neutral-400 max-w-md truncate">
                                    {{ $role->description ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $role->permissions_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ $role->users_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="openEditModal({{ $role->id }})" 
                                            class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 transition-colors"
                                            title="{{ __('admin.roles.edit') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    @if($role->name !== 'admin')
                                        <button wire:click="deleteRole({{ $role->id }})" 
                                                wire:confirm="{{ __('admin.roles.delete_confirm') }}"
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors"
                                                title="{{ __('admin.roles.delete') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="text-neutral-500 dark:text-neutral-400">{{ __('admin.roles.no_roles_found') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $roles->links() }}
        </div>
    </div>

    {{-- Modal Crea/Modifica --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
             wire:click="closeModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                 wire:click.stop>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        {{ $editingRole ? __('admin.roles.edit_role') : __('admin.roles.create_role') }}
                    </h2>
                    
                    <form wire:submit.prevent="save">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.roles.name') }} *
                                    </label>
                                    <input type="text" 
                                           wire:model="name"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="es. admin, poet, organizer">
                                    @error('name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.roles.guard_name') }} *
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
                                    {{ __('admin.roles.display_name') }}
                                </label>
                                <input type="text" 
                                       wire:model="display_name"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="Nome visualizzato">
                                @error('display_name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.roles.description') }}
                                </label>
                                <textarea wire:model="description"
                                          rows="3"
                                          class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                          placeholder="Descrizione del ruolo"></textarea>
                                @error('description') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.roles.permissions') }}
                                </label>
                                @if(empty($this->permissionGroups))
                                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('admin.roles.no_permissions') }}</p>
                                @else
                                    <div class="border border-neutral-300 dark:border-neutral-600 rounded-lg p-4 max-h-64 overflow-y-auto bg-white dark:bg-neutral-700">
                                        @foreach($this->permissionGroups as $group => $perms)
                                            <div class="mb-4 last:mb-0">
                                                <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">{{ ucfirst($group ?: 'general') }}</h4>
                                                <div class="space-y-2">
                                                    @foreach($perms as $permission)
                                                        <label class="flex items-center">
                                                            <input type="checkbox" 
                                                                   wire:model="permissions"
                                                                   value="{{ $permission->id }}"
                                                                   class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                                                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">
                                                                {{ $permission->display_name ?? $permission->name }}
                                                            </span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @error('permissions') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end gap-3 mt-6">
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                                {{ __('admin.roles.cancel') }}
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                {{ __('admin.roles.save') }}
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

