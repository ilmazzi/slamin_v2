<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleManagement extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $sortBy = 'name';
    #[Url]
    public $sortDirection = 'asc';

    // Modal edit/create
    public $showModal = false;
    public $editingRole = null;
    
    // Form fields
    public $name = '';
    public $display_name = '';
    public $description = '';
    public $guard_name = 'web';
    public $permissions = [];

    // Permission groups for display
    public $permissionGroups = [];

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }
        $this->loadPermissionGroups();
    }

    public function updatingSearch()
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

    private function loadPermissionGroups()
    {
        $allPermissions = Permission::orderBy('group')->orderBy('name')->get();
        $groups = [];
        
        foreach ($allPermissions as $permission) {
            $group = $permission->group ?? 'general';
            if (!isset($groups[$group])) {
                $groups[$group] = [];
            }
            $groups[$group][] = $permission;
        }
        
        $this->permissionGroups = $groups;
    }

    public function getAvailablePermissionsProperty()
    {
        return Permission::orderBy('group')->orderBy('name')->get();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'display_name', 'description', 'guard_name', 'permissions', 'editingRole']);
        $this->showModal = true;
    }

    public function openEditModal($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $this->editingRole = $role;
        $this->name = $role->name;
        $this->display_name = $role->display_name ?? '';
        $this->description = $role->description ?? '';
        $this->guard_name = $role->guard_name ?? 'web';
        $this->permissions = $role->permissions->pluck('id')->toArray();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'display_name', 'description', 'guard_name', 'permissions', 'editingRole']);
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z_]+$/',
                Rule::unique('roles', 'name')->ignore($this->editingRole?->id)
            ],
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'guard_name' => 'required|string|max:255',
            'permissions' => 'array',
        ], [
            'name.regex' => __('admin.roles.name_regex_error'),
        ]);

        try {
            DB::beginTransaction();

            if ($this->editingRole) {
                // Update
                $this->editingRole->update([
                    'name' => $this->name,
                    'display_name' => $this->display_name,
                    'description' => $this->description,
                    'guard_name' => $this->guard_name,
                ]);
                
                // Sync permissions
                if (is_array($this->permissions)) {
                    $this->editingRole->syncPermissions($this->permissions);
                }
                
                session()->flash('message', __('admin.roles.updated_success'));
            } else {
                // Create
                $role = Role::create([
                    'name' => $this->name,
                    'display_name' => $this->display_name,
                    'description' => $this->description,
                    'guard_name' => $this->guard_name,
                ]);
                
                // Attach permissions
                if (is_array($this->permissions) && !empty($this->permissions)) {
                    $role->syncPermissions($this->permissions);
                }
                
                session()->flash('message', __('admin.roles.created_success'));
            }

            DB::commit();
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('admin.roles.save_error') . ': ' . $e->getMessage());
        }
    }

    public function deleteRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        
        // Prevent deleting admin role
        if ($role->name === 'admin') {
            session()->flash('error', __('admin.roles.cannot_delete_admin'));
            return;
        }

        // Check if role has users
        $usersCount = DB::table('model_has_roles')
            ->where('role_id', $roleId)
            ->count();
        
        if ($usersCount > 0) {
            session()->flash('error', __('admin.roles.cannot_delete_in_use', ['count' => $usersCount]));
            return;
        }

        try {
            $role->delete();
            session()->flash('message', __('admin.roles.deleted_success'));
        } catch (\Exception $e) {
            session()->flash('error', __('admin.roles.delete_error') . ': ' . $e->getMessage());
        }
    }

    public function getStatsProperty()
    {
        $allRoles = Role::all();
        $stats = [
            'total' => $allRoles->count(),
            'with_permissions' => $allRoles->filter(function($role) {
                return $role->permissions()->count() > 0;
            })->count(),
            'total_users' => 0,
        ];

        foreach ($allRoles as $role) {
            $stats['total_users'] += DB::table('model_has_roles')
                ->where('role_id', $role->id)
                ->count();
        }

        return $stats;
    }

    public function render()
    {
        $query = Role::query()->withCount(['users', 'permissions']);

        // Filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('display_name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Sort
        $query->orderBy($this->sortBy, $this->sortDirection);

        $roles = $query->paginate(12);

        return view('livewire.admin.roles.role-management', [
            'roles' => $roles,
        ])->layout('components.layouts.app');
    }
}

