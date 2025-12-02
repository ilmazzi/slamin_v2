<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentCompleted): ?>
            
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Pagamento Completato</h2>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">Il pagamento per questa traduzione è già stato effettuato.</p>
                <a href="<?php echo e(route('gigs.show', $application->gig)); ?>" 
                   class="inline-block px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                    Torna al Gig
                </a>
            </div>
        <?php else: ?>
            
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Pagamento Traduzione</h1>
                        <p class="text-neutral-600 dark:text-neutral-400"><?php echo e($application->gig->poem->title ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Riepilogo</h3>
                        
                        <div class="space-y-3 mb-4 pb-4 border-b border-neutral-200 dark:border-neutral-700">
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Traduttore:</span>
                                <span class="font-semibold text-neutral-900 dark:text-white"><?php echo e($application->user->name); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Poesia:</span>
                                <span class="font-semibold text-neutral-900 dark:text-white"><?php echo e(Str::limit($application->gig->poem->title ?? 'N/A', 20)); ?></span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between">
                                <span class="text-neutral-700 dark:text-neutral-300">Compenso traduttore:</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">€<?php echo e(number_format($commissionData['translator_amount'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Commissione servizio (<?php echo e(($commissionData['commission_rate'] * 100)); ?>%):</span>
                                <span class="text-neutral-700 dark:text-neutral-300">€<?php echo e(number_format($commissionData['platform_commission'], 2)); ?></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Costi di elaborazione:</span>
                                <span class="text-neutral-700 dark:text-neutral-300">€<?php echo e(number_format($commissionData['stripe_commission'], 2)); ?></span>
                            </div>
                        </div>

                        <div class="pt-4 border-t-2 border-neutral-300 dark:border-neutral-600">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-lg font-bold text-neutral-900 dark:text-white">Totale da pagare:</span>
                                <span class="text-2xl font-black text-primary-600 dark:text-primary-400">€<?php echo e(number_format($commissionData['total_amount'], 2)); ?></span>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                Il traduttore riceverà esattamente €<?php echo e(number_format($commissionData['translator_amount'], 2)); ?> come concordato
                            </p>
                        </div>
                    </div>
                </div>

                
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errorMessage): ?>
                            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                                <p class="text-red-800 dark:text-red-200"><?php echo e($errorMessage); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6">Metodo di Pagamento</h3>

                        
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-1">Metodi di pagamento accettati</h4>
                                    <div class="flex items-center gap-3 mt-2">
                                        <div class="flex items-center gap-1.5 text-sm text-blue-800 dark:text-blue-300">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.276 5.12-6.514 5.12h-.5a.805.805 0 00-.794.68l-.04.22-.63 3.993-.028.15a.805.805 0 01-.793.68H8.25c-.467 0-.825-.377-.745-.84l.014-.075L9.28 13.7a1.018 1.018 0 011.006-.862h2.095c3.1 0 5.522-1.26 6.226-4.904.086-.445.133-.89.133-1.327 0-.862-.172-1.619-.524-2.226a3.662 3.662 0 00-.82-.943 3.662 3.662 0 00-1.043-.668A5.186 5.186 0 0014.955 3h-5.21c-.467 0-.865.338-.944.802l-1.805 11.44a.805.805 0 00.794.92h2.85l.716-4.54.76-4.82a.944.944 0 01.932-.802h1.052c1.268 0 2.33.182 3.148.54.757.332 1.369.814 1.819 1.436z"/>
                                            </svg>
                                            PayPal
                                        </div>
                                        <div class="flex items-center gap-1.5 text-sm text-blue-800 dark:text-blue-300">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                            </svg>
                                            Google Pay
                                        </div>
                                        <div class="flex items-center gap-1.5 text-sm text-blue-800 dark:text-blue-300">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                            </svg>
                                            Apple Pay
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentMethod === 'stripe'): ?>
                            
                            <div id="stripe-payment-form">
                                <div id="payment-element" class="mb-6">
                                    <!-- Stripe Payment Element (include carte e PayPal) -->
                                </div>

                                <button type="button" 
                                        id="submit-payment"
                                        wire:loading.attr="disabled"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove>
                                        💳 Paga €<?php echo e(number_format($commissionData['total_amount'], 2)); ?>

                                    </span>
                                    <span wire:loading>
                                        <svg class="animate-spin inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Elaborazione...
                                    </span>
                                </button>

                                <div id="payment-message" class="hidden mt-4 p-4 rounded-lg"></div>

                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-4 text-center">
                                    🔒 Pagamento sicuro tramite Stripe. I tuoi dati non vengono memorizzati.
                                </p>
                            </div>

                            
                            <div class="mt-6 text-center">
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'offline')"
                                        class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white underline">
                                    Hai già pagato offline? Clicca qui
                                </button>
                            </div>
                        <?php elseif($paymentMethod === 'offline'): ?>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                                    <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">ℹ️ Pagamento Offline</h4>
                                    <p class="text-sm text-amber-800 dark:text-amber-300">
                                        Selezionando questa opzione, confermi di aver effettuato il pagamento al traduttore tramite altri metodi (bonifico, PayPal, contanti, ecc.).
                                    </p>
                                    <p class="text-sm text-amber-800 dark:text-amber-300 mt-2">
                                        Il team di Slamin verificherà il pagamento prima di rilasciare la traduzione.
                                    </p>
                                </div>

                                <button type="button"
                                        wire:click="markAsCompletedOffline"
                                        wire:loading.attr="disabled"
                                        wire:confirm="Confermi di aver effettuato il pagamento offline?"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove>
                                        ✓ Conferma Pagamento Offline
                                    </span>
                                    <span wire:loading>
                                        <svg class="animate-spin inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Elaborazione...
                                    </span>
                                </button>

                                
                                <div class="mt-4 text-center">
                                    <button type="button"
                                            wire:click="$set('paymentMethod', 'stripe')"
                                            class="text-sm text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white underline">
                                        ← Torna ai metodi di pagamento online
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$paymentCompleted && $paymentMethod === 'stripe' && $clientSecret): ?>
        <?php $__env->startPush('scripts'); ?>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stripe = Stripe('<?php echo e(config('services.stripe.key')); ?>');
                const options = {
                    clientSecret: '<?php echo e($clientSecret); ?>',
                    appearance: {
                        theme: document.documentElement.classList.contains('dark') ? 'night' : 'stripe',
                    },
                };

                const elements = stripe.elements(options);
                
                // Configura Payment Element per mostrare solo PayPal, Google Pay, Apple Pay
                const paymentElement = elements.create('payment', {
                    wallets: {
                        applePay: 'auto',
                        googlePay: 'auto',
                    },
                    paymentMethodOrder: ['paypal', 'google_pay', 'apple_pay']
                });
                
                paymentElement.mount('#payment-element');

                const form = document.getElementById('stripe-payment-form');
                const submitButton = document.getElementById('submit-payment');
                const messageContainer = document.getElementById('payment-message');

                submitButton.addEventListener('click', async (e) => {
                    e.preventDefault();
                    submitButton.disabled = true;

                    const {error} = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            return_url: '<?php echo e(route('gigs.payment.success', $application)); ?>',
                        },
                    });

                    if (error) {
                        messageContainer.textContent = error.message;
                        messageContainer.classList.remove('hidden', 'bg-green-50', 'text-green-800');
                        messageContainer.classList.add('bg-red-50', 'text-red-800', 'border', 'border-red-200');
                        submitButton.disabled = false;
                    }
                });
            });
        </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<?php /**PATH C:\xampp\htdocs\slamin_v2\resources\views/livewire/translations/payment-checkout.blade.php ENDPATH**/ ?>