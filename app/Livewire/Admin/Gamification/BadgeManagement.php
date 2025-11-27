<?php

namespace App\Livewire\Admin\Gamification;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Badge;
use App\Models\User;
use App\Services\BadgeService;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LanguageHelper;

class BadgeManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $badges;
    public $badge;
    public $isEditing = false;
    public $showModal = false;
    
    // Badge form fields
    public $type = 'portal';
    public $name;
    public $description;
    public $category;
    public $criteria_type = 'count';
    public $criteria_value = 1;
    public $points = 10;
    public $order = 0;
    public $is_active = true;
    public $icon;
    public $existing_icon;
    
    // Translations
    public $translations = [];
    public $availableLocales = [];

    // Manual assignment
    public $showAssignModal = false;
    public $selectedBadgeId;
    public $userId;
    public $userSearch = '';
    public $searchResults = [];
    public $selectedUser = null;
    public $assignNotes;

    protected $rules = [
        'type' => 'required|in:portal,event',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|string',
        'criteria_type' => 'required|in:count,milestone,first_time,streak,special',
        'criteria_value' => 'required|integer|min:1',
        'points' => 'required|integer|min:0',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean',
        'icon' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $this->loadBadges();
        // Load locales only once at mount
        $this->availableLocales = LanguageHelper::getAvailableLocales();
    }

    public function initializeTranslations()
    {
        // Initialize translations array for all locales
        $this->translations = [];
        foreach ($this->availableLocales as $locale) {
            $this->translations[$locale] = ['name' => '', 'description' => ''];
        }
    }

    public function loadBadges()
    {
        $this->badges = Badge::with('translations')
            ->orderBy('type')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($badgeId)
    {
        $badge = Badge::with('translations')->findOrFail($badgeId);
        
        $this->badge = $badge;
        $this->type = $badge->type;
        $this->name = $badge->name;
        $this->description = $badge->description;
        $this->category = $badge->category;
        $this->criteria_type = $badge->criteria_type;
        $this->criteria_value = $badge->criteria_value;
        $this->points = $badge->points;
        $this->order = $badge->order;
        $this->is_active = $badge->is_active;
        $this->existing_icon = $badge->icon_path;
        
        // Initialize translations for all locales
        $this->initializeTranslations();
        
        // Load existing translations
        foreach ($badge->translations as $translation) {
            $this->translations[$translation->locale] = [
                'name' => $translation->name,
                'description' => $translation->description,
            ];
        }
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $iconPath = $this->existing_icon;
        
        if ($this->icon) {
            $iconPath = $this->icon->store('badges', 'public');
            
            // Delete old icon if exists and not default
            if ($this->existing_icon && $this->existing_icon !== 'assets/images/draghetto.png') {
                Storage::disk('public')->delete($this->existing_icon);
            }
        }

        $data = [
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'criteria_type' => $this->criteria_type,
            'criteria_value' => $this->criteria_value,
            'points' => $this->points,
            'order' => $this->order,
            'is_active' => $this->is_active,
            'icon_path' => $iconPath ?: 'assets/images/draghetto.png',
        ];

        if ($this->isEditing) {
            $this->badge->update($data);
            $badge = $this->badge;
            session()->flash('message', __('gamification.badge_updated'));
        } else {
            $badge = Badge::create($data);
            session()->flash('message', __('gamification.badge_created'));
        }

        // Save translations
        foreach ($this->translations as $locale => $translation) {
            if (!empty($translation['name'])) {
                $badge->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'name' => $translation['name'],
                        'description' => $translation['description'] ?? '',
                    ]
                );
            }
        }

        $this->loadBadges();
        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($badgeId)
    {
        $badge = Badge::findOrFail($badgeId);
        
        // Delete icon if not default
        if ($badge->icon_path && $badge->icon_path !== 'assets/images/draghetto.png') {
            Storage::disk('public')->delete($badge->icon_path);
        }
        
        $badge->delete();
        
        session()->flash('message', __('gamification.badge_deleted'));
        $this->loadBadges();
    }

    public function toggleActive($badgeId)
    {
        $badge = Badge::findOrFail($badgeId);
        $badge->update(['is_active' => !$badge->is_active]);
        $this->loadBadges();
    }

    public function openAssignModal($badgeId)
    {
        $this->selectedBadgeId = $badgeId;
        $this->showAssignModal = true;
        $this->userSearch = '';
        $this->searchResults = [];
        $this->selectedUser = null;
        $this->assignNotes = '';
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->selectedBadgeId = null;
        $this->userSearch = '';
        $this->searchResults = [];
        $this->selectedUser = null;
        $this->assignNotes = '';
    }

    public function searchUsers()
    {
        if (strlen($this->userSearch) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = User::where('name', 'like', '%' . $this->userSearch . '%')
            ->orWhere('nickname', 'like', '%' . $this->userSearch . '%')
            ->orWhere('email', 'like', '%' . $this->userSearch . '%')
            ->limit(10)
            ->get();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->userSearch = $this->selectedUser->name;
        $this->searchResults = [];
    }

    public function assignBadge()
    {
        if (!$this->selectedUser || !$this->selectedBadgeId) {
            return;
        }

        $user = $this->selectedUser;
        $badge = Badge::findOrFail($this->selectedBadgeId);
        $badgeService = app(BadgeService::class);

        $result = $badgeService->manuallyAwardBadge($user, $badge, auth()->user(), $this->assignNotes);

        if ($result) {
            session()->flash('message', __('gamification.badge_assigned', ['user' => $user->name, 'badge' => $badge->name]));
            $this->closeAssignModal();
        } else {
            session()->flash('error', __('gamification.badge_already_owned'));
        }
    }

    protected function resetForm()
    {
        $this->type = 'portal';
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->criteria_type = 'count';
        $this->criteria_value = 1;
        $this->points = 10;
        $this->order = 0;
        $this->is_active = true;
        $this->icon = null;
        $this->existing_icon = null;
        
        // Reset translations
        $this->initializeTranslations();
    }

    public function render()
    {
        return view('livewire.admin.gamification.badge-management')
            ->layout('components.layouts.app');
    }
}

