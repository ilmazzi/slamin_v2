<?php

namespace App\Livewire\Groups;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Title('Gruppi - Community')]
class GroupIndex extends Component
{
    use WithPagination;

    public $activeTab = 'groups';
    
    // Groups Filters
    public $groupSearch = '';
    public $groupFilter = '';
    
    // Users Filters
    public $userSearch = '';
    public $userFilter = '';

    protected $queryString = [
        'activeTab' => ['except' => 'groups'],
        'groupSearch' => ['except' => '', 'as' => 'gs'],
        'groupFilter' => ['except' => '', 'as' => 'gf'],
        'userSearch' => ['except' => '', 'as' => 'us'],
        'userFilter' => ['except' => '', 'as' => 'uf'],
    ];

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedGroupSearch()
    {
        $this->resetPage('groupsPage');
    }

    public function updatedGroupFilter()
    {
        $this->resetPage('groupsPage');
    }

    public function updatedUserSearch()
    {
        $this->resetPage('usersPage');
    }

    public function updatedUserFilter()
    {
        $this->resetPage('usersPage');
    }

    public function clearGroupFilters()
    {
        $this->groupSearch = '';
        $this->groupFilter = '';
        $this->resetPage('groupsPage');
    }

    public function clearUserFilters()
    {
        $this->userSearch = '';
        $this->userFilter = '';
        $this->resetPage('usersPage');
    }

    public function getGroupsProperty()
    {
        $user = Auth::user();
        $query = Group::query();

        // Apply filters
        if ($this->groupFilter) {
            switch ($this->groupFilter) {
                case 'my_groups':
                    if ($user) {
                        $query->whereHas('members', function($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                    } else {
                        // If not authenticated, return empty result
                        $query->whereRaw('1 = 0');
                    }
                    break;
                case 'my_admin_groups':
                    if ($user) {
                        $query->whereHas('members', function($q) use ($user) {
                            $q->where('user_id', $user->id)->where('role', 'admin');
                        });
                    } else {
                        // If not authenticated, return empty result
                        $query->whereRaw('1 = 0');
                    }
                    break;
                case 'public':
                    $query->where('visibility', 'public');
                    break;
                case 'private':
                    if ($user && $user->hasRole('admin')) {
                        $query->where('visibility', 'private');
                    } else {
                        // If not authenticated or not admin, return empty result
                        $query->whereRaw('1 = 0');
                    }
                    break;
            }
        } else {
            if ($user) {
                $query->where(function($q) use ($user) {
                    $q->where('visibility', 'public')
                      ->orWhereHas('members', function($q2) use ($user) {
                          $q2->where('user_id', $user->id);
                      });
                });
            } else {
                $query->where('visibility', 'public');
            }
        }

        // Apply search
        if ($this->groupSearch) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->groupSearch}%")
                  ->orWhere('description', 'like', "%{$this->groupSearch}%");
            });
        }

        return $query->with(['creator', 'members.user'])
                    ->withCount('members')
                    ->latest()
                    ->paginate(12, ['*'], 'groupsPage');
    }

    public function getUsersProperty()
    {
        $query = User::query();

        // Apply filters
        if ($this->userFilter) {
            switch ($this->userFilter) {
                case 'poets':
                    $query->whereHas('roles', function($q) {
                        $q->where('name', 'poet');
                    });
                    break;
                case 'organizers':
                    $query->whereHas('roles', function($q) {
                        $q->where('name', 'organizer');
                    });
                    break;
            }
        }

        // Apply search
        if ($this->userSearch) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->userSearch}%")
                  ->orWhere('nickname', 'like', "%{$this->userSearch}%");
            });
        }

        return $query->with(['roles'])
                    ->withCount(['poems', 'articles'])
                    ->latest()
                    ->paginate(12, ['*'], 'usersPage');
    }

    public function render()
    {
        return view('livewire.groups.group-index', [
            'groups' => $this->groups,
            'users' => $this->users,
        ]);
    }
}
