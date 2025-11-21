<div class="p-6">
    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">{{ __('admin.settings.payment.title') }}</h1>
    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ __('admin.settings.payment.description') }}</p>

    <form wire:submit="updateSettings">
        <div class="bg-white dark:bg-neutral-800 rounded-lg shadow border border-neutral-200 dark:border-neutral-700 overflow-hidden">
            <div class="p-6">
                {{-- Commissioni --}}
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.settings.payment.commissions') }}</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.translation_commission_rate') }}
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model="settings.translation_commission_rate"
                                       step="0.01"
                                       min="0"
                                       max="1"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="0.10">
                                <span class="absolute right-3 top-2.5 text-neutral-500 dark:text-neutral-400">%</span>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                                {{ __('admin.settings.payment.commission_rate_hint') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.translation_commission_fixed') }}
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       wire:model="settings.translation_commission_fixed"
                                       step="0.01"
                                       min="0"
                                       class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="0.00">
                                <span class="absolute right-3 top-2.5 text-neutral-500 dark:text-neutral-400">€</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stripe --}}
                <div class="mb-8 border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.settings.payment.stripe') }}</h2>
                    <div class="space-y-4">
                        <div>
                                <label class="inline-flex items-center mb-4 cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model="settings.stripe_enabled"
                                           value="1"
                                           @if(($settings['stripe_enabled'] ?? '') === '1' || ($settings['stripe_enabled'] ?? '') === 'true' || ($settings['stripe_enabled'] ?? false)) checked @endif
                                           class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                                    <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        {{ __('admin.settings.payment.stripe_enabled') }}
                                    </span>
                                </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.stripe_mode') }}
                            </label>
                            <select wire:model="settings.stripe_mode" 
                                    class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="test">{{ __('admin.settings.payment.test_mode') }}</option>
                                <option value="live">{{ __('admin.settings.payment.live_mode') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.stripe_public_key') }}
                            </label>
                            <input type="text" 
                                   wire:model="settings.stripe_public_key"
                                   class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                   placeholder="pk_test_...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.stripe_secret_key') }}
                            </label>
                            <input type="password" 
                                   wire:model="settings.stripe_secret_key"
                                   class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                   placeholder="sk_test_...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.stripe_webhook_secret') }}
                            </label>
                            <input type="password" 
                                   wire:model="settings.stripe_webhook_secret"
                                   class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                   placeholder="whsec_...">
                        </div>
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       wire:model="settings.stripe_connect_enabled"
                                       value="1"
                                       @if(($settings['stripe_connect_enabled'] ?? '') === '1' || ($settings['stripe_connect_enabled'] ?? '') === 'true' || ($settings['stripe_connect_enabled'] ?? false)) checked @endif
                                       class="sr-only peer">
                                <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                                <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                    {{ __('admin.settings.payment.stripe_connect_enabled') }}
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- PayPal --}}
                <div class="mb-8 border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.settings.payment.paypal') }}</h2>
                    <div class="space-y-4">
                        <div>
                                <label class="inline-flex items-center mb-4 cursor-pointer">
                                    <input type="checkbox" 
                                           wire:model="settings.paypal_enabled"
                                           value="1"
                                           @if(($settings['paypal_enabled'] ?? '') === '1' || ($settings['paypal_enabled'] ?? '') === 'true' || ($settings['paypal_enabled'] ?? false)) checked @endif
                                           class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-primary-600"></div>
                                    <span class="ml-3 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                        {{ __('admin.settings.payment.paypal_enabled') }}
                                    </span>
                                </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.paypal_mode') }}
                            </label>
                            <select wire:model="settings.paypal_mode" 
                                    class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="sandbox">{{ __('admin.settings.payment.sandbox_mode') }}</option>
                                <option value="live">{{ __('admin.settings.payment.live_mode') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.paypal_client_id') }}
                            </label>
                            <input type="text" 
                                   wire:model="settings.paypal_client_id"
                                   class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                   placeholder="Client ID">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                                {{ __('admin.settings.payment.paypal_client_secret') }}
                            </label>
                            <input type="password" 
                                   wire:model="settings.paypal_client_secret"
                                   class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                   placeholder="Client Secret">
                        </div>
                    </div>
                </div>

                {{-- Metodi di pagamento abilitati --}}
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-6">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-white mb-4">{{ __('admin.settings.payment.payment_methods') }}</h2>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            {{ __('admin.settings.payment.payment_methods_enabled') }}
                        </label>
                        <textarea wire:model="settings.payment_methods_enabled"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-sm"
                                  placeholder='["stripe", "paypal"]'></textarea>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                            {{ __('admin.settings.payment.json_format_hint') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="px-6 py-4 bg-neutral-50 dark:bg-neutral-700/50 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                <button type="button" 
                        wire:click="resetSettings" 
                        wire:confirm="{{ __('admin.settings.payment.reset_confirm') }}"
                        class="px-4 py-2 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-700 rounded-lg transition-colors">
                    {{ __('admin.settings.payment.reset') }}
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    {{ __('admin.settings.payment.save') }}
                </button>
            </div>
        </div>
    </form>

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
