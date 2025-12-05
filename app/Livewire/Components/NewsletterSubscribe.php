<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;

class NewsletterSubscribe extends Component
{
    public $email = '';
    public $name = '';
    public $subscribed = false;
    public $error = '';

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ], [
            'email.required' => 'L\'indirizzo email è obbligatorio',
            'email.email' => 'Inserisci un indirizzo email valido',
        ]);

        try {
            // Check if already subscribed
            $existing = NewsletterSubscriber::where('email', $this->email)->first();

            if ($existing) {
                if ($existing->status === 'active') {
                    $this->error = 'Sei già iscritto alla newsletter!';
                    return;
                } else {
                    // Resubscribe
                    $existing->resubscribe();
                    $this->subscribed = true;
                    $this->email = '';
                    $this->name = '';
                    $this->error = '';
                    return;
                }
            }

            // Create new subscriber
            NewsletterSubscriber::create([
                'email' => $this->email,
                'name' => $this->name ?: null,
                'status' => 'active',
            ]);

            $this->subscribed = true;
            $this->email = '';
            $this->name = '';
            $this->error = '';

        } catch (\Exception $e) {
            Log::error('Error subscribing to newsletter', [
                'email' => $this->email,
                'error' => $e->getMessage()
            ]);
            $this->error = 'Errore durante l\'iscrizione. Riprova più tardi.';
        }
    }

    public function render()
    {
        return view('livewire.components.newsletter-subscribe');
    }
}
