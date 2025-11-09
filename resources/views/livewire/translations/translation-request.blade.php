<div>
    <!-- Pulsante Richiedi Traduzione -->
    <button wire:click="openModal"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl
                   bg-gradient-to-r from-primary-500 to-primary-600
                   hover:from-primary-600 hover:to-primary-700
                   text-white font-semibold shadow-lg hover:shadow-xl
                   hover:-translate-y-1 transition-all duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
        </svg>
        <span class="font-poem">{{ __('translations.request_translation') }}</span>
    </button>
    
    <!-- Modal Richiesta Traduzione -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-md z-50 flex items-center justify-center p-4 animate-fade-in"
             @click.self="$wire.closeModal()">
            
            <div class="relative max-w-2xl w-full"
                 style="transform: perspective(1200px) rotateX(1deg);">
                
                <!-- FOGLIO VINTAGE -->
                <div class="relative vintage-paper-sheet-card overflow-visible">
                    <!-- Angolo piegato -->
                    <div class="vintage-corner-card"></div>
                    
                    <!-- Texture + Macchie -->
                    <div class="vintage-texture-card"></div>
                    <div class="vintage-stains-card"></div>
                    
                    <!-- Contenuto -->
                    <div class="relative z-10 p-8 md:p-10">
                        
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div class="p-3 rounded-xl bg-primary-100 dark:bg-primary-900/30">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100 font-poem">
                                        {{ __('translations.request_translation') }}
                                    </h2>
                                    <p class="text-sm text-neutral-600 dark:text-neutral-400 italic font-poem">
                                        "{{ $poem->title ?: __('poems.untitled') }}"
                                    </p>
                                </div>
                            </div>
                            <button type="button" 
                                    wire:click="closeModal"
                                    class="p-2 rounded-xl hover:bg-neutral-200/50 dark:hover:bg-neutral-700/50 
                                           transition-all duration-200 hover:rotate-90">
                                <svg class="w-6 h-6 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Form -->
                        <form wire:submit.prevent="submit" class="space-y-6">
                            
                            <!-- Lingua Target -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                    {{ __('translations.target_language') }} <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="targetLanguage"
                                        class="w-full appearance-none px-4 py-3 rounded-2xl 
                                               bg-white dark:bg-neutral-800 
                                               border-2 border-neutral-200 dark:border-neutral-700
                                               text-neutral-900 dark:text-white
                                               focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                               transition-all duration-200 cursor-pointer font-medium">
                                    <option value="">{{ __('common.select') }} {{ __('translations.language') }}</option>
                                    @foreach($availableLanguages as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('targetLanguage')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Compenso Proposto -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                    {{ __('translations.proposed_compensation') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500 font-bold">€</span>
                                    <input wire:model="proposedCompensation"
                                           type="number"
                                           step="0.01"
                                           min="0"
                                           placeholder="50.00"
                                           class="w-full pl-8 pr-4 py-3 rounded-2xl 
                                                  bg-white dark:bg-neutral-800 
                                                  border-2 border-neutral-200 dark:border-neutral-700
                                                  text-neutral-900 dark:text-white
                                                  focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                                  transition-all duration-200 font-medium">
                                </div>
                                @error('proposedCompensation')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Scadenza (opzionale) -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                    {{ __('translations.deadline') }} <span class="text-neutral-400">({{ __('common.optional') }})</span>
                                </label>
                                <input wire:model="deadline"
                                       type="date"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-4 py-3 rounded-2xl 
                                              bg-white dark:bg-neutral-800 
                                              border-2 border-neutral-200 dark:border-neutral-700
                                              text-neutral-900 dark:text-white
                                              focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                              transition-all duration-200 font-medium">
                                @error('deadline')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Requisiti (opzionale) -->
                            <div>
                                <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                                    {{ __('translations.requirements') }} <span class="text-neutral-400">({{ __('common.optional') }})</span>
                                </label>
                                <textarea wire:model="requirements"
                                          rows="4"
                                          placeholder="{{ __('translations.requirements_placeholder') }}"
                                          class="w-full px-4 py-3 rounded-2xl 
                                                 bg-white dark:bg-neutral-800 
                                                 border-2 border-neutral-200 dark:border-neutral-700
                                                 text-neutral-900 dark:text-white
                                                 focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20
                                                 transition-all duration-200 font-poem
                                                 resize-none placeholder:italic"></textarea>
                                @error('requirements')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Divisore calligrafico -->
                            <div class="flex items-center justify-center my-6">
                                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-neutral-400/30 to-neutral-400/15"></div>
                                <div class="px-4 text-neutral-500/50 text-xl">❦</div>
                                <div class="flex-1 h-px bg-gradient-to-l from-transparent via-neutral-400/30 to-neutral-400/15"></div>
                            </div>
                            
                            <!-- Pulsanti -->
                            <div class="flex items-center justify-end gap-4">
                                <button type="button"
                                        wire:click="closeModal"
                                        class="px-6 py-3 rounded-2xl font-medium
                                               bg-neutral-100 dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300
                                               hover:bg-neutral-200 dark:hover:bg-neutral-600
                                               transition-all duration-200">
                                    {{ __('common.cancel') }}
                                </button>
                                
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        class="px-8 py-3 rounded-2xl font-bold
                                               bg-gradient-to-r from-primary-500 to-primary-600
                                               hover:from-primary-600 hover:to-primary-700
                                               text-white shadow-xl hover:shadow-2xl
                                               hover:-translate-y-1
                                               transition-all duration-300
                                               disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove>{{ __('translations.create_request') }}</span>
                                    <span wire:loading>{{ __('common.loading') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
