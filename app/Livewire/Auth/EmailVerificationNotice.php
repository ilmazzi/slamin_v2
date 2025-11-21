<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class EmailVerificationNotice extends Component
{
    public $status;

    public function mount()
    {
        // Se l'utente non è autenticato, reindirizza al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Se l'email è già verificata, reindirizza alla dashboard
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard.index');
        }
    }

    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        session()->flash('status', __('auth.verification_link_sent'));

        // Reindirizza per mostrare il messaggio di successo
        return $this->redirect(route('verification.notice'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.email-verification-notice')
            ->layout('components.layouts.master', ['title' => __('auth.email_verification_required')]);
    }
}
