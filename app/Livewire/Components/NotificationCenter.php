<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
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

    /**
     * Get the listeners for Echo events
     * Livewire automatically listens to private channels with echo-private: prefix
     */
    protected function getListeners()
    {
        if (!Auth::check()) {
            return [];
        }

        return [
            "echo-private:App.Models.User." . Auth::id() . ",.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'notificationReceived',
        ];
    }

    /**
     * Handle incoming notification from broadcast
     */
    public function notificationReceived($event)
    {
        $this->loadNotifications();
        // Emette evento per attivare l'animazione della busta
        $this->dispatch('refresh-notifications');
        $this->dispatch('notification-received');
    }

    /**
     * Refresh notifications (can be called from other components)
     */
    #[On('refresh-notifications')]
    public function loadNotifications()
    {
        if (!Auth::check()) {
            return;
        }

        $this->notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
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
