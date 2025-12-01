<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Categorie Poesie</h1>
                    <p class="mt-2 text-neutral-600 dark:text-neutral-400">Gestisci le categorie delle poesie del sito</p>
                </div>
                <button wire:click="openCreateModal" 
                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                    + Nuova Categoria
                </button>
            </div>
        </div>

        <!-- Messages -->
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-green-800 dark:text-green-200">{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Search -->
        <div class="mb-6">
            <input type="text" 
                   wire:model.live="search"
                   placeholder="Cerca per slug..."
                   class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white">
        </div>

        <!-- Categories Table -->
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Categoria
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Ordine
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Poesie
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Stato
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Azioni
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-lg" 
                                         style="background-color: {{ $category->color }}">
                                        @php
                                            $icon = $category->attributes['icon'] ?? $category->getOriginal('icon') ?? null;
                                        @endphp
                                        @if(!empty($icon))
                                            <span class="text-xl leading-none">{{ $icon }}</span>
                                        @else
                                            <span class="text-sm">{{ strtoupper(substr($category->display_name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                            {{ $category->display_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="text-xs text-neutral-600 dark:text-neutral-400">{{ $category->slug }}</code>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-neutral-900 dark:text-white">{{ $category->sort_order }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-neutral-900 dark:text-white">{{ $category->poems()->count() }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleActive({{ $category->id }})"
                                        class="px-2 py-1 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ $category->is_active ? 'Attiva' : 'Disattiva' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openEditModal({{ $category->id }})" 
                                        class="text-primary-600 hover:text-primary-900 dark:text-primary-400 mr-3">
                                    Modifica
                                </button>
                                <button wire:click="delete({{ $category->id }})" 
                                        onclick="return confirm('Sei sicuro di voler eliminare questa categoria?')"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400">
                                    Elimina
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-[999999] overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-neutral-500 bg-opacity-75 dark:bg-opacity-90" wire:click="closeModal"></div>

                <div class="relative inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-neutral-800 shadow-xl rounded-2xl">
                    <h3 class="text-lg font-medium leading-6 text-neutral-900 dark:text-white mb-4">
                        {{ $editingId ? 'Modifica Categoria' : 'Nuova Categoria' }}
                    </h3>

                    <form wire:submit.prevent="save">
                        <div class="space-y-6">
                            
                            <!-- Nome -->
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        Nome (IT) *
                                    </label>
                                    <input type="text" wire:model="name_it" 
                                           class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white">
                                    @error('name_it') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        Nome (EN)
                                    </label>
                                    <input type="text" wire:model="name_en" 
                                           class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        Nome (FR)
                                    </label>
                                    <input type="text" wire:model="name_fr" 
                                           class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Slug -->
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    Slug *
                                </label>
                                <input type="text" wire:model="slug" 
                                       class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white">
                                @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Colore e Icona -->
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        Colore *
                                    </label>
                                    <input type="color" wire:model="color" 
                                           class="mt-1 block w-full h-10 rounded-md border-neutral-300 dark:border-neutral-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        Icona
                                    </label>
                                    <input type="text" wire:model="icon" placeholder="emoji o simbolo"
                                           class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        Ordine
                                    </label>
                                    <input type="number" wire:model="sort_order" 
                                           class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white">
                                </div>
                            </div>

                            <!-- Attiva -->
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="is_active" 
                                       class="rounded border-neutral-300 text-primary-600 focus:ring-primary-500">
                                <label class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">
                                    Categoria attiva
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" wire:click="closeModal" 
                                    class="px-4 py-2 bg-neutral-200 dark:bg-neutral-700 text-neutral-900 dark:text-white rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600">
                                Annulla
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                                Salva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
