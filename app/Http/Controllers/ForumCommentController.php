<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumCommentController extends Controller
{
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'comment_id' => 'required|integer',
        ]);

        $comment = ForumComment::findOrFail($validated['comment_id']);

        // Check if user can delete
        if (!$comment->canDelete(Auth::user())) {
            return response()->json(['error' => 'Non autorizzato'], 403);
        }

        $comment->softDelete(Auth::user());
        $comment->post->decrementCommentsCount();

        return response()->json([
            'success' => true,
            'message' => 'Commento eliminato',
        ]);
    }
}

