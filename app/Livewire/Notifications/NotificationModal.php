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
            ->take(50) // Take more to ensure we have enough after filtering
            ->get()
            ->filter(function($notification) {
                // Filter out chat messages
                $type = $notification->data['type'] ?? null;
                return $type !== 'chat_new_message';
            })
            ->take(20) // Take only 20 after filtering
            ->map(function($notification) {
                $data = $notification->data;
                $type = $data['type'] ?? 'default';
                
                // Format notification based on type
                return [
                    'id' => $notification->id,
                    'type' => $type,
                    'title' => $this->getNotificationTitle($type, $data),
                    'message' => $this->getNotificationMessage($type, $data),
                    'icon' => $this->getNotificationIcon($type),
                    'url' => $data['url'] ?? '#',
                    'read' => $notification->read_at !== null,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'data' => $data,
                ];
            })
            ->values(); // Reset array keys

        // Count unread excluding chat messages
        $this->unreadCount = Auth::user()
            ->unreadNotifications()
            ->get()
            ->filter(function($notification) {
                $type = $notification->data['type'] ?? null;
                return $type !== 'chat_new_message';
            })
            ->count();
    }

    private function getNotificationTitle($type, $data)
    {
        return match($type) {
            'forum_new_comment' => 'Nuovo commento',
            'forum_new_reply' => 'Nuova risposta',
            'forum_post_voted' => 'Post votato',
            'forum_comment_voted' => 'Commento votato',
            'forum_post_reported' => 'Post segnalato',
            'forum_comment_reported' => 'Commento segnalato',
            'forum_content_reported' => 'Contenuto segnalato',
            'forum_post_approved' => 'Post approvato',
            'forum_post_removed' => 'Post rimosso',
            'forum_user_banned' => 'Bannato da subreddit',
            'forum_moderator_added' => 'Sei moderatore',
            'chat_new_message' => 'Nuovo messaggio',
            default => $data['title'] ?? 'Notifica',
        };
    }

    private function getNotificationMessage($type, $data)
    {
        return match($type) {
            'chat_new_message' => ($data['sender_name'] ?? 'Qualcuno') . ' ti ha inviato un messaggio: "' . \Str::limit($data['message_preview'] ?? '', 60) . '"',
            'forum_new_comment' => ($data['commenter_name'] ?? 'Qualcuno') . ' ha commentato il tuo post: "' . \Str::limit($data['post_title'] ?? '', 50) . '"',
            'forum_new_reply' => ($data['replier_name'] ?? 'Qualcuno') . ' ha risposto al tuo commento: "' . \Str::limit($data['reply_excerpt'] ?? '', 60) . '"',
            'forum_post_voted' => 'Il tuo post "' . \Str::limit($data['post_title'] ?? '', 50) . '" ha raggiunto ' . ($data['current_score'] ?? 0) . ' punti!',
            'forum_comment_voted' => 'Il tuo commento ha raggiunto ' . ($data['current_score'] ?? 0) . ' punti!',
            'forum_post_reported' => ($data['reporter_name'] ?? 'Un utente') . ' ha segnalato un post: "' . \Str::limit($data['post_title'] ?? '', 50) . '"',
            'forum_comment_reported' => ($data['reporter_name'] ?? 'Un utente') . ' ha segnalato un commento',
            'forum_content_reported' => 'Il tuo ' . ($data['content_type'] === 'post' ? 'post' : 'commento') . ' in r/' . ($data['subreddit_name'] ?? '') . ' è stato segnalato per: ' . __('forum.' . ($data['reason'] ?? 'other')),
            'forum_post_approved' => 'Il tuo post "' . \Str::limit($data['post_title'] ?? '', 50) . '" è stato approvato da ' . ($data['moderator_name'] ?? 'un moderatore'),
            'forum_post_removed' => 'Il tuo post "' . \Str::limit($data['post_title'] ?? '', 50) . '" è stato rimosso' . (isset($data['reason']) ? ': ' . $data['reason'] : ''),
            'forum_user_banned' => 'Sei stato bannato da r/' . ($data['subreddit_name'] ?? '') . (isset($data['expires_at']) && !$data['is_permanent'] ? ' fino al ' . \Carbon\Carbon::parse($data['expires_at'])->format('d/m/Y') : ' permanentemente'),
            'forum_moderator_added' => 'Sei stato aggiunto come ' . __('forum.' . ($data['role'] ?? 'moderator')) . ' di r/' . ($data['subreddit_name'] ?? ''),
            default => $data['message'] ?? '',
        };
    }

    private function getNotificationIcon($type)
    {
        return match($type) {
            'forum_new_comment' => '💬',
            'forum_new_reply' => '🔄',
            'forum_post_voted', 'forum_comment_voted' => '⬆️',
            'forum_post_reported', 'forum_comment_reported' => '🚩',
            'forum_content_reported' => '⚠️',
            'forum_post_approved' => '✅',
            'forum_post_removed' => '❌',
            'forum_user_banned' => '🔨',
            'forum_moderator_added' => '👑',
            'chat_new_message' => '💬',
            default => '🔔',
        };
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

    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        $this->loadNotifications();
        $this->dispatch('refresh-notifications');
    }

    public function render()
    {
        return view('livewire.notifications.notification-modal');
    }
}
