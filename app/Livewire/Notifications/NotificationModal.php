<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class NotificationModal extends Component
{
    public $showModal = false;
    public $notifications = [];
    public $unreadCount = 0;

    #[On('open-notification-modal')]
    public function openModal()
    {
        $this->showModal = true;
        $this->loadNotifications();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function loadNotifications()
    {
        if (!Auth::check()) {
            return;
        }

        $this->notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->data['title'] ?? 'Notifica',
                    'message' => $notification->data['message'] ?? '',
                    'icon' => $notification->data['icon'] ?? '🔔',
                    'url' => $notification->data['url'] ?? '#',
                    'read' => $notification->read_at !== null,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'sender_name' => $notification->data['sender_name'] ?? null,
                ];
            });

        $this->unreadCount = Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->dispatch('refresh-notifications');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
        $this->dispatch('refresh-notifications');
    }

    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->delete();
            $this->loadNotifications();
            $this->dispatch('refresh-notifications');
        }
    }

    public function render()
    {
        return view('livewire.notifications.notification-modal');
    }
}
