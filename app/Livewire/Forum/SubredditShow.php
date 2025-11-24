<?php

namespace App\Livewire\Forum;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Subreddit;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Auth;

class SubredditShow extends Component
{
    use WithPagination;

    public Subreddit $subreddit;
    public $sortBy = 'hot'; // hot, new, top
    public $timeFilter = 'all'; // all, today, week, month, year

    public function mount(Subreddit $subreddit)
    {
        $this->subreddit = $subreddit;

        // Check if user can view
        if ($subreddit->is_private && !Auth::check()) {
            abort(403, 'Questo subreddit è privato');
        }

        if ($subreddit->is_private && !$subreddit->isSubscribed(Auth::user()) && !$subreddit->isModerator(Auth::user())) {
            abort(403, 'Devi essere iscritto per visualizzare questo subreddit');
        }
    }

    public function title(): string
    {
        return $this->subreddit->name . ' - Forum';
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedTimeFilter()
    {
        $this->resetPage();
    }

    public function getPostsProperty()
    {
        $query = $this->subreddit->posts()->with(['user', 'subreddit']);

        // Time filter
        if ($this->timeFilter !== 'all') {
            $date = match ($this->timeFilter) {
                'today' => now()->subDay(),
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                'year' => now()->subYear(),
                default => null,
            };

            if ($date) {
                $query->where('created_at', '>=', $date);
            }
        }

        // Sort
        switch ($this->sortBy) {
            case 'new':
                $query->latest();
                break;
            case 'top':
                $query->orderBy('score', 'desc');
                break;
            case 'hot':
            default:
                // Hot algorithm: score / (age_in_hours + 2)^1.5
                $query->selectRaw('forum_posts.*, (score / POW((TIMESTAMPDIFF(HOUR, created_at, NOW()) + 2), 1.5)) as hotness')
                      ->orderBy('is_sticky', 'desc')
                      ->orderBy('hotness', 'desc');
                break;
        }

        return $query->paginate(15);
    }

    public function getIsSubscribedProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->subreddit->isSubscribed(Auth::user());
    }

    public function getIsModeratorProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->subreddit->isModerator(Auth::user());
    }

    public function subscribe()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        if ($this->isSubscribed) {
            $this->subreddit->subscribers()->detach(Auth::id());
            $this->subreddit->decrementSubscribersCount();
            session()->flash('success', 'Disiscritto da ' . $this->subreddit->name);
        } else {
            $this->subreddit->subscribers()->attach(Auth::id());
            $this->subreddit->incrementSubscribersCount();
            session()->flash('success', 'Iscritto a ' . $this->subreddit->name);
        }

        $this->subreddit->refresh();
    }

    public function render()
    {
        return view('livewire.forum.subreddit-show', [
            'posts' => $this->posts,
            'isSubscribed' => $this->isSubscribed,
            'isModerator' => $this->isModerator,
        ]);
    }
}

