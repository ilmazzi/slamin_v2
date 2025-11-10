<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationCenter extends Component
{
    public $showPanel = false;
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        if (Auth::check()) {
            $this->loadNotifications();
        }
    }

    public function loadNotifications()
    {
        if (!Auth::check()) {
            return;
        }

        $this->notifications = Auth::user()
            ->notifications()
            ->take(10)
            ->get();

        $this->unreadCount = Auth::user()
            ->unreadNotifications()
            ->count();
    }

    public function togglePanel()
    {
        $this->showPanel = !$this->showPanel;
        
        if ($this->showPanel) {
            $this->loadNotifications();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()
            ->notifications()
            ->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()
            ->notifications()
            ->find($notificationId);

        if ($notification) {
            $notification->delete();
            $this->loadNotifications();
        }
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.components.notification-center');
    }
}
