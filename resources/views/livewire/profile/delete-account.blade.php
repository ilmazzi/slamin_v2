<div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Warning Header -->
            <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="text-4xl">⚠️</div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-red-900 dark:text-red-100 mb-2">
                            {{ __('account_deletion.warning_title') }}
                        </h1>
                        <p class="text-red-800 dark:text-red-200 leading-relaxed">
                            {{ __('account_deletion.warning_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-neutral-900 rounded-xl shadow-lg border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                
                <!-- What will happen -->
                <div class="p-6 md:p-8 border-b border-neutral-200 dark:border-neutral-800">
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
                        {{ __('account_deletion.what_happens_title') }}
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <span class="text-xl">🔒</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                {{ __('account_deletion.what_happens_1') }}
                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">🎥</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                {{ __('account_deletion.what_happens_2') }}
                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">📝</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                {{ __('account_deletion.what_happens_3') }}
                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">💬</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                {{ __('account_deletion.what_happens_4') }}
                            </p>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <span class="text-xl">⏰</span>
                            <p class="text-neutral-700 dark:text-neutral-300">
                                {{ __('account_deletion.what_happens_5') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Deletion Form -->
                <form wire:submit.prevent="deleteAccount" class="p-6 md:p-8 space-y-6">
                    
                    <!-- Reason (Optional) -->
                    <div>
                        <label for="reason" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('account_deletion.reason_label') }}
                            <span class="text-neutral-500 dark:text-neutral-400 font-normal">
                                ({{ __('account_deletion.optional') }})
                            </span>
                        </label>
                        <textarea 
                            wire:model="reason" 
                            id="reason"
                            rows="4"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-neutral-900 dark:text-white"
                            placeholder="{{ __('account_deletion.reason_placeholder') }}"
                        ></textarea>
                        <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                            {{ __('account_deletion.reason_help') }}
                        </p>
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('account_deletion.password_label') }} *
                        </label>
                        <input 
                            type="password" 
                            wire:model="password" 
                            id="password"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-neutral-900 dark:text-white"
                            placeholder="{{ __('account_deletion.password_placeholder') }}"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmation Text -->
                    <div>
                        <label for="confirmText" class="block text-sm font-semibold text-neutral-900 dark:text-white mb-2">
                            {{ __('account_deletion.confirm_label') }} *
                        </label>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 mb-3">
                            {!! __('account_deletion.confirm_help') !!}
                        </p>
                        <input 
                            type="text" 
                            wire:model="confirmText" 
                            id="confirmText"
                            class="w-full px-4 py-3 bg-neutral-50 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-neutral-900 dark:text-white font-mono text-lg"
                            placeholder="ELIMINA"
                        >
                        @error('confirmText')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <a 
                            href="{{ route('profile.edit') }}" 
                            class="flex-1 px-6 py-3 text-center bg-neutral-200 dark:bg-neutral-800 hover:bg-neutral-300 dark:hover:bg-neutral-700 text-neutral-900 dark:text-white font-semibold rounded-lg transition-colors"
                        >
                            {{ __('account_deletion.cancel') }}
                        </a>
                        
                        <button 
                            type="submit"
                            class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors shadow-lg"
                        >
                            {{ __('account_deletion.delete_button') }}
                        </button>
                    </div>

                    <p class="text-xs text-neutral-500 dark:text-neutral-400 text-center">
                        {{ __('account_deletion.gdpr_note') }}
                    </p>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 text-center">
                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                    {{ __('account_deletion.need_help') }}
                    <a href="mailto:mail@slamin.it" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold">
                        mail@slamin.it
                    </a>
                </p>
            </div>
        </div>
    </div>
