<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ResetPassword extends Component
{
    public $email = '';
    public $token = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ];

    protected $messages = [
        'email.required' => 'L\'email è obbligatoria',
        'email.email' => 'L\'email deve essere valida',
        'password.required' => 'La password è obbligatoria',
        'password.min' => 'La password deve essere di almeno 8 caratteri',
        'password.confirmed' => 'Le password non corrispondono',
    ];

    public function mount($token, $email = null)
    {
        $this->token = $token;
        $this->email = $email ?? '';
        
        // Se l'utente è già loggato, reindirizza
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        }
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            [
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Log::info('Password reset successful', ['email' => $this->email]);
            session()->flash('success', __('auth.password_reset_success'));
            return $this->redirect(route('login'), navigate: false);
        } else {
            $this->addError('email', __('auth.password_reset_failed'));
            Log::warning('Password reset failed', ['email' => $this->email, 'status' => $status]);
        }
    }

    public function render()
    {
        return view('livewire.auth.reset-password')
            ->layout('components.layouts.master', ['title' => __('auth.reset_password')]);
    }
}

