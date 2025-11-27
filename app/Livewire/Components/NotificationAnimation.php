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
        $newNotifications = Auth::user()
            ->notifications()
            ->where('created_at', '>', $this->lastCheckedAt)
            ->whereNull('read_at')
            ->where(function($query) {
                $query->whereJsonDoesntContain('data->type', 'chat_new_message')
                      ->orWhereNull('data->type');
            })
            ->count();

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
        $this->pollForNewNotifications();
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
        \Log::info('Broadcast notification received', ['event' => $event]);
        
        // Check if it's a chat message
        if (isset($event['type']) && $event['type'] === 'chat_new_message') {
            \Log::info('Skipping animation for chat message (broadcast)');
            $this->lastCheckedAt = now();
            return;
        }
        
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
