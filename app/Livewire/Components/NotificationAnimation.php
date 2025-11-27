<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class NotificationAnimation extends Component
{
    public $showAnimation = false;
    public $lastCheckedAt = null;

    public function mount()
    {
        if (Auth::check()) {
            // Inizializza con il timestamp corrente
            $this->lastCheckedAt = now();
        }
    }

    /**
     * Metodo chiamato quando una nuova notifica arriva via polling
     */
    public function pollForNewNotifications()
    {
        if (!Auth::check()) {
            return;
        }

        // Cerca notifiche create dopo l'ultimo check, escludendo messaggi di chat
        $allNotifications = Auth::user()
            ->notifications()
            ->where('created_at', '>', $this->lastCheckedAt)
            ->whereNull('read_at')
            ->get();
        
        // Filtra manualmente escludendo i messaggi di chat
        $newNotifications = $allNotifications->filter(function($notification) {
            $type = $notification->data['type'] ?? null;
            return $type !== 'chat_new_message';
        })->count();

        \Log::info('Polling for notifications', [
            'user_id' => Auth::id(),
            'last_checked_at' => $this->lastCheckedAt,
            'new_notifications' => $newNotifications,
        ]);

        if ($newNotifications > 0) {
            \Log::info('New notification found! Showing animation');
            $this->showAnimation = true;
            $this->lastCheckedAt = now();
            
            // Auto-hide dopo 8 secondi
            $this->dispatch('auto-hide-notification');
        }
    }

    /**
     * Listener per eventi di refresh notifiche
     */
    #[On('refresh-notifications')]
    public function handleNotificationRefresh()
    {
        // Don't show animation on manual refresh
        // Just update the timestamp
        if (Auth::check()) {
            $this->lastCheckedAt = now();
        }
    }

    /**
     * Listener per nuove notifiche via broadcast
     */
    #[On('notification-received')]
    public function handleNewNotification($notificationData = null)
    {
        \Log::info('notification-received event triggered', ['data' => $notificationData]);
        
        // Skip animation for chat messages
        if ($notificationData && isset($notificationData['type']) && $notificationData['type'] === 'chat_new_message') {
            \Log::info('Skipping animation for chat message');
            $this->lastCheckedAt = now();
            return;
        }
        
        $this->showAnimation = true;
        $this->lastCheckedAt = now();
        $this->dispatch('auto-hide-notification');
    }

    /**
     * Handle social interaction events (likes, comments)
     */
    #[On('social-interaction')]
    public function handleSocialInteraction($event)
    {
        \Log::info('social-interaction event triggered', $event);
        $this->showAnimation = true;
        $this->lastCheckedAt = now();
        $this->dispatch('auto-hide-notification');
    }

    public function hideAnimation()
    {
        $this->showAnimation = false;
    }

    /**
     * Handle broadcast notification and check type
     */
    public function handleBroadcastNotification($event)
    {
        \Log::info('Broadcast notification received', [
            'event' => $event,
            'type' => $event['type'] ?? 'unknown'
        ]);
        
        // Check if it's a chat message - try multiple possible structures
        $notificationType = $event['type'] ?? ($event['data']['type'] ?? null);
        
        if ($notificationType === 'chat_new_message') {
            \Log::info('Skipping animation for chat message (broadcast)', ['type' => $notificationType]);
            $this->lastCheckedAt = now();
            return;
        }
        
        \Log::info('Showing animation for notification', ['type' => $notificationType]);
        
        // Show animation for other notification types
        $this->showAnimation = true;
        $this->lastCheckedAt = now();
        $this->dispatch('auto-hide-notification');
    }

    protected function getListeners()
    {
        if (!Auth::check()) {
            return [];
        }

        return [
            "echo-private:App.Models.User." . Auth::id() . ",.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'handleBroadcastNotification',
            "echo-private:App.Models.User." . Auth::id() . ",.social-interaction" => 'handleSocialInteraction',
            'refresh-notifications' => 'handleNotificationRefresh',
            'notification-received' => 'handleNewNotification',
        ];
    }

    public function render()
    {
        return view('livewire.components.notification-animation');
    }
}
