<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Services\LoggingService;
use App\Helpers\LanguageHelper;

class Register extends Component
{
    public $name = '';
    public $nickname = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $language = '';
    public $selectedRoles = [];

    protected function rules()
    {
        $availableLanguages = array_keys(LanguageHelper::getAvailableLanguages());
        
        return [
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'language' => 'required|string|in:' . implode(',', $availableLanguages),
            'selectedRoles' => 'nullable|array',
            'selectedRoles.*' => 'exists:roles,name',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('register.full_name')]),
            'nickname.unique' => __('validation.unique', ['attribute' => __('register.nickname')]),
            'email.required' => __('validation.required', ['attribute' => __('register.email')]),
            'email.email' => __('validation.email', ['attribute' => __('register.email')]),
            'email.unique' => __('validation.unique', ['attribute' => __('register.email')]),
            'password.required' => __('validation.required', ['attribute' => __('register.password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('register.password'), 'min' => 8]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('register.password')]),
            'language.required' => __('validation.required', ['attribute' => __('register.preferred_language')]),
            'language.in' => __('validation.in', ['attribute' => __('register.preferred_language')]),
        ];
    }

    public function mount()
    {
        // Se l'utente è già loggato, reindirizza
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        // Imposta lingua di default
        $this->language = app()->getLocale();
    }

    public function updated($propertyName)
    {
        // Valida solo le proprietà che hanno regole complete
        // Per la lingua, le regole sono già aggiornate dinamicamente in getRules()
        $this->validateOnly($propertyName);
    }

    public function updatedLanguage()
    {
        // Aggiorna la lingua nella sessione quando cambia
        session()->put('locale', $this->language);
        app()->setLocale($this->language);
    }

    public function register()
    {
        // Le regole vengono ottenute automaticamente dal metodo rules()
        $this->validate();

        try {
            // Crea l'utente (senza verifica email iniziale)
            $user = User::create([
                'name' => $this->name,
                'nickname' => $this->nickname ?: null,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'status' => 'active',
                'email_verified_at' => null, // Non verificato inizialmente
            ]);

            // Assegna i ruoli selezionati
            $roles = $this->selectedRoles ?? [];

            // Se non ha selezionato ruoli, assegna 'audience' come default
            if (empty($roles)) {
                $roles = ['audience'];
            }

            // Assegna i ruoli usando syncRoles
            $user->syncRoles($roles);

            // Login automatico per permettere l'accesso alla pagina di verifica
            Auth::login($user);

            // Imposta la lingua nella sessione
            session()->put('locale', $this->language);
            app()->setLocale($this->language);

            // Invia email di verifica
            try {
                $user->sendEmailVerificationNotification();
                Log::info('Email di verifica inviata con successo', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } catch (\Exception $e) {
                Log::error('Errore invio email di verifica', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);
            }

            // Salva i ruoli per la creazione PeerTube post-verifica
            $user->update([
                'peertube_roles' => json_encode($roles) // Salva i ruoli per dopo la verifica
            ]);

            // Log registration
            LoggingService::logAuth('register', [
                'user_id' => $user->id,
                'email' => $user->email,
                'roles' => $roles,
                'email_verification_sent' => true
            ], 'App\Models\User', $user->id);

            // Messaggio di registrazione con verifica email
            $roleText = count($roles) > 1 ?
                count($roles) . ' ruoli' :
                $this->getRoleDisplayName($roles[0]);

            $welcomeMessage = __('register.registration_completed', ['roles' => $roleText]);

            session()->flash('success', $welcomeMessage);

            return $this->redirect(route('verification.notice'), navigate: true);

        } catch (Exception $e) {
            // Log registration error
            LoggingService::logError('registration_failed', [
                'email' => $this->email,
                'error' => $e->getMessage(),
                'roles' => $this->selectedRoles ?? []
            ]);

            $this->addError('error', 'Errore durante la registrazione: ' . $e->getMessage());
        }
    }

    public function toggleRole($roleName)
    {
        if (in_array($roleName, $this->selectedRoles)) {
            $this->selectedRoles = array_values(array_diff($this->selectedRoles, [$roleName]));
        } else {
            $this->selectedRoles[] = $roleName;
        }
    }

    public function getRolesProperty()
    {
        return Role::whereIn('name', ['poet', 'organizer', 'venue_owner', 'audience'])
            ->get()
            ->map(function($role) {
                return [
                    'name' => $role->name,
                    'display_name' => $this->getRoleDisplayName($role->name),
                    'description' => $this->getRoleDescription($role->name),
                    'permissions_count' => $role->permissions->count(),
                    'icon' => $this->getRoleIcon($role->name),
                    'color' => $this->getRoleColor($role->name),
                    'is_primary' => in_array($role->name, ['poet', 'organizer', 'audience']),
                ];
            });
    }

    public function getLanguagesProperty()
    {
        return LanguageHelper::getAvailableLanguages();
    }

    private function getRoleDisplayName($roleName)
    {
        $names = [
            'admin' => __('register.role_admin_name'),
            'moderator' => __('register.role_moderator_name'),
            'poet' => __('register.role_poet_name'),
            'organizer' => __('register.role_organizer_name'),
            'judge' => __('register.role_judge_name'),
            'venue_owner' => __('register.role_venue_owner_name'),
            'technician' => __('register.role_technician_name'),
            'audience' => __('register.role_audience_name'),
        ];

        return $names[$roleName] ?? ucfirst($roleName);
    }

    private function getRoleDescription($roleName)
    {
        $descriptions = [
            'admin' => __('register.role_admin_description'),
            'moderator' => __('register.role_moderator_description'),
            'poet' => __('register.role_poet_description'),
            'organizer' => __('register.role_organizer_description'),
            'judge' => __('register.role_judge_description'),
            'venue_owner' => __('register.role_venue_owner_description'),
            'technician' => __('register.role_technician_description'),
            'audience' => __('register.role_audience_description'),
        ];

        return $descriptions[$roleName] ?? __('register.role_special_description');
    }

    private function getRoleIcon($roleName)
    {
        $icons = [
            'admin' => '👑',
            'moderator' => '🛡️',
            'poet' => '🎤',
            'organizer' => '🎪',
            'judge' => '👨‍⚖️',
            'venue_owner' => '🏛️',
            'technician' => '🔧',
            'audience' => '👥',
        ];

        return $icons[$roleName] ?? '🎭';
    }

    private function getRoleColor($roleName)
    {
        $colors = [
            'admin' => 'danger',
            'moderator' => 'warning',
            'poet' => 'primary',
            'organizer' => 'success',
            'judge' => 'info',
            'venue_owner' => 'secondary',
            'technician' => 'dark',
            'audience' => 'light',
        ];

        return $colors[$roleName] ?? 'primary';
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('components.layouts.master', ['title' => __('register.register')]);
    }
}

