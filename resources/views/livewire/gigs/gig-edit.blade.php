<div class="min-h-screen bg-gradient-to-br from-neutral-50 via-primary-50/30 to-neutral-50 dark:from-neutral-900 dark:via-primary-950/20 dark:to-neutral-900">
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 dark:text-white mb-2">
                {{ __('gigs.edit_gig') }}
            </h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">
                {{ __('gigs.edit_description') }}
            </p>
        </div>

        <!-- Form Card -->
        <div class="backdrop-blur-xl bg-white/80 dark:bg-neutral-800/80 rounded-3xl shadow-2xl border border-white/20 dark:border-neutral-700/50 p-8">
            
            <form wire:submit.prevent="save" class="space-y-6">
                
                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.title') }} *
                    </label>
                    <input type="text" 
                           wire:model="title"
                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                           placeholder="{{ __('gigs.placeholders.title') }}">
                    @error('title') 
                        <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.description') }} *
                    </label>
                    <textarea wire:model="description" 
                              rows="6"
                              class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                              placeholder="{{ __('gigs.placeholders.description') }}"></textarea>
                    @error('description') 
                        <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Requirements -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.requirements') }}
                    </label>
                    <textarea wire:model="requirements" 
                              rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                              placeholder="{{ __('gigs.placeholders.requirements') }}"></textarea>
                    @error('requirements') 
                        <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Category & Type -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('gigs.fields.category') }} *
                        </label>
                        <select wire:model="category"
                                class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="">{{ __('gigs.select_category') }}</option>
                            <option value="performance">{{ __('gigs.categories.performance') }}</option>
                            <option value="hosting">{{ __('gigs.categories.hosting') }}</option>
                            <option value="judging">{{ __('gigs.categories.judging') }}</option>
                            <option value="technical">{{ __('gigs.categories.technical') }}</option>
                            <option value="translation">{{ __('gigs.categories.translation') }}</option>
                            <option value="other">{{ __('gigs.categories.other') }}</option>
                        </select>
                        @error('category') 
                            <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('gigs.fields.type') }} *
                        </label>
                        <select wire:model="type"
                                class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="">{{ __('gigs.select_type') }}</option>
                            <option value="paid">{{ __('gigs.types.paid') }}</option>
                            <option value="volunteer">{{ __('gigs.types.volunteer') }}</option>
                            <option value="collaboration">{{ __('gigs.types.collaboration') }}</option>
                        </select>
                        @error('type') 
                            <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <!-- Compensation & Deadline -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('gigs.fields.compensation') }}
                        </label>
                        <input type="text" 
                               wire:model="compensation"
                               class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                               placeholder="{{ __('gigs.placeholders.compensation') }}">
                        @error('compensation') 
                            <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('gigs.fields.deadline') }}
                        </label>
                        <input type="datetime-local" 
                               wire:model="deadline"
                               class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                        @error('deadline') 
                            <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <!-- Location & Language -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('gigs.fields.location') }}
                        </label>
                        <input type="text" 
                               wire:model="location"
                               class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                               placeholder="{{ __('gigs.placeholders.location') }}">
                        @error('location') 
                            <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('gigs.fields.language') }}
                        </label>
                        <select wire:model="language"
                                class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                            <option value="">{{ __('gigs.select_language') }}</option>
                            <option value="it">{{ __('gigs.languages.it') }}</option>
                            <option value="en">{{ __('gigs.languages.en') }}</option>
                            <option value="es">{{ __('gigs.languages.es') }}</option>
                            <option value="fr">{{ __('gigs.languages.fr') }}</option>
                            <option value="de">{{ __('gigs.languages.de') }}</option>
                            <option value="pt">{{ __('gigs.languages.pt') }}</option>
                        </select>
                        @error('language') 
                            <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <!-- Checkboxes -->
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               wire:model="is_remote"
                               class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            {{ __('gigs.fields.is_remote') }}
                        </span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" 
                               wire:model="is_urgent"
                               class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                        <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                            {{ __('gigs.fields.is_urgent') }}
                        </span>
                    </label>

                    @if(auth()->user()->hasRole('admin'))
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   wire:model="is_featured"
                                   class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                            <span class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                {{ __('gigs.fields.is_featured') }}
                            </span>
                        </label>
                    @endif
                </div>

                <!-- Max Applications -->
                <div>
                    <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('gigs.fields.max_applications') }}
                    </label>
                    <input type="number" 
                           wire:model="max_applications"
                           min="1"
                           max="100"
                           class="w-full px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                           placeholder="{{ __('gigs.unlimited') }}">
                    @error('max_applications') 
                        <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6">
                    <button type="submit"
                            class="flex-1 px-6 py-4 rounded-xl bg-primary-600 hover:bg-primary-700 text-white font-semibold text-lg transition-colors">
                        {{ __('common.save') }}
                    </button>

                    <a href="{{ route('gigs.show', $gig) }}"
                       class="px-6 py-4 rounded-xl bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold text-lg transition-colors">
                        {{ __('gigs.cancel') }}
                    </a>
                </div>

            </form>

        </div>

    </div>
</div>
