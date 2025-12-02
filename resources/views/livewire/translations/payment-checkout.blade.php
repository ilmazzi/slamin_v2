<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($paymentCompleted)
            {{-- Pagamento già completato --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-8 text-center">
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Pagamento Completato</h2>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">Il pagamento per questa traduzione è già stato effettuato.</p>
                <a href="{{ route('gigs.show', $application->gig) }}" 
                   class="inline-block px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                    Torna al Gig
                </a>
            </div>
        @else
            {{-- Header --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Pagamento Traduzione</h1>
                        <p class="text-neutral-600 dark:text-neutral-400">{{ $application->gig->poem->title ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Riepilogo --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-4">Riepilogo</h3>
                        
                        <div class="space-y-3 mb-4 pb-4 border-b border-neutral-200 dark:border-neutral-700">
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Traduttore:</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">{{ $application->user->name }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Poesia:</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">{{ Str::limit($application->gig->poem->title ?? 'N/A', 20) }}</span>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-neutral-700 dark:text-neutral-300">Compenso:</span>
                                <span class="font-semibold text-neutral-900 dark:text-white">€{{ number_format($amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-neutral-600 dark:text-neutral-400">Commissione piattaforma:</span>
                                <span class="text-neutral-700 dark:text-neutral-300">€{{ number_format($commissionData['commission_total'], 2) }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-neutral-900 dark:text-white">Totale:</span>
                                <span class="text-2xl font-black text-primary-600 dark:text-primary-400">€{{ number_format($amount, 2) }}</span>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2">
                                Il traduttore riceverà €{{ number_format($commissionData['translator_amount'], 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Pagamento --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6">
                        @if($errorMessage)
                            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                                <p class="text-red-800 dark:text-red-200">{{ $errorMessage }}</p>
                            </div>
                        @endif

                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-6">Metodo di Pagamento</h3>

                        {{-- Tabs Metodi di Pagamento --}}
                        <div class="mb-6">
                            <div class="flex gap-2 border-b border-neutral-200 dark:border-neutral-700">
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'stripe')"
                                        class="px-4 py-2 font-semibold transition-colors border-b-2 {{ $paymentMethod === 'stripe' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                                    💳 Carta di Credito
                                </button>
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'offline')"
                                        class="px-4 py-2 font-semibold transition-colors border-b-2 {{ $paymentMethod === 'offline' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                                    💰 Pagamento Offline
                                </button>
                            </div>
                        </div>

                        @if($paymentMethod === 'stripe')
                            {{-- Stripe Payment Form --}}
                            <div id="stripe-payment-form">
                                <div id="payment-element" class="mb-6">
                                    <!-- Stripe Elements will be inserted here -->
                                </div>

                                <button type="button" 
                                        id="submit-payment"
                                        wire:loading.attr="disabled"
                                        class="w-full px-6 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove>
                                        💳 Paga €{{ number_format($amount, 2) }}
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
                        @else
                            {{-- Offline Payment --}}
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
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(!$paymentCompleted && $paymentMethod === 'stripe' && $clientSecret)
        @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stripe = Stripe('{{ config('services.stripe.key') }}');
                const options = {
                    clientSecret: '{{ $clientSecret }}',
                    appearance: {
                        theme: document.documentElement.classList.contains('dark') ? 'night' : 'stripe',
                    },
                };

                const elements = stripe.elements(options);
                const paymentElement = elements.create('payment');
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
                            return_url: '{{ route('gigs.payment.success', $application) }}',
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
        @endpush
    @endif
</div>

