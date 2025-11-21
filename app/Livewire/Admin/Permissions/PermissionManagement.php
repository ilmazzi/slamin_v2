<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PermissionManagement extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $group = 'all';

    #[Url]
    public $sortBy = 'name';
    #[Url]
    public $sortDirection = 'asc';

    // Modal edit/create
    public $showModal = false;
    public $editingPermission = null;
    
    // Form fields
    public $name = '';
    public $display_name = '';
    public $description = '';
    public $guard_name = 'web';
    public $permissionGroup = '';

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

    public function updatingGroup()
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

    public function getAvailableGroupsProperty()
    {
        return Permission::select('group')
            ->distinct()
            ->whereNotNull('group')
            ->orderBy('group')
            ->pluck('group')
            ->toArray();
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'display_name', 'description', 'guard_name', 'permissionGroup', 'editingPermission']);
        $this->showModal = true;
    }

    public function openEditModal($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        $this->editingPermission = $permission;
        $this->name = $permission->name;
        $this->display_name = $permission->display_name ?? '';
        $this->description = $permission->description ?? '';
        $this->guard_name = $permission->guard_name ?? 'web';
        $this->permissionGroup = $permission->group ?? '';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['name', 'display_name', 'description', 'guard_name', 'permissionGroup', 'editingPermission']);
    }

    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z.]+$/',
                Rule::unique('permissions', 'name')->ignore($this->editingPermission?->id)
            ],
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'guard_name' => 'required|string|max:255',
            'permissionGroup' => 'nullable|string|max:255',
        ], [
            'name.regex' => __('admin.permissions.name_regex_error'),
        ]);

        try {
            if ($this->editingPermission) {
                // Update
                $this->editingPermission->update([
                    'name' => $this->name,
                    'display_name' => $this->display_name,
                    'description' => $this->description,
                    'guard_name' => $this->guard_name,
                    'group' => $this->permissionGroup,
                ]);
                
                session()->flash('message', __('admin.permissions.updated_success'));
            } else {
                // Create
                Permission::create([
                    'name' => $this->name,
                    'display_name' => $this->display_name,
                    'description' => $this->description,
                    'guard_name' => $this->guard_name,
                    'group' => $this->permissionGroup,
                ]);
                
                session()->flash('message', __('admin.permissions.created_success'));
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', __('admin.permissions.save_error') . ': ' . $e->getMessage());
        }
    }

    public function deletePermission($permissionId)
    {
        $permission = Permission::findOrFail($permissionId);
        
        // Check if permission is assigned to any role
        $rolesCount = DB::table('role_has_permissions')
            ->where('permission_id', $permissionId)
            ->count();
        
        // Check if permission is assigned directly to any user
        $usersCount = DB::table('model_has_permissions')
            ->where('permission_id', $permissionId)
            ->count();
        
        if ($rolesCount > 0 || $usersCount > 0) {
            session()->flash('error', __('admin.permissions.cannot_delete_in_use', [
                'roles' => $rolesCount,
                'users' => $usersCount
            ]));
            return;
        }

        try {
            $permission->delete();
            session()->flash('message', __('admin.permissions.deleted_success'));
        } catch (\Exception $e) {
            session()->flash('error', __('admin.permissions.delete_error') . ': ' . $e->getMessage());
        }
    }

    public function getStatsProperty()
    {
        $allPermissions = Permission::all();
        $stats = [
            'total' => $allPermissions->count(),
            'by_group' => $allPermissions->groupBy('group')->map(function($group) {
                return $group->count();
            })->toArray(),
        ];

        return $stats;
    }

    public function render()
    {
        $query = Permission::query()->withCount(['roles', 'users']);

        // Filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('display_name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->group !== 'all') {
            $query->where('group', $this->group);
        }

        // Sort
        $query->orderBy($this->sortBy, $this->sortDirection);

        $permissions = $query->paginate(15);

        return view('livewire.admin.permissions.permission-management', [
            'permissions' => $permissions,
        ])->layout('components.layouts.app');
    }
}

