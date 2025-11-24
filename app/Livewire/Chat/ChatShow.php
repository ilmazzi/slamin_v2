<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    }

    public function loadMessages()
    {
        $this->conversation->refresh();
        $this->conversation->markAsRead(Auth::user());
        $this->dispatch('messagesLoaded');
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

        Message::create($messageData);

        // Update conversation timestamp
        $this->conversation->touch();

        // Reset form
        $this->newMessage = '';
        $this->attachment = null;
        $this->replyTo = null;

        // Dispatch events
        $this->dispatch('messageSent');
        $this->dispatch('messagesLoaded');
        
        // Notify other participants via broadcast
        // TODO: Implement broadcasting
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
        return view('livewire.chat.chat-show', [
            'messages' => $this->messages,
            'replyTo' => $this->replyTo ? Message::find($this->replyTo) : null,
        ]);
    }
}
