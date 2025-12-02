<div class="min-h-screen bg-neutral-50 dark:bg-neutral-900 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($processing)
            {{-- Loading State --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-12 text-center">
                <svg class="animate-spin w-16 h-16 text-primary-600 dark:text-primary-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Verifica Pagamento...</h2>
                <p class="text-neutral-600 dark:text-neutral-400">Attendere prego</p>
            </div>
        @elseif($payment && $payment->status === 'completed')
            {{-- Success State --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden">
                {{-- Header Success --}}
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black text-white mb-2">Pagamento Completato!</h1>
                    <p class="text-green-100">Il tuo pagamento è stato elaborato con successo</p>
                </div>

                {{-- Payment Details --}}
                <div class="p-8">
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center pb-3 border-b border-neutral-200 dark:border-neutral-700">
                            <span class="text-neutral-600 dark:text-neutral-400">Importo Pagato:</span>
                            <span class="text-2xl font-black text-neutral-900 dark:text-white">€{{ number_format($payment->amount, 2) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-neutral-600 dark:text-neutral-400">Traduttore:</span>
                            <span class="font-semibold text-neutral-900 dark:text-white">{{ $application->user->name }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-neutral-600 dark:text-neutral-400">Poesia:</span>
                            <span class="font-semibold text-neutral-900 dark:text-white">{{ $application->gig->poem->title ?? 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-neutral-600 dark:text-neutral-400">Data Pagamento:</span>
                            <span class="font-semibold text-neutral-900 dark:text-white">{{ $payment->paid_at->format('d/m/Y H:i') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-neutral-600 dark:text-neutral-400">ID Transazione:</span>
                            <span class="font-mono text-sm text-neutral-700 dark:text-neutral-300">{{ Str::limit($payment->stripe_payment_intent_id, 30) }}</span>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">📧 Cosa Succede Ora?</h3>
                        <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                            <li>✓ Riceverai una ricevuta via email</li>
                            <li>✓ Il traduttore riceverà €{{ number_format($payment->translator_amount, 2) }}</li>
                            <li>✓ La traduzione è ora disponibile nel tuo profilo</li>
                        </ul>
                    </div>

                    {{-- Actions --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('gigs.workspace', $application) }}" 
                           class="block px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold text-center rounded-lg transition-colors">
                            📄 Visualizza Traduzione
                        </a>
                        <a href="{{ route('gigs.show', $application->gig) }}" 
                           class="block px-6 py-3 bg-neutral-200 dark:bg-neutral-700 hover:bg-neutral-300 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-semibold text-center rounded-lg transition-colors">
                            ← Torna al Gig
                        </a>
                    </div>
                </div>
            </div>
        @else
            {{-- Error State --}}
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-12 text-center">
                <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Errore nel Pagamento</h2>
                <p class="text-neutral-600 dark:text-neutral-400 mb-6">Non è stato possibile verificare il pagamento. Contatta il supporto.</p>
                <a href="{{ route('gigs.show', $application->gig) }}" 
                   class="inline-block px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors">
                    Torna al Gig
                </a>
            </div>
        @endif
    </div>
</div>

