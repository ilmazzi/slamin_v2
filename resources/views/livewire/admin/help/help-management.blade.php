<div class="p-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black text-neutral-900 dark:text-white mb-2" style="font-family: 'Crimson Pro', serif;">
            {{ __('admin.help.title') }}
        </h1>
        <p class="text-lg text-neutral-600 dark:text-neutral-400">{{ __('admin.help.description') }}</p>
    </div>

    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-xl">
            <p class="text-green-800 dark:text-green-400 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Controls --}}
    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            {{-- Filter Type --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    Tipo
                </label>
                <select wire:model.live="filterType" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                    <option value="all">Tutti</option>
                    <option value="faq">FAQ</option>
                    <option value="help">Help</option>
                </select>
            </div>

            {{-- Filter Locale --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    Lingua
                </label>
                <select wire:model.live="filterLocale" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                    <option value="all">Tutte</option>
                    @foreach($languages as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Search --}}
            <div>
                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                    🔍 Cerca
                </label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Cerca titolo, contenuto o categoria..."
                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
            </div>

            {{-- Add Button --}}
            <div class="flex items-end">
                <button wire:click="openModal()" 
                        class="w-full px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                    ➕ {{ __('admin.help.add') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Help/FAQ List --}}
    <div class="space-y-4">
        @forelse($helps as $help)
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $help->type === 'faq' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' }}">
                                {{ strtoupper($help->type) }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                {{ strtoupper($help->locale) }}
                            </span>
                            @if($help->category)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300">
                                    {{ $help->category }}
                                </span>
                            @endif
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $help->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300' }}">
                                {{ $help->is_active ? 'Attivo' : 'Inattivo' }}
                            </span>
                            <span class="text-xs text-neutral-500">Ordine: {{ $help->order }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">{{ $help->title }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($help->content), 150) }}</p>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <button wire:click="openModal({{ $help->id }})" 
                                class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors text-sm">
                            ✏️ Modifica
                        </button>
                        <button wire:click="toggleActive({{ $help->id }})" 
                                class="px-4 py-2 {{ $help->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-bold rounded-xl transition-colors text-sm">
                            {{ $help->is_active ? '⏸️ Disattiva' : '▶️ Attiva' }}
                        </button>
                        <button wire:click="delete({{ $help->id }})" 
                                wire:confirm="Sei sicuro di voler eliminare questo elemento?"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors text-sm">
                            🗑️ Elimina
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Nessun elemento trovato</h3>
                <p class="text-neutral-600 dark:text-neutral-400">
                    @if(!empty($search))
                        Prova a modificare i criteri di ricerca
                    @else
                        Clicca su "Aggiungi" per creare il primo elemento
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($helps->hasPages())
        <div class="mt-6">
            {{ $helps->links() }}
        </div>
    @endif

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closeModal">
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">
                            {{ $editingId ? __('admin.help.edit') : __('admin.help.create') }}
                        </h2>
                        <button wire:click="closeModal" class="text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                {{-- Type --}}
                                <div>
                                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                        Tipo *
                                    </label>
                                    <select wire:model="type" 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                                        <option value="faq">FAQ</option>
                                        <option value="help">Help</option>
                                    </select>
                                    @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                {{-- Locale --}}
                                <div>
                                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                        Lingua *
                                    </label>
                                    <select wire:model="locale" 
                                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                                        @foreach($languages as $code => $name)
                                            <option value="{{ $code }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('locale') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Title --}}
                            <div>
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    Titolo *
                                </label>
                                <input type="text" 
                                       wire:model="title"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            {{-- Content --}}
                            <div>
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    Contenuto *
                                </label>
                                <textarea wire:model="content" 
                                          rows="8"
                                          class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium"></textarea>
                                @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            {{-- Category --}}
                            <div>
                                <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                    Categoria (opzionale)
                                </label>
                                <input type="text" 
                                       wire:model="category"
                                       placeholder="Es: account, poems, events"
                                       class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                                @error('category') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            {{-- Order --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                        Ordine
                                    </label>
                                    <input type="number" 
                                           wire:model="order"
                                           min="0"
                                           class="w-full px-4 py-3 rounded-xl border-2 border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white font-medium">
                                    @error('order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                {{-- Active --}}
                                <div>
                                    <label class="block text-sm font-bold text-neutral-700 dark:text-neutral-300 mb-2">
                                        Stato
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model="isActive"
                                               class="w-5 h-5 text-primary-600 border-neutral-300 rounded">
                                        <span class="text-neutral-700 dark:text-neutral-300">Attivo</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 justify-end mt-6">
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="px-5 py-2.5 bg-neutral-600 hover:bg-neutral-700 text-white font-bold rounded-xl transition-colors">
                                Annulla
                            </button>
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors">
                                💾 Salva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

