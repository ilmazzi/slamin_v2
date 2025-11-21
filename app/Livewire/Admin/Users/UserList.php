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
        $user = User::findOrFail($userId);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->nickname = $user->nickname ?? '';
        $this->userStatus = $user->status ?? 'active';
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
            'userStatus' => 'required|in:active,inactive,suspended,banned',
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
