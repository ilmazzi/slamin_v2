<?php

namespace App\Livewire\Admin\Subreddits;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;
use App\Models\Subreddit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubredditList extends Component
{
    use WithPagination, WithFileUploads;

    #[Url]
    public $search = '';

    // Modal create/edit
    public $showModal = false;
    public $isEditing = false;
    public $editingSubredditId = null;

    // Form fields
    public $name = '';
    public $slug = '';
    public $description = '';
    public $rules = '';
    public $icon = '';
    public $banner;
    public $existing_banner = null;
    public $color = '#059669';
    public $is_active = true;
    public $is_private = false;

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

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($subredditId)
    {
        $subreddit = Subreddit::findOrFail($subredditId);
        $this->editingSubredditId = $subreddit->id;
        $this->name = $subreddit->name ?? '';
        $this->slug = $subreddit->slug ?? '';
        $this->description = $subreddit->description ?? '';
        $this->rules = $subreddit->rules ?? '';
        $this->icon = $subreddit->icon ?? '';
        $this->existing_banner = $subreddit->banner;
        $this->color = $subreddit->color ?? '#059669';
        $this->is_active = $subreddit->is_active ?? true;
        $this->is_private = $subreddit->is_private ?? false;
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->isEditing = false;
        $this->editingSubredditId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'name', 'slug', 'description', 'rules', 'icon',
            'banner', 'existing_banner', 'color', 'is_active', 'is_private'
        ]);
    }

    public function updatedName()
    {
        if (!$this->isEditing && !empty($this->name)) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subreddits,slug,' . ($this->editingSubredditId ?? ''),
            'description' => 'nullable|string|max:1000',
            'rules' => 'nullable|string|max:5000',
            'icon' => 'nullable|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'is_private' => 'boolean',
        ]);

        try {
            $data = [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'rules' => $this->rules,
                'icon' => $this->icon,
                'color' => $this->color,
                'is_active' => $this->is_active,
                'is_private' => $this->is_private,
                'created_by' => Auth::id(),
            ];

            if ($this->banner) {
                if ($this->existing_banner) {
                    Storage::disk('public')->delete($this->existing_banner);
                }
                $data['banner'] = $this->banner->store('subreddits', 'public');
            }

            if ($this->isEditing) {
                $subreddit = Subreddit::findOrFail($this->editingSubredditId);
                $subreddit->update($data);
            } else {
                $subreddit = Subreddit::create($data);
            }

            session()->flash('message', $this->isEditing ? __('admin.sections.subreddits.messages.updated') : __('admin.sections.subreddits.messages.created'));
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Errore durante il salvataggio: ' . $e->getMessage());
        }
    }

    public function delete($subredditId)
    {
        $subreddit = Subreddit::findOrFail($subredditId);

        if ($subreddit->banner) {
            Storage::disk('public')->delete($subreddit->banner);
        }

        $subreddit->delete();

        session()->flash('message', __('admin.sections.subreddits.messages.deleted'));
    }

    public function toggleActive($subredditId)
    {
        $subreddit = Subreddit::findOrFail($subredditId);
        $subreddit->update(['is_active' => !$subreddit->is_active]);
        session()->flash('message', $subreddit->is_active ? __('admin.sections.subreddits.messages.activated') : __('admin.sections.subreddits.messages.deactivated'));
    }

    public function render()
    {
        $query = Subreddit::query()
            ->with('creator')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
        }

        $subreddits = $query->paginate(20);

        return view('livewire.admin.subreddits.subreddit-list', [
            'subreddits' => $subreddits,
        ])->layout('components.layouts.app');
    }
}
