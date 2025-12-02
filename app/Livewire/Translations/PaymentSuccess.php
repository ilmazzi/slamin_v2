<?php

namespace App\Livewire\Translations;

use App\Models\GigApplication;
use App\Models\TranslationPayment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentSuccess extends Component
{
    public GigApplication $application;
    public $payment;
    public $paymentIntent;
    public $processing = true;

    public function mount(GigApplication $application)
    {
        // Verifica che l'utente sia il proprietario del gig
        if ($application->gig->user_id !== Auth::id()) {
            abort(403, 'Non autorizzato');
        }

        $this->application = $application->load(['gig.poem', 'user']);

        // Recupera il payment_intent_id (Stripe) o paypal_order_id dalla query string
        $paymentIntentId = request()->query('payment_intent');
        $paypalOrderId = request()->query('paypal_order_id');

        if ($paymentIntentId) {
            $this->verifyAndCompletePayment($paymentIntentId);
        } elseif ($paypalOrderId) {
            $this->verifyAndCompletePayPalPayment($paypalOrderId);
        } else {
            $this->processing = false;
        }
    }

    protected function verifyAndCompletePayPalPayment($paypalOrderId)
    {
        try {
            // Per ora, registra il pagamento come completato
            // TODO: Implementare verifica con PayPal API
            
            $commissionData = \App\Services\PaymentService::calculateCommission((float) $this->application->negotiated_compensation ?? $this->application->gig->compensation ?? 0);

            $this->payment = TranslationPayment::create([
                'gig_application_id' => $this->application->id,
                'poem_id' => $this->application->gig->poem_id,
                'client_id' => Auth::id(),
                'translator_id' => $this->application->user_id,
                'amount' => $commissionData['total_amount'],
                'currency' => 'EUR',
                'status' => 'completed',
                'paid_at' => now(),
                'commission_rate' => $commissionData['commission_rate'],
                'commission_fixed' => $commissionData['commission_fixed'],
                'commission_total' => $commissionData['commission_total'],
                'translator_amount' => $commissionData['translator_amount'],
                'platform_amount' => $commissionData['platform_amount'],
                'payment_method' => 'paypal',
                'stripe_metadata' => [
                    'paypal_order_id' => $paypalOrderId,
                ],
            ]);

            // Aggiorna lo status dell'application
            $this->application->update(['status' => 'completed']);

            Log::info('PayPal payment completed successfully', [
                'payment_id' => $this->payment->id,
                'paypal_order_id' => $paypalOrderId,
                'amount' => $this->payment->amount,
            ]);

            $this->processing = false;

        } catch (\Exception $e) {
            Log::error('PayPal payment verification failed', [
                'error' => $e->getMessage(),
                'paypal_order_id' => $paypalOrderId,
            ]);
            $this->processing = false;
        }
    }

    protected function verifyAndCompletePayment($paymentIntentId)
    {
        try {
            // Recupera il PaymentIntent da Stripe
            Stripe::setApiKey(config('services.stripe.secret'));
            $this->paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            // Trova il pagamento nel database
            $this->payment = TranslationPayment::where('stripe_payment_intent_id', $paymentIntentId)->first();

            if (!$this->payment) {
                Log::error('Payment not found in database', ['payment_intent_id' => $paymentIntentId]);
                $this->processing = false;
                return;
            }

            // Verifica lo stato del PaymentIntent
            if ($this->paymentIntent->status === 'succeeded' && $this->payment->status !== 'completed') {
                // Aggiorna il pagamento come completato
                $this->payment->update([
                    'status' => 'completed',
                    'stripe_charge_id' => $this->paymentIntent->latest_charge,
                    'paid_at' => now(),
                    'stripe_metadata' => [
                        'payment_intent' => $this->paymentIntent->toArray(),
                    ],
                ]);

                // Aggiorna lo status dell'application
                $this->application->update(['status' => 'completed']);

                Log::info('Payment completed successfully', [
                    'payment_id' => $this->payment->id,
                    'payment_intent_id' => $paymentIntentId,
                    'amount' => $this->payment->amount,
                ]);
            }

            $this->processing = false;

        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'error' => $e->getMessage(),
                'payment_intent_id' => $paymentIntentId,
            ]);
            $this->processing = false;
        }
    }

    public function render()
    {
        return view('livewire.translations.payment-success');
    }
}

