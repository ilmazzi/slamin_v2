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
        // Gli utenti audience non possono accedere ai pagamenti
        if (Auth::check() && Auth::user()->hasRole('audience')) {
            session()->flash('error', __('gigs.messages.audience_not_allowed'));
            return redirect()->route('home');
        }
        
        // Verifica che l'utente sia il proprietario del gig
        if ($application->gig->user_id !== Auth::id()) {
            abort(403, 'Non autorizzato');
        }

        $this->application = $application->load(['gig.poem', 'user']);

        // Recupera il payment_intent_id dalla query string
        $paymentIntentId = request()->query('payment_intent');

        if ($paymentIntentId) {
            $this->verifyAndCompletePayment($paymentIntentId);
        } else {
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

