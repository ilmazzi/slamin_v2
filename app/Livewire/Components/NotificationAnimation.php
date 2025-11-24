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

        // Cerca notifiche create dopo l'ultimo check
        $newNotifications = Auth::user()
            ->notifications()
            ->where('created_at', '>', $this->lastCheckedAt)
            ->whereNull('read_at')
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
    public function handleNewNotification()
    {
        \Log::info('notification-received event triggered');
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

    protected function getListeners()
    {
        if (!Auth::check()) {
            return [];
        }

        return [
            "echo-private:App.Models.User." . Auth::id() . ",.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'handleNewNotification',
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
