<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPassword extends Component
{
    public $email = '';
    public $status = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'L\'email è obbligatoria',
        'email.email' => 'L\'email deve essere valida',
    ];

    public function mount()
    {
        // Se l'utente è già loggato, reindirizza
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        }
    }

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = 'sent';
            Log::info('Password reset link sent', ['email' => $this->email]);
        } else {
            $this->addError('email', __('auth.password_reset_failed'));
            Log::warning('Password reset link failed', ['email' => $this->email, 'status' => $status]);
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('components.layouts.master', ['title' => __('auth.forgot_password')]);
    }
}

