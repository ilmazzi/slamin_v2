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
            // Inizializza con il timestamp corrente per evitare di mostrare notifiche vecchie
            $this->lastCheckedAt = now();
            
            \Log::info('NotificationAnimation mounted', [
                'user_id' => Auth::id(),
                'last_checked_at' => $this->lastCheckedAt
            ]);
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
        
        \Log::info('All notifications found', [
            'total' => $allNotifications->count(),
            'types' => $allNotifications->pluck('data.type')->toArray()
        ]);
        
        // Filtra manualmente escludendo i messaggi di chat
        $filteredNotifications = $allNotifications->filter(function($notification) {
            $type = $notification->data['type'] ?? null;
            $isChat = $type === 'chat_new_message';
            \Log::info('Filtering notification', [
                'type' => $type,
                'is_chat' => $isChat,
                'will_show' => !$isChat
            ]);
            return !$isChat;
        });
        
        $newNotifications = $filteredNotifications->count();

        \Log::info('Polling for notifications', [
            'user_id' => Auth::id(),
            'last_checked_at' => $this->lastCheckedAt,
            'total_notifications' => $allNotifications->count(),
            'filtered_notifications' => $newNotifications,
        ]);

        if ($newNotifications > 0) {
            \Log::info('New notification found! Showing animation');
            $this->showAnimation = true;
            $this->lastCheckedAt = now();
            
            // Auto-hide dopo 10 secondi
            $this->dispatch('auto-hide-notification');
        } else {
            // IMPORTANTE: Se non ci sono notifiche da mostrare (incluse quelle filtrate),
            // aggiorna lastCheckedAt a now() per evitare di ricontrollare continuamente
            // le stesse notifiche di chat già filtrate
            if ($allNotifications->count() > 0) {
                \Log::info('Notifications found but all filtered (chat messages) - updating lastCheckedAt');
                $this->lastCheckedAt = now();
            }
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
        // Check both class name and data type
        $notificationClass = $notificationData['type'] ?? null;
        $notificationDataType = $notificationData['data']['type'] ?? null;
        
        $isChatMessage = 
            $notificationClass === 'App\\Notifications\\Chat\\NewMessageNotification' ||
            $notificationDataType === 'chat_new_message';
        
        if ($isChatMessage) {
            \Log::info('✅ Skipping animation for chat message (notification-received event)');
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
        \Log::info('Broadcast notification received in NotificationAnimation', [
            'event' => $event,
            'type' => $event['type'] ?? 'unknown'
        ]);
        
        // Check if it's a chat message
        // In broadcast, Laravel sends the notification class name in 'type'
        $notificationClass = $event['type'] ?? null;
        $notificationDataType = $event['data']['type'] ?? null;
        
        $isChatMessage = 
            $notificationClass === 'App\\Notifications\\Chat\\NewMessageNotification' ||
            $notificationDataType === 'chat_new_message';
        
        if ($isChatMessage) {
            \Log::info('✅ Skipping animation for chat message (broadcast)');
            $this->lastCheckedAt = now();
            return;
        }
        
        \Log::info('⚠️ Showing animation for notification', [
            'class' => $notificationClass,
            'data_type' => $notificationDataType
        ]);
        
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
