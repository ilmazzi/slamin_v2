<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ModerationSettings extends Component
{
    public $autoApprovePoems = false;
    public $autoApproveArticles = false;
    public $autoApprovePhotos = false;
    public $autoApproveVideos = false;
    public $autoApproveEvents = false;
    public $autoApproveGigs = false;
    public $autoApproveForumPosts = false;
    public $autoApproveForumComments = false;

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403, 'Accesso negato');
        }

        // Load current settings from cache
        $this->autoApprovePoems = Cache::get('moderation.auto_approve.poems', false);
        $this->autoApproveArticles = Cache::get('moderation.auto_approve.articles', false);
        $this->autoApprovePhotos = Cache::get('moderation.auto_approve.photos', false);
        $this->autoApproveVideos = Cache::get('moderation.auto_approve.videos', false);
        $this->autoApproveEvents = Cache::get('moderation.auto_approve.events', false);
        $this->autoApproveGigs = Cache::get('moderation.auto_approve.gigs', false);
        $this->autoApproveForumPosts = Cache::get('moderation.auto_approve.forum_posts', false);
        $this->autoApproveForumComments = Cache::get('moderation.auto_approve.forum_comments', false);
    }

    public function save()
    {
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            session()->flash('error', 'Non autorizzato');
            return;
        }

        // Save to cache (since we can't modify config files at runtime)
        Cache::forever('moderation.auto_approve.poems', $this->autoApprovePoems);
        Cache::forever('moderation.auto_approve.articles', $this->autoApproveArticles);
        Cache::forever('moderation.auto_approve.photos', $this->autoApprovePhotos);
        Cache::forever('moderation.auto_approve.videos', $this->autoApproveVideos);
        Cache::forever('moderation.auto_approve.events', $this->autoApproveEvents);
        Cache::forever('moderation.auto_approve.gigs', $this->autoApproveGigs);
        Cache::forever('moderation.auto_approve.forum_posts', $this->autoApproveForumPosts);
        Cache::forever('moderation.auto_approve.forum_comments', $this->autoApproveForumComments);

        session()->flash('success', 'Impostazioni di moderazione salvate con successo');
    }

    public function render()
    {
        return view('livewire.admin.settings.moderation-settings')
            ->layout('components.layouts.app');
    }
}
