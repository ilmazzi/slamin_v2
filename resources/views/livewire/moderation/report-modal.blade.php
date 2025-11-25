<div x-data="{ 
    show: @entangle('showModal'),
    reason: @entangle('reason'),
    description: @entangle('description')
}"
     x-show="show"
     @open-report-modal.window="
        $wire.itemId = $event.detail.itemId;
        $wire.itemType = $event.detail.itemType;
        $wire.showModal = true;
     "
     x-cloak
     class="fixed inset-0 z-[9999] overflow-y-auto"
     style="display: none;">
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$wire.closeModal()">
    </div>

    <!-- Modal -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-neutral-900 rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.stop>
            
            <!-- Header -->
            <div class="bg-gradient-to-br from-red-500 to-red-600 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">
                                {{ __('report.modal_title') }}
                            </h3>
                            <p class="text-white/80 text-sm">
                                {{ __('report.modal_subtitle') }}
                            </p>
                        </div>
                    </div>
                    <button @click="$wire.closeModal()" 
                            class="text-white/80 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form wire:submit.prevent="submitReport">
                    <!-- Motivo -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">
                            {{ __('report.select_reason') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            @foreach($reasons as $value => $label)
                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all hover:bg-neutral-50 dark:hover:bg-neutral-800"
                                   :class="reason === '{{ $value }}' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-neutral-200 dark:border-neutral-700'">
                                <input type="radio" 
                                       wire:model="reason" 
                                       value="{{ $value }}"
                                       class="w-4 h-4 text-red-600 focus:ring-red-500 focus:ring-offset-0">
                                <div>
                                    <div class="font-medium text-neutral-900 dark:text-white">
                                        {{ $label }}
                                    </div>
                                    <div class="text-xs text-neutral-600 dark:text-neutral-400">
                                        {{ __('report.reasons.' . $value . '_desc') }}
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('reason')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrizione (opzionale) -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('report.additional_details') }}
                            <span class="text-neutral-500 font-normal">({{ __('common.optional') }})</span>
                        </label>
                        <textarea 
                            wire:model="description"
                            id="description"
                            rows="3"
                            placeholder="{{ __('report.description_placeholder') }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white placeholder-neutral-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all"
                            maxlength="1000"></textarea>
                        <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                            {{ __('report.max_characters', ['max' => 1000]) }}
                        </p>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button type="button"
                                @click="$wire.closeModal()"
                                class="flex-1 px-6 py-3 bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-semibold rounded-xl hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                            {{ __('common.cancel') }}
                        </button>
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="flex-1 px-6 py-3 bg-gradient-to-br from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="submitReport">
                                {{ __('report.submit') }}
                            </span>
                            <span wire:loading wire:target="submitReport" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('common.loading') }}
                            </span>
                        </button>
                    </div>

                    <!-- Info -->
                    <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                        <p class="text-xs text-blue-800 dark:text-blue-300">
                            ℹ️ {{ __('report.info_message') }}
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

