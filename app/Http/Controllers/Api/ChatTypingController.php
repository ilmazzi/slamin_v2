<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TypingService;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;

class ChatTypingController extends Controller
{
    protected $typingService;

    public function __construct(TypingService $typingService)
    {
        $this->typingService = $typingService;
    }

    public function startTyping(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);

        // Check if user is participant
        if (!$conversation->hasParticipant(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->typingService->startTyping(
            $conversation->id,
            Auth::id(),
            Auth::user()->name
        );

        return response()->json(['success' => true]);
    }

    public function stopTyping(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);

        // Check if user is participant
        if (!$conversation->hasParticipant(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->typingService->stopTyping(
            $conversation->id,
            Auth::id(),
            Auth::user()->name
        );

        return response()->json(['success' => true]);
    }
}
