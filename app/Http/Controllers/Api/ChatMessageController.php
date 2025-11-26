<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    public function markAsRead(Message $message)
    {
        // Check if user is participant of the conversation
        if (!$message->conversation->hasParticipant(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Only mark as read if message is not from current user
        if ($message->user_id !== Auth::id()) {
            $message->markAsRead();
            
            // Also mark as delivered if not already
            if (!$message->isDelivered()) {
                $message->markAsDelivered();
            }
        }

        return response()->json(['success' => true, 'message' => $message->fresh()]);
    }
}
