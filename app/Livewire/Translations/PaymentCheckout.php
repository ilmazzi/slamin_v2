<?php

namespace App\Livewire\Translations;

use App\Models\GigApplication;
use App\Models\TranslationPayment;
use App\Services\PaymentService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentCheckout extends Component
{
    public GigApplication $application;
    public $amount;
    public $paymentMethod = 'stripe';
    public $clientSecret;
    public $paymentIntentId;
    public $processing = false;
    public $paymentCompleted = false;
    public $errorMessage = null;

    public function mount(GigApplication $application)
    {
        // Verifica che l'utente sia il proprietario del gig
        if ($application->gig->user_id !== Auth::id()) {
            abort(403, 'Non autorizzato');
        }

        // Verifica che l'application sia accettata o completata
        if (!in_array($application->status, ['accepted', 'completed'])) {
            abort(403, 'Application non valida per il pagamento');
        }

        // Verifica che ci sia una traduzione approvata
        $hasApprovedTranslation = $application->translations()->where('status', 'approved')->exists();
        if (!$hasApprovedTranslation) {
            abort(403, 'Nessuna traduzione approvata');
        }

        // Verifica che non esista già un pagamento completato
        $existingPayment = TranslationPayment::where('gig_application_id', $application->id)
            ->where('status', 'completed')
            ->first();

        if ($existingPayment) {
            $this->paymentCompleted = true;
            return;
        }

        $this->application = $application->load(['gig.poem', 'user']);
        $this->amount = (float) ($application->negotiated_compensation ?? $application->gig->compensation ?? 0);

        // Crea o recupera il PaymentIntent
        $this->createOrRetrievePaymentIntent();
    }

    protected function createOrRetrievePaymentIntent()
    {
        try {
            // Cerca un pagamento pending esistente
            $existingPayment = TranslationPayment::where('gig_application_id', $this->application->id)
                ->whereIn('status', ['pending', 'processing'])
                ->first();

            if ($existingPayment && $existingPayment->stripe_payment_intent_id) {
                // Recupera il PaymentIntent esistente
                Stripe::setApiKey(config('services.stripe.secret'));
                $paymentIntent = PaymentIntent::retrieve($existingPayment->stripe_payment_intent_id);
                
                $this->clientSecret = $paymentIntent->client_secret;
                $this->paymentIntentId = $paymentIntent->id;
                return;
            }

            // Calcola commissioni
            $commissionData = PaymentService::calculateCommission($this->amount);

            // Crea nuovo PaymentIntent
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentIntent = PaymentIntent::create([
                'amount' => PaymentService::toCents($this->amount),
                'currency' => 'eur',
                'metadata' => [
                    'gig_application_id' => $this->application->id,
                    'gig_id' => $this->application->gig_id,
                    'poem_id' => $this->application->gig->poem_id,
                    'translator_id' => $this->application->user_id,
                    'client_id' => Auth::id(),
                ],
                'description' => 'Traduzione: ' . ($this->application->gig->poem->title ?? 'N/A'),
            ]);

            // Salva nel database
            TranslationPayment::create([
                'gig_application_id' => $this->application->id,
                'poem_id' => $this->application->gig->poem_id,
                'client_id' => Auth::id(),
                'translator_id' => $this->application->user_id,
                'amount' => $this->amount,
                'currency' => 'EUR',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'status' => 'pending',
                'commission_rate' => $commissionData['commission_rate'],
                'commission_fixed' => $commissionData['commission_fixed'],
                'commission_total' => $commissionData['commission_total'],
                'translator_amount' => $commissionData['translator_amount'],
                'platform_amount' => $commissionData['platform_amount'],
                'payment_method' => 'stripe',
            ]);

            $this->clientSecret = $paymentIntent->client_secret;
            $this->paymentIntentId = $paymentIntent->id;

        } catch (ApiErrorException $e) {
            Log::error('Stripe PaymentIntent creation failed', [
                'error' => $e->getMessage(),
                'application_id' => $this->application->id,
            ]);
            $this->errorMessage = 'Errore nella creazione del pagamento: ' . $e->getMessage();
        }
    }

    public function confirmPayment()
    {
        $this->processing = true;
        // Il pagamento viene confermato lato client con Stripe.js
        // Questo metodo viene chiamato dopo il successo
    }

    public function markAsCompletedOffline()
    {
        // Verifica autorizzazione
        if ($this->application->gig->user_id !== Auth::id()) {
            session()->flash('error', 'Non autorizzato');
            return;
        }

        try {
            // Calcola commissioni
            $commissionData = PaymentService::calculateCommission((float) $this->amount);

            // Crea il pagamento come completato (offline)
            TranslationPayment::create([
                'gig_application_id' => $this->application->id,
                'poem_id' => $this->application->gig->poem_id,
                'client_id' => Auth::id(),
                'translator_id' => $this->application->user_id,
                'amount' => $this->amount,
                'currency' => 'EUR',
                'status' => 'completed',
                'paid_at' => now(),
                'commission_rate' => $commissionData['commission_rate'],
                'commission_fixed' => $commissionData['commission_fixed'],
                'commission_total' => $commissionData['commission_total'],
                'translator_amount' => $commissionData['translator_amount'],
                'platform_amount' => $commissionData['platform_amount'],
                'payment_method' => 'offline',
                'payout_status' => 'pending_manual',
                'payout_notes' => 'Pagamento offline - da verificare manualmente',
            ]);

            // Aggiorna lo status dell'application
            $this->application->update(['status' => 'completed']);

            session()->flash('success', 'Pagamento registrato come completato. Il team verificherà il pagamento.');
            
            return redirect()->route('gigs.show', $this->application->gig);

        } catch (\Exception $e) {
            Log::error('Offline payment marking failed', [
                'error' => $e->getMessage(),
                'application_id' => $this->application->id,
            ]);
            session()->flash('error', 'Errore nella registrazione del pagamento');
        }
    }

    public function render()
    {
        $commissionData = PaymentService::calculateCommission((float) $this->amount);
        $paymentMethods = PaymentService::getEnabledPaymentMethods();

        return view('livewire.translations.payment-checkout', [
            'commissionData' => $commissionData,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}

