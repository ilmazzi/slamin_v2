<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('groups.index') }}" wire:navigate
               class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Torna ai gruppi
            </a>
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Crea Nuovo Gruppo</h1>
            <p class="text-neutral-600 dark:text-neutral-400 mt-2">Crea un gruppo per riunire persone con interessi comuni</p>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="bg-white dark:bg-neutral-900 rounded-2xl shadow-lg p-6 md:p-8 space-y-6">
            {{-- Nome --}}
            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Nome Gruppo *
                </label>
                <input type="text" wire:model="name"
                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Descrizione --}}
            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Descrizione
                </label>
                <textarea wire:model="description" rows="4"
                          class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"></textarea>
                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Immagine --}}
            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Immagine Gruppo
                </label>
                <input type="file" wire:model="image" accept="image/*"
                       class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                @if($image)
                    <img src="{{ $image->temporaryUrl() }}" class="mt-4 w-32 h-32 object-cover rounded-xl">
                @endif
            </div>

            {{-- Visibilità --}}
            <div>
                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                    Visibilità *
                </label>
                <select wire:model="visibility"
                        class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    <option value="public">Pubblico - Chiunque può unirsi</option>
                    <option value="private">Privato - Richiede approvazione</option>
                </select>
                @error('visibility') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Social Links --}}
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-6">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">Link Social (Opzionali)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Website</label>
                        <input type="url" wire:model="website" placeholder="https://"
                               class="w-full px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Facebook</label>
                        <input type="url" wire:model="social_facebook" placeholder="https://"
                               class="w-full px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Instagram</label>
                        <input type="url" wire:model="social_instagram" placeholder="https://"
                               class="w-full px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">YouTube</label>
                        <input type="url" wire:model="social_youtube" placeholder="https://"
                               class="w-full px-4 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-4 pt-6">
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                    Crea Gruppo
                </button>
                <a href="{{ route('groups.index') }}" wire:navigate
                   class="px-6 py-3 bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 rounded-xl font-semibold hover:bg-neutral-300 dark:hover:bg-neutral-700 transition-colors">
                    Annulla
                </a>
            </div>
        </form>
    </div>
</div>
