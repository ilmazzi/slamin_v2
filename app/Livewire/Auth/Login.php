<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\LoggingService;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    protected $messages = [
        'email.required' => 'L\'email è obbligatoria',
        'email.email' => 'L\'email deve essere valida',
        'password.required' => 'La password è obbligatoria',
    ];

    public function mount()
    {
        // Se l'utente è già loggato, reindirizza
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            request()->session()->regenerate();
            $user = Auth::user();

            // Log successful login
            LoggingService::logAuth('login', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => request()->ip(),
                'remember' => $this->remember
            ], 'App\Models\User', $user->id);

            $message = $this->remember
                ? __('auth.welcome_back_remember', ['name' => $user->name])
                : __('auth.welcome_back', ['name' => $user->name]);

            session()->flash('success', $message);

            return $this->redirect(route('dashboard.index'), navigate: true);
        }

        // Log failed login attempt
        LoggingService::logAuth('login_failed', [
            'email' => $this->email,
            'ip' => request()->ip()
        ]);

        $this->addError('email', __('auth.credentials_invalid'));
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('components.layouts.master', ['title' => __('login.login_to_your_account')]);
    }
}

