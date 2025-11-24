<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.users.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.users.description') }}</p>

    {{-- Statistiche --}}
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.users.total') }}</p>
            <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ $this->stats['total'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.users.active') }}</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $this->stats['active'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.users.inactive') }}</p>
            <p class="text-2xl font-bold text-neutral-600 dark:text-neutral-400">{{ $this->stats['inactive'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.users.suspended') }}</p>
            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $this->stats['suspended'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.users.banned') }}</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $this->stats['banned'] }}</p>
        </div>
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow p-4 border border-neutral-200 dark:border-neutral-700">
            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">{{ __('admin.users.admins') }}</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $this->stats['admins'] }}</p>
        </div>
    </div>

    {{-- Filtri e ricerca --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow mb-6 p-4 border border-neutral-200 dark:border-neutral-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.users.search') }}
                </label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="{{ __('admin.users.search_placeholder') }}"
                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.users.status') }}
                </label>
                <select wire:model.live="status" 
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">{{ __('admin.users.all_statuses') }}</option>
                    <option value="active">{{ __('admin.users.active') }}</option>
                    <option value="inactive">{{ __('admin.users.inactive') }}</option>
                    <option value="suspended">{{ __('admin.users.suspended') }}</option>
                    <option value="banned">{{ __('admin.users.banned') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                    {{ __('admin.users.role') }}
                </label>
                <select wire:model.live="role" 
                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="all">{{ __('admin.users.all_roles') }}</option>
                    <option value="admin">{{ __('admin.users.role_admin') }}</option>
                    <option value="poet">{{ __('admin.users.role_poet') }}</option>
                    <option value="organizer">{{ __('admin.users.role_organizer') }}</option>
                    <option value="judge">{{ __('admin.users.role_judge') }}</option>
                    <option value="venue_owner">{{ __('admin.users.role_venue_owner') }}</option>
                    <option value="technician">{{ __('admin.users.role_technician') }}</option>
                    <option value="audience">{{ __('admin.users.role_audience') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Pulsante Crea Utente --}}
    <div class="mb-6 flex justify-end">
        <button wire:click="openCreateModal"
                class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg shadow-lg transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('admin.users.create_user') }}
        </button>
    </div>

    {{-- Tabella utenti --}}
    <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-50 dark:bg-neutral-700/50 border-b border-neutral-200 dark:border-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors"
                            wire:click="sortByColumn('name')">
                            <div class="flex items-center gap-2">
                                {{ __('admin.users.name') }}
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors"
                            wire:click="sortByColumn('email')">
                            <div class="flex items-center gap-2">
                                {{ __('admin.users.email') }}
                                @if($sortBy === 'email')
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
                            {{ __('admin.users.roles') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.users.status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider cursor-pointer hover:bg-neutral-100 dark:hover:bg-neutral-700 transition-colors"
                            wire:click="sortByColumn('created_at')">
                            <div class="flex items-center gap-2">
                                {{ __('admin.users.registered') }}
                                @if($sortBy === 'created_at')
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
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            {{ __('admin.users.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-primary-600 dark:text-primary-400 font-medium text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                            {{ $user->name }}
                                        </div>
                                        @if($user->nickname)
                                            <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                                @{{ $user->nickname }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-white">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->getRoleNames() as $role)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($role === 'admin') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                            @elseif($role === 'poet') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($role === 'organizer') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                            @else bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-300
                                            @endif">
                                            {{ ucfirst($role) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = $user->status ?? 'active';
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($status === 'suspended') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @elseif($status === 'banned') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @else bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-300
                                    @endif">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="openEditModal({{ $user->id }})" 
                                            class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 transition-colors"
                                            title="{{ __('admin.users.edit') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteUser({{ $user->id }})" 
                                            wire:confirm="{{ __('admin.users.delete_confirm') }}"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors"
                                            title="{{ __('admin.users.delete') }}">
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
                                <p class="text-neutral-500 dark:text-neutral-400">{{ __('admin.users.no_users_found') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal modifica --}}
    @if($showEditModal && $editingUser)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
             wire:click="closeEditModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
                 wire:click.stop>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                            {{ __('admin.users.edit_user') }}: {{ $editingUser->name }}
                        </h2>
                        <button wire:click="closeEditModal" class="text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Informazioni PeerTube --}}
                    @if($editingUser->hasPeerTubeAccount())
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="font-semibold text-green-900 dark:text-green-100">{{ __('admin.users.peertube_account') }}</span>
                            </div>
                            <div class="text-sm text-green-700 dark:text-green-300 space-y-1">
                                @if($editingUser->peertube_user_id)
                                    <p><strong>ID:</strong> {{ $editingUser->peertube_user_id }}</p>
                                @endif
                                @if($editingUser->peertube_username)
                                    <p><strong>Username:</strong> {{ $editingUser->peertube_username }}</p>
                                @endif
                                @if($editingUser->peertube_display_name)
                                    <p><strong>Display Name:</strong> {{ $editingUser->peertube_display_name }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-neutral-50 dark:bg-neutral-700/50 border border-neutral-200 dark:border-neutral-600 rounded-lg">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">{{ __('admin.users.no_peertube_account') }}</span>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Informazioni Account --}}
                    <div class="mb-6 p-4 bg-neutral-50 dark:bg-neutral-700/50 border border-neutral-200 dark:border-neutral-600 rounded-lg">
                        <h3 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">{{ __('admin.users.account_info') }}</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('admin.users.registered') }}:</span>
                                <span class="text-neutral-900 dark:text-white ml-2">{{ $editingUser->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('admin.users.email_verified') }}:</span>
                                @if($editingUser->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400 ml-2">{{ __('admin.users.yes') }} ({{ $editingUser->email_verified_at->format('d/m/Y') }})</span>
                                @else
                                    <span class="text-red-600 dark:text-red-400 ml-2">{{ __('admin.users.no') }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('admin.users.user_id') }}:</span>
                                <span class="text-neutral-900 dark:text-white ml-2">#{{ $editingUser->id }}</span>
                            </div>
                            <div>
                                <span class="text-neutral-500 dark:text-neutral-400">{{ __('admin.users.current_roles') }}:</span>
                                <span class="text-neutral-900 dark:text-white ml-2">
                                    @if($editingUser->roles->count() > 0)
                                        {{ $editingUser->roles->pluck('display_name')->join(', ') }}
                                    @else
                                        <span class="text-neutral-400">{{ __('admin.users.no_roles') }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <form wire:submit.prevent="updateUser">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.name') }} *
                                    </label>
                                    <input type="text" 
                                           wire:model="name"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.email') }} *
                                    </label>
                                    <input type="email" 
                                           wire:model="email"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('email') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.users.nickname') }}
                                </label>
                                <input type="text" 
                                       wire:model="nickname"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                @error('nickname') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.status') }} *
                                    </label>
                                    <select wire:model="userStatus"
                                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="active">{{ __('admin.users.active') }}</option>
                                        <option value="inactive">{{ __('admin.users.inactive') }}</option>
                                        <option value="suspended">{{ __('admin.users.suspended') }}</option>
                                        <option value="banned">{{ __('admin.users.banned') }}</option>
                                    </select>
                                    @error('userStatus') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.email_verification') }}
                                    </label>
                                    <div class="flex items-center gap-3 px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700">
                                        @if($emailVerified)
                                            <span class="text-sm text-green-600 dark:text-green-400">{{ __('admin.users.verified') }}</span>
                                            <button type="button" 
                                                    wire:click="toggleEmailVerification"
                                                    class="text-xs text-red-600 dark:text-red-400 hover:underline">
                                                {{ __('admin.users.unverify') }}
                                            </button>
                                        @else
                                            <span class="text-sm text-red-600 dark:text-red-400">{{ __('admin.users.not_verified') }}</span>
                                            <button type="button" 
                                                    wire:click="toggleEmailVerification"
                                                    class="text-xs text-green-600 dark:text-green-400 hover:underline">
                                                {{ __('admin.users.verify') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.users.roles') }}
                                </label>
                                @if($this->availableRoles->count() > 0)
                                    <select wire:model="roles" 
                                            multiple
                                            size="6"
                                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        @foreach($this->availableRoles as $role)
                                            <option value="{{ $role->id }}" {{ in_array($role->id, $roles ?? []) ? 'selected' : '' }}>
                                                {{ $role->display_name ?? ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ __('admin.users.select_multiple_roles') }}
                                    </p>
                                @else
                                    <div class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-sm">
                                        {{ __('admin.users.no_roles_available') }}
                                    </div>
                                @endif
                                @error('roles') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                            <button type="button" 
                                    wire:click="closeEditModal"
                                    class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                                {{ __('admin.users.cancel') }}
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                {{ __('admin.users.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal creazione utente --}}
    @if($showCreateModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4" 
             wire:click="closeCreateModal">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                 wire:click.stop>
                <div class="p-6">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        {{ __('admin.users.create_user') }}
                    </h2>
                    
                    <form wire:submit.prevent="createUser">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.name') }} *
                                    </label>
                                    <input type="text" 
                                           wire:model="name"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('name') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.email') }} *
                                    </label>
                                    <input type="email" 
                                           wire:model="email"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('email') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.users.nickname') }}
                                </label>
                                <input type="text" 
                                       wire:model="nickname"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                @error('nickname') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.password') }} *
                                    </label>
                                    <input type="password" 
                                           wire:model="password"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('password') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                        {{ __('admin.users.confirm_password') }} *
                                    </label>
                                    <input type="password" 
                                           wire:model="password_confirmation"
                                           class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.users.status') }} *
                                </label>
                                <select wire:model="userStatus"
                                        class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option value="active">{{ __('admin.users.active') }}</option>
                                    <option value="inactive">{{ __('admin.users.inactive') }}</option>
                                    <option value="suspended">{{ __('admin.users.suspended') }}</option>
                                    <option value="banned">{{ __('admin.users.banned') }}</option>
                                </select>
                                @error('userStatus') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                    {{ __('admin.users.roles') }}
                                </label>
                                @if($this->availableRoles->count() > 0)
                                    <select wire:model="roles" 
                                            multiple
                                            size="6"
                                            class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        @foreach($this->availableRoles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->display_name ?? ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                        {{ __('admin.users.select_multiple_roles') }}
                                    </p>
                                @else
                                    <div class="w-full px-4 py-3 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-neutral-50 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 text-sm">
                                        {{ __('admin.users.no_roles_available') }}
                                    </div>
                                @endif
                                @error('roles') <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model="verifyEmail"
                                           class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                    <span class="text-sm text-neutral-700 dark:text-neutral-300">
                                        {{ __('admin.users.verify_email') }}
                                    </span>
                                </label>
                                
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model="createPeerTubeAccount"
                                           class="w-4 h-4 text-primary-600 border-neutral-300 rounded focus:ring-primary-500">
                                    <span class="text-sm text-neutral-700 dark:text-neutral-300">
                                        {{ __('admin.users.create_peertube_account') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end gap-3 mt-6">
                            <button type="button" 
                                    wire:click="closeCreateModal"
                                    class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                                {{ __('admin.users.cancel') }}
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                {{ __('admin.users.create') }}
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
