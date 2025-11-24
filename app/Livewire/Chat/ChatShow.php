<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ChatShow extends Component
{
    use WithFileUploads;

    public $conversationId;
    public $conversation;
    public $messageBody = '';
    public $replyTo = null;
    public $attachment = null;
    public $attachmentPreview = null;

    protected $listeners = [
        'conversationSelected' => 'loadConversation',
        'echo:conversations.{conversationId},MessageSent' => 'handleNewMessage',
    ];

    public function mount($conversationId = null)
    {
        if ($conversationId) {
            $this->loadConversation($conversationId);
        }
    }

    public function loadConversation($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->conversation = Conversation::with(['messages.user', 'users'])
            ->find($conversationId);

        if ($this->conversation && $this->conversation->hasParticipant(Auth::user())) {
            $this->conversation->markAsRead(Auth::user());
        }
    }

    public function handleNewMessage($event)
    {
        // Refresh messages when new message arrives
        $this->conversation = Conversation::with(['messages.user', 'users'])
            ->find($this->conversationId);
        
        if ($this->conversation) {
            $this->conversation->markAsRead(Auth::user());
        }
        
        $this->dispatch('scrollToBottom');
    }

    public function updatedAttachment()
    {
        $this->validate([
            'attachment' => 'file|max:10240', // 10MB max
        ]);

        if ($this->attachment) {
            if (str_starts_with($this->attachment->getMimeType(), 'image/')) {
                $this->attachmentPreview = $this->attachment->temporaryUrl();
            }
        }
    }

    public function removeAttachment()
    {
        $this->attachment = null;
        $this->attachmentPreview = null;
    }

    public function setReplyTo($messageId)
    {
        $this->replyTo = $messageId;
    }

    public function cancelReply()
    {
        $this->replyTo = null;
    }

    public function sendMessage()
    {
        if (!$this->conversation) {
            return;
        }

        $this->validate([
            'messageBody' => 'required_without:attachment|string|max:5000',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $messageData = [
            'conversation_id' => $this->conversation->id,
            'user_id' => Auth::id(),
            'body' => $this->messageBody ?: '',
            'type' => 'text',
            'reply_to' => $this->replyTo,
        ];

        // Handle attachment
        if ($this->attachment) {
            $mimeType = $this->attachment->getMimeType();
            
            if (str_starts_with($mimeType, 'image/')) {
                // Process image
                $manager = new ImageManager(new Driver());
                $image = $manager->read($this->attachment->getRealPath());
                
                // Resize if too large
                if ($image->width() > 1920 || $image->height() > 1920) {
                    $image->scale(width: 1920);
                }
                
                $filename = 'chat_' . uniqid() . '.webp';
                $path = 'chat/images/' . $filename;
                
                Storage::disk('public')->put($path, $image->toWebp(85));
                
                $messageData['type'] = 'image';
                $messageData['metadata'] = [
                    'path' => $path,
                    'filename' => $this->attachment->getClientOriginalName(),
                    'size' => $this->attachment->getSize(),
                ];
            } else {
                // Handle file
                $path = $this->attachment->store('chat/files', 'public');
                
                $messageData['type'] = 'file';
                $messageData['metadata'] = [
                    'path' => $path,
                    'filename' => $this->attachment->getClientOriginalName(),
                    'size' => $this->attachment->getSize(),
                    'mime_type' => $mimeType,
                ];
            }
        }

        $message = Message::create($messageData);

        // Update conversation timestamp
        $this->conversation->touch();

        // Reset form
        $this->messageBody = '';
        $this->replyTo = null;
        $this->attachment = null;
        $this->attachmentPreview = null;

        // Broadcast event (will be implemented with Broadcasting)
        // broadcast(new MessageSent($message))->toOthers();

        $this->dispatch('messageSent');
        $this->dispatch('scrollToBottom');
        
        // Reload conversation
        $this->loadConversation($this->conversationId);
    }

    public function deleteMessage($messageId)
    {
        $message = Message::find($messageId);
        
        if ($message && $message->user_id === Auth::id()) {
            // Delete attachments if any
            if ($message->metadata && isset($message->metadata['path'])) {
                Storage::disk('public')->delete($message->metadata['path']);
            }
            
            $message->delete();
            $this->loadConversation($this->conversationId);
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-show');
    }
}
