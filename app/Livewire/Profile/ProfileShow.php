<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileShow extends Component
{

    public $userId;

    public function mount($user = null)
    {
        if ($user) {
            if (is_object($user) && isset($user->id)) {
                $this->userId = (int) $user->id;
            } else {
                $userModel = null;
                
                if (is_numeric($user)) {
                    $userModel = User::find($user);
                }
                
                if (!$userModel) {
                    $userModel = User::where('nickname', $user)->first();
                }
                
                if ($userModel) {
                    $this->userId = (int) $userModel->id;
                } else {
                    abort(404, 'User not found');
                }
            }
        } else {
            $this->userId = (int) Auth::id();
        }
    }

    public function getUserProperty()
    {
        return User::findOrFail((int) $this->userId);
    }

    public function getIsOwnProfileProperty()
    {
        return (int) $this->userId === (int) Auth::id();
    }

    public function getPhotosProperty()
    {
        return $this->user->photos()
            ->approved()
            ->where('moderation_status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
    }

    public function getVideosProperty()
    {
        return $this->user->videos()
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
    }

    public function getArticlesProperty()
    {
        return $this->user->articles()
            ->published()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }

    public function getPoemsProperty()
    {
        return $this->user->poems()
            ->published()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
    }

    public function getEventsProperty()
    {
        return $this->user->events()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
    }

    public function getActivitiesProperty()
    {
        return $this->user->activities()
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'activities_page');
    }

    public function getTopBadgesProperty()
    {
        return $this->user->userBadges()
            ->with('badge')
            ->where('show_in_profile', true)
            ->orderBy('profile_order', 'asc')
            ->limit(3)
            ->get();
    }

    public function getStatsProperty()
    {
        return [
            'photos' => $this->user->photos()->approved()->where('moderation_status', 'approved')->count(),
            'videos' => $this->user->videos()->where('status', 'approved')->count(),
            'articles' => $this->user->articles()->published()->count(),
            'poems' => $this->user->poems()->published()->count(),
            'events' => $this->user->events()->count(),
            'followers' => $this->user->followers()->count(),
            'following' => $this->user->following()->count(),
            'total_views' => $this->user->photos()->approved()->sum('view_count') + 
                           $this->user->videos()->where('status', 'approved')->sum('view_count') + 
                           $this->user->articles()->published()->sum('view_count') + 
                           $this->user->poems()->published()->sum('view_count'),
            'total_likes' => $this->user->photos()->approved()->sum('like_count') + 
                           $this->user->videos()->where('status', 'approved')->sum('like_count') + 
                           $this->user->articles()->published()->sum('like_count') + 
                           $this->user->poems()->published()->sum('like_count'),
        ];
    }

    public function render()
    {
        return view('livewire.profile.profile-show', [
            'user' => $this->user,
            'isOwnProfile' => $this->isOwnProfile,
            'stats' => $this->stats,
            'photos' => $this->photos,
            'videos' => $this->videos,
            'articles' => $this->articles,
            'poems' => $this->poems,
            'events' => $this->events,
            'topBadges' => $this->topBadges,
        ])->layout('components.layouts.app');
    }
}

