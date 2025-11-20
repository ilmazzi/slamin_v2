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
    
    // Form fields
    public $name = '';
    public $email = '';
    public $nickname = '';
    public $userStatus = 'active';
    public $roles = [];
    public $permissions = [];

    // Available roles and permissions (computed)
    public function getAvailableRolesProperty()
    {
        // TODO: Implementare quando Role model sarà disponibile
        return collect([]);
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
        $user = User::with(['roles', 'permissions'])->findOrFail($userId);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nickname = $user->nickname ?? '';
        $this->userStatus = $user->status ?? 'active';
        // TODO: Implementare quando roles/permissions saranno disponibili
        // $this->roles = $user->roles->pluck('id')->toArray();
        // $this->permissions = $user->permissions->pluck('id')->toArray();
        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingUser = null;
        $this->reset(['name', 'email', 'nickname', 'userStatus', 'roles', 'permissions']);
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
            'userStatus' => 'required|in:active,inactive',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $this->editingUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'nickname' => $this->nickname,
            'status' => $this->userStatus,
        ]);

        // TODO: Implementare quando roles/permissions saranno disponibili
        // if (!empty($this->roles)) {
        //     $this->editingUser->syncRoles($this->roles);
        // }
        // if (!empty($this->permissions)) {
        //     $this->editingUser->syncPermissions($this->permissions);
        // }

        session()->flash('message', 'Utente aggiornato con successo');
        $this->closeEditModal();
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $currentUser = Auth::user();

        // Controlli sicurezza
        if ($user->hasRole('admin') && !$currentUser->hasRole('super-admin') && User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->count() <= 1) {
            session()->flash('error', 'Non puoi eliminare l\'ultimo admin');
            return;
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

            session()->flash('message', 'Utente eliminato con successo');
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante l\'eliminazione: ' . $e->getMessage());
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
        return [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'admins' => User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->count(),
        ];
    }

    public function render()
    {
        $query = User::query()
            ->with(['roles', 'permissions'])
            ->orderBy($this->sortBy, $this->sortDirection);

        // Filtri
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('nickname', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        if ($this->role !== 'all') {
            $query->whereHas('roles', function($q) {
                $q->where('name', $this->role);
            });
        }

        $users = $query->paginate(12);

        return view('livewire.admin.users.user-list', [
            'users' => $users,
        ])->layout('components.layouts.app');
    }
}
