<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NewsletterSubscribe extends Component
{
    public $email = '';
    public $name = '';
    public $subscribed = false;
    public $error = '';
    public $isSubscribed = false;

    public function mount()
    {
        if (Auth::check()) {
            // Check if user is already subscribed
            $subscriber = NewsletterSubscriber::where('email', Auth::user()->email)->first();
            $this->isSubscribed = $subscriber && $subscriber->status === 'active';
        }
    }

    public function subscribe()
    {
        // For authenticated users, use their email and name
        if (Auth::check()) {
            $this->email = Auth::user()->email;
            $this->name = Auth::user()->name;
        }

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
                    $this->isSubscribed = true;
                    return;
                } else {
                    // Resubscribe
                    $existing->resubscribe();
                    $this->subscribed = true;
                    $this->isSubscribed = true;
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
            $this->isSubscribed = true;
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

    public function unsubscribe()
    {
        if (!Auth::check()) {
            return;
        }

        try {
            $subscriber = NewsletterSubscriber::where('email', Auth::user()->email)->first();
            
            if ($subscriber && $subscriber->status === 'active') {
                $subscriber->unsubscribe();
                $this->isSubscribed = false;
                $this->subscribed = false;
                session()->flash('newsletter_unsubscribed', 'Disiscrizione completata con successo.');
            }
        } catch (\Exception $e) {
            Log::error('Error unsubscribing from newsletter', [
                'email' => Auth::user()->email,
                'error' => $e->getMessage()
            ]);
            $this->error = 'Errore durante la disiscrizione. Riprova più tardi.';
        }
    }

    public function render()
    {
        return view('livewire.components.newsletter-subscribe');
    }
}
