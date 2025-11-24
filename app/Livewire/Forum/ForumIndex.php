<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Subreddit;
use Illuminate\Support\Facades\Auth;

class ForumIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'popular'; // popular, new, active
    public $showCreateModal = false;

    #[Title('Forum - Slamin')]

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function getSubredditsProperty()
    {
        $query = Subreddit::where('is_active', true);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Sort
        switch ($this->sortBy) {
            case 'new':
                $query->latest();
                break;
            case 'active':
                $query->orderBy('posts_count', 'desc');
                break;
            case 'popular':
            default:
                $query->orderBy('subscribers_count', 'desc');
                break;
        }

        return $query->withCount(['posts', 'subscribers'])->paginate(12);
    }

    public function getMySubredditsProperty()
    {
        if (!Auth::check()) {
            return collect();
        }

        return Auth::user()->subscribedSubreddits()
            ->where('is_active', true)
            ->withCount(['posts', 'subscribers'])
            ->limit(5)
            ->get();
    }

    public function subscribe($subredditId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $subreddit = Subreddit::findOrFail($subredditId);

        if ($subreddit->isSubscribed(Auth::user())) {
            $subreddit->subscribers()->detach(Auth::id());
            $subreddit->decrementSubscribersCount();
            session()->flash('success', 'Disiscritto da ' . $subreddit->name);
        } else {
            $subreddit->subscribers()->attach(Auth::id());
            $subreddit->incrementSubscribersCount();
            session()->flash('success', 'Iscritto a ' . $subreddit->name);
        }
    }

    public function render()
    {
        return view('livewire.forum.forum-index', [
            'subreddits' => $this->subreddits,
            'mySubreddits' => $this->mySubreddits,
        ]);
    }
}

