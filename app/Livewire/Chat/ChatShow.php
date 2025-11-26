<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Chat\NewMessageNotification;

class ChatShow extends Component
{
    use WithFileUploads;

    public Conversation $conversation;
    public $newMessage = '';
    public $attachment;
    public $replyTo = null;

    protected $listeners = [
        'messageSent' => 'loadMessages',
    ];

    public function mount(Conversation $conversation)
    {
        // Check if user is participant
        if (!$conversation->hasParticipant(Auth::user())) {
            abort(403);
        }

        $this->conversation = $conversation;
        
        // Mark as read
        $conversation->markAsRead(Auth::user());
        
        // Trigger scroll to bottom on initial load
        $this->dispatch('scrollToBottom');
    }

    public function loadMessages()
    {
        $this->conversation->refresh();
        $this->conversation->markAsRead(Auth::user());
        
        // Mark all unread messages from other users as read
        $unreadMessages = $this->conversation->messages()
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->get();
        
        foreach ($unreadMessages as $message) {
            $message->markAsRead();
        }
        
        // Mark all undelivered messages from current user as delivered
        $this->conversation->messages()
            ->where('user_id', Auth::id())
            ->whereNull('delivered_at')
            ->get()
            ->each(function ($message) {
                $message->markAsDelivered();
            });
        
        $this->dispatch('messagesLoaded');
        $this->dispatch('scrollToBottom'); // Trigger scroll
    }

    public function markMessageAsRead($messageId)
    {
        $message = Message::find($messageId);
        
        if ($message && $message->conversation_id === $this->conversation->id && $message->user_id !== Auth::id()) {
            $message->markAsRead();
            $this->dispatch('messageRead', ['messageId' => $messageId]);
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required_without:attachment|string|max:5000',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        $messageData = [
            'conversation_id' => $this->conversation->id,
            'user_id' => Auth::id(),
            'body' => $this->newMessage,
            'type' => 'text',
            'reply_to' => $this->replyTo,
        ];

        // Handle attachment
        if ($this->attachment) {
            $path = $this->attachment->store('chat-attachments', 'public');
            
            if (str_starts_with($this->attachment->getMimeType(), 'image/')) {
                $messageData['type'] = 'image';
                $messageData['metadata'] = [
                    'url' => Storage::url($path),
                    'filename' => $this->attachment->getClientOriginalName(),
                    'size' => $this->attachment->getSize(),
                ];
            } else {
                $messageData['type'] = 'file';
                $messageData['metadata'] = [
                    'url' => Storage::url($path),
                    'filename' => $this->attachment->getClientOriginalName(),
                    'size' => number_format($this->attachment->getSize() / 1024, 2) . ' KB',
                ];
            }
        }

        $message = Message::create($messageData);

        // Mark as delivered immediately for other participants (they will see it)
        // We'll update this when they actually load the conversation
        // For now, we mark it as delivered after a short delay (handled by frontend/observer)

        // Update conversation timestamp
        $this->conversation->touch();

        // Notify other participants
        $otherParticipants = $this->conversation->users()
            ->where('users.id', '!=', Auth::id())
            ->get();
        
        foreach ($otherParticipants as $participant) {
            $participant->notify(new NewMessageNotification($message, Auth::user()));
        }

        // Reset form
        $this->newMessage = '';
        $this->attachment = null;
        $this->replyTo = null;

        // Dispatch events
        $this->dispatch('messageSent');
        $this->dispatch('messagesLoaded');
        $this->dispatch('scrollToBottom'); // Trigger scroll after sending
    }

    public function setReplyTo($messageId)
    {
        $this->replyTo = $messageId;
    }

    public function cancelReply()
    {
        $this->replyTo = null;
    }

    public function removeAttachment()
    {
        $this->attachment = null;
    }

    public function getMessagesProperty()
    {
        return $this->conversation->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function render()
    {
        $otherUser = $this->conversation->getOtherParticipant(Auth::user());
        $isOnline = false;
        
        if ($otherUser) {
            $onlineService = app(\App\Services\OnlineStatusService::class);
            $isOnline = $onlineService->isOnline($otherUser->id);
        }
        
        return view('livewire.chat.chat-show', [
            'messages' => $this->messages,
            'replyTo' => $this->replyTo ? Message::find($this->replyTo) : null,
            'isOnline' => $isOnline,
        ]);
    }
}
