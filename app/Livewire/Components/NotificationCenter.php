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
        \Log::info('🔔 NotificationCenter received broadcast', [
            'full_event' => json_encode($event),
            'event_type' => gettype($event),
            'event_keys' => is_array($event) ? array_keys($event) : 'not_array',
        ]);
        
        $this->loadNotifications();
        
        // Check if it's a chat message - don't trigger animation for chat
        // Try multiple possible structures
        $notificationType = null;
        
        if (is_array($event)) {
            $notificationType = $event['type'] ?? ($event['data']['type'] ?? null);
        }
        
        \Log::info('🔍 Checking notification type', [
            'extracted_type' => $notificationType,
            'is_chat' => $notificationType === 'chat_new_message',
            'comparison' => [
                'type' => $notificationType,
                'expected' => 'chat_new_message',
                'match' => $notificationType === 'chat_new_message'
            ]
        ]);
        
        if ($notificationType === 'chat_new_message') {
            \Log::info('✅ Chat message detected - SKIPPING animation dispatch');
            return;
        }
        
        \Log::info('⚠️ Non-chat notification - DISPATCHING animation event', [
            'type' => $notificationType
        ]);
        
        // Emette evento per attivare l'animazione della busta (solo per notifiche non-chat)
        $this->dispatch('notification-received', notificationData: $event);
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
