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
                                        wire:click="$set('paymentMethod', 'paypal')"
                                        class="px-4 py-3 font-semibold transition-colors border-b-2 {{ $paymentMethod === 'paypal' ? 'border-blue-600 text-blue-600' : 'border-transparent text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.276 5.12-6.514 5.12h-.5a.805.805 0 00-.794.68l-.04.22-.63 3.993-.028.15a.805.805 0 01-.793.68H8.25c-.467 0-.825-.377-.745-.84l.014-.075L9.28 13.7a1.018 1.018 0 011.006-.862h2.095c3.1 0 5.522-1.26 6.226-4.904.086-.445.133-.89.133-1.327 0-.862-.172-1.619-.524-2.226a3.662 3.662 0 00-.82-.943 3.662 3.662 0 00-1.043-.668A5.186 5.186 0 0014.955 3h-5.21c-.467 0-.865.338-.944.802l-1.805 11.44a.805.805 0 00.794.92h2.85l.716-4.54.76-4.82a.944.944 0 01.932-.802h1.052c1.268 0 2.33.182 3.148.54.757.332 1.369.814 1.819 1.436z"/>
                                        </svg>
                                        PayPal
                                        <span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-0.5 rounded-full">Consigliato</span>
                                    </div>
                                </button>
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'stripe')"
                                        class="px-4 py-3 font-semibold transition-colors border-b-2 {{ $paymentMethod === 'stripe' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                                    💳 Carta di Credito
                                </button>
                                <button type="button"
                                        wire:click="$set('paymentMethod', 'offline')"
                                        class="px-4 py-3 font-semibold transition-colors border-b-2 {{ $paymentMethod === 'offline' ? 'border-primary-600 text-primary-600' : 'border-transparent text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white' }}">
                                    💰 Pagamento Offline
                                </button>
                            </div>
                        </div>

                        @if($paymentMethod === 'paypal')
                            {{-- PayPal Payment Form --}}
                            <div id="paypal-payment-form">
                                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-1">Come funziona PayPal?</h4>
                                            <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                                                <li>✓ Clicca sul pulsante PayPal qui sotto</li>
                                                <li>✓ Verrai reindirizzato al sito sicuro di PayPal</li>
                                                <li>✓ Accedi al tuo account PayPal (o creane uno)</li>
                                                <li>✓ Conferma il pagamento</li>
                                                <li>✓ Tornerai automaticamente su Slamin</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div id="paypal-button-container" class="mb-6">
                                    <!-- PayPal Button will be inserted here -->
                                </div>

                                <p class="text-xs text-neutral-500 dark:text-neutral-400 text-center">
                                    🔒 Pagamento sicuro tramite PayPal. I tuoi dati finanziari non vengono condivisi con Slamin.
                                </p>
                            </div>
                        @elseif($paymentMethod === 'stripe')
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

    {{-- PayPal Script --}}
    @if(!$paymentCompleted && $paymentMethod === 'paypal')
        @push('scripts')
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=EUR"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof paypal !== 'undefined') {
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: '{{ number_format($amount, 2, '.', '') }}',
                                        currency_code: 'EUR'
                                    },
                                    description: 'Traduzione: {{ $application->gig->poem->title ?? "N/A" }}'
                                }],
                                application_context: {
                                    brand_name: 'Slamin',
                                    locale: 'it-IT',
                                    shipping_preference: 'NO_SHIPPING'
                                }
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                // Redirect to success page
                                window.location.href = '{{ route('gigs.payment.success', $application) }}?paypal_order_id=' + data.orderID;
                            });
                        },
                        onError: function(err) {
                            alert('Si è verificato un errore con PayPal. Riprova o usa un altro metodo di pagamento.');
                            console.error('PayPal Error:', err);
                        },
                        style: {
                            layout: 'vertical',
                            color: 'blue',
                            shape: 'rect',
                            label: 'pay'
                        }
                    }).render('#paypal-button-container');
                }
            });
        </script>
        @endpush
    @endif

    {{-- Stripe Script --}}
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

