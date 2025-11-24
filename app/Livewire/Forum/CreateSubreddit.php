<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Models\Subreddit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateSubreddit extends Component
{
    use WithFileUploads;

    public $name = '';
    public $slug = '';
    public $description = '';
    public $rules = '';
    public $color = '#007bff';
    public $is_private = false;

    #[Title('Crea Subreddit - Forum')]

    public function mount()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        // Check if user can create subreddits (you can add permission check here)
        if (!Auth::user()->canCreateSubreddit()) {
            abort(403, 'Non hai i permessi per creare subreddit');
        }
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function createSubreddit()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:50|unique:subreddits,name',
            'slug' => 'required|string|min:3|max:50|unique:subreddits,slug|regex:/^[a-z0-9-]+$/',
            'description' => 'required|string|min:10|max:500',
            'rules' => 'nullable|string|max:5000',
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_private' => 'boolean',
        ]);

        $subreddit = Subreddit::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'rules' => $this->rules,
            'color' => $this->color,
            'created_by' => Auth::id(),
            'is_private' => $this->is_private,
        ]);

        // Make creator an admin
        $subreddit->moderators()->create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'added_by' => Auth::id(),
        ]);

        // Auto-subscribe creator
        $subreddit->subscribers()->attach(Auth::id());
        $subreddit->incrementSubscribersCount();

        return $this->redirect(route('forum.subreddit.show', $subreddit), navigate: true);
    }

    public function render()
    {
        return view('livewire.forum.create-subreddit');
    }
}

