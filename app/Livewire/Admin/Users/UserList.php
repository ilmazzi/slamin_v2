<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $status = 'all'; // all, active, inactive

    #[Url]
    public $role = 'all';

    #[Url]
    public $sortBy = 'created_at';

    #[Url]
    public $sortDirection = 'desc';

    // Modal edit
    public $showEditModal = false;
    public $editingUser = null;
    
    // Modal create
    public $showCreateModal = false;
    
    // Form fields
    public $name = '';
    public $email = '';
    public $nickname = '';
    public $password = '';
    public $password_confirmation = '';
    public $userStatus = 'active';
    public $roles = [];
    public $permissions = [];
    public $createPeerTubeAccount = false;
    public $verifyEmail = false;
    public $emailVerified = false;

    // Available roles and permissions (computed)
    public function getAvailableRolesProperty()
    {
        return \App\Models\Role::all();
    }

    public function getAvailablePermissionsProperty()
    {
        // TODO: Implementare quando Permission model sarà disponibile
        return collect([]);
    }

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function openEditModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nickname = $user->nickname ?? '';
        $this->userStatus = $user->status ?? 'active';
        $this->roles = $user->roles()->pluck('roles.id')->toArray();
        $this->emailVerified = $user->email_verified_at !== null;
        $this->showEditModal = true;
    }
    
    public function toggleEmailVerification()
    {
        $this->emailVerified = !$this->emailVerified;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingUser = null;
        $this->reset(['name', 'email', 'nickname', 'userStatus', 'roles', 'permissions', 'emailVerified']);
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
        $this->reset(['name', 'email', 'nickname', 'password', 'password_confirmation', 'userStatus', 'roles', 'permissions', 'createPeerTubeAccount', 'verifyEmail']);
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->reset(['name', 'email', 'nickname', 'password', 'password_confirmation', 'userStatus', 'roles', 'permissions', 'createPeerTubeAccount', 'verifyEmail']);
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nickname' => 'nullable|string|max:50|unique:users,nickname',
            'password' => 'required|min:8|confirmed',
            'userStatus' => 'required|in:active,inactive,suspended,banned',
            'roles' => 'array',
            'createPeerTubeAccount' => 'boolean',
            'verifyEmail' => 'boolean',
        ], [
            'name.required' => 'Il nome è obbligatorio',
            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'L\'email deve essere valida',
            'email.unique' => 'Questa email è già registrata',
            'nickname.unique' => 'Questo nickname è già in uso',
            'password.required' => 'La password è obbligatoria',
            'password.min' => 'La password deve essere di almeno 8 caratteri',
            'password.confirmed' => 'Le password non corrispondono',
        ]);

        try {
            // Crea l'utente
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'nickname' => $this->nickname,
                'password' => \Illuminate\Support\Facades\Hash::make($this->password),
                'status' => $this->userStatus,
                'email_verified_at' => $this->verifyEmail ? now() : null,
            ]);

            // Assegna i ruoli
            if (!empty($this->roles)) {
                $user->syncRoles($this->roles);
            }

            // Crea account PeerTube se richiesto
            if ($this->createPeerTubeAccount) {
                try {
                    $peerTubeService = new \App\Services\PeerTubeService();
                    
                    // Verifica che PeerTube sia configurato
                    if (!$peerTubeService->isConfigured()) {
                        session()->flash('error', __('admin.users.peertube_not_configured'));
                        Log::warning('PeerTube non configurato - impossibile creare account', [
                            'user_id' => $user->id
                        ]);
                    } else {
                        $peerTubePassword = \Illuminate\Support\Str::random(16);
                        $success = $peerTubeService->createPeerTubeUser($user, $peerTubePassword);
                        
                        if ($success) {
                            Log::info('Account PeerTube creato per utente admin', [
                                'user_id' => $user->id,
                                'email' => $user->email
                            ]);
                            session()->flash('message', __('admin.users.peertube_created_success'));
                        } else {
                            Log::warning('Errore creazione account PeerTube per utente admin', [
                                'user_id' => $user->id,
                                'email' => $user->email
                            ]);
                            session()->flash('error', __('admin.users.peertube_creation_failed'));
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Eccezione durante creazione account PeerTube', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    session()->flash('error', __('admin.users.peertube_creation_error') . ': ' . $e->getMessage());
                }
            }

            session()->flash('message', __('admin.users.created_success', ['name' => $user->name]));
            $this->closeCreateModal();
        } catch (\Exception $e) {
            Log::error('Errore creazione utente admin', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->addError('email', __('admin.users.create_error') . ': ' . $e->getMessage());
        }
    }

    public function updateUser()
    {
        if (!$this->editingUser) {
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->editingUser->id)],
            'nickname' => 'nullable|string|max:50',
            'userStatus' => 'required|in:active,inactive,suspended,banned',
            'roles' => 'array',
        ], [
            'name.required' => 'Il nome è obbligatorio',
            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'L\'email deve essere valida',
            'email.unique' => 'Questa email è già registrata',
        ]);

        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'nickname' => $this->nickname,
            'status' => $this->userStatus,
            'email_verified_at' => $this->emailVerified ? now() : null,
        ];
        
        $this->editingUser->update($updateData);

        // Sincronizza i ruoli
        if (!empty($this->roles)) {
            $this->editingUser->syncRoles($this->roles);
        } else {
            // Se nessun ruolo selezionato, rimuovi tutti i ruoli
            $this->editingUser->syncRoles([]);
        }

        session()->flash('message', __('admin.users.updated_success'));
        $this->closeEditModal();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Controlli sicurezza
        if ($user->hasRole('admin')) {
            // Conta admin nel database
            $adminCount = User::all()->filter(function($u) {
                return $u->hasRole('admin');
            })->count();
            
            if ($adminCount <= 1) {
                session()->flash('error', __('admin.users.cannot_delete_last_admin'));
                return;
            }
        }

        try {
            // Elimina account PeerTube se esiste
            if ($user->hasPeerTubeAccount()) {
                $this->deletePeerTubeAccount($user);
            }

            // Elimina file associati
            $this->deleteUserFiles($user);

            // Elimina utente
            $user->delete();

            session()->flash('message', __('admin.users.deleted_success'));
        } catch (\Exception $e) {
            session()->flash('error', __('admin.users.delete_error') . ': ' . $e->getMessage());
            Log::error('Errore eliminazione utente', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function deletePeerTubeAccount(User $user)
    {
        // TODO: Implementare eliminazione account PeerTube
    }

    private function deleteUserFiles(User $user)
    {
        // TODO: Implementare eliminazione file utente
    }

    public function getStatsProperty()
    {
        $allUsers = User::all();
        $adminCount = $allUsers->filter(function($u) {
            return $u->hasRole('admin');
        })->count();
        
        return [
            'total' => User::count(),
            'active' => User::where('status', 'active')->orWhereNull('status')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
            'banned' => User::where('status', 'banned')->count(),
            'admins' => $adminCount,
        ];
    }

    public function render()
    {
        $query = User::query()->orderBy($this->sortBy, $this->sortDirection);

        // Filtri
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('nickname', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'all') {
            if ($this->status === 'active') {
                $query->where(function($q) {
                    $q->where('status', 'active')->orWhereNull('status');
                });
            } else {
                $query->where('status', $this->status);
            }
        }

        // Filtro per ruolo - dobbiamo filtrare in memoria perché non c'è relazione
        $users = $query->get();
        
        if ($this->role !== 'all') {
            $users = $users->filter(function($user) {
                return $user->hasRole($this->role);
            });
        }

        // Paginazione manuale
        $currentPage = $this->getPage();
        $perPage = 12;
        $items = $users->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $usersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $users->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.admin.users.user-list', [
            'users' => $usersPaginated,
        ])->layout('components.layouts.app');
    }
}
