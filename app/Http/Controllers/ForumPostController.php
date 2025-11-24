<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumPostController extends Controller
{
    public function lock(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|integer',
        ]);

        $post = ForumPost::findOrFail($validated['post_id']);

        // Check if user is moderator
        if (!$post->subreddit->isModerator(Auth::user())) {
            return response()->json(['error' => 'Non autorizzato'], 403);
        }

        $post->is_locked = !$post->is_locked;
        $post->save();

        return response()->json([
            'success' => true,
            'is_locked' => $post->is_locked,
            'message' => $post->is_locked ? 'Post bloccato' : 'Post sbloccato',
        ]);
    }

    public function sticky(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|integer',
        ]);

        $post = ForumPost::findOrFail($validated['post_id']);

        // Check if user is moderator
        if (!$post->subreddit->isModerator(Auth::user())) {
            return response()->json(['error' => 'Non autorizzato'], 403);
        }

        $post->is_sticky = !$post->is_sticky;
        $post->save();

        return response()->json([
            'success' => true,
            'is_sticky' => $post->is_sticky,
            'message' => $post->is_sticky ? 'Post fissato in alto' : 'Post rimosso dalla cima',
        ]);
    }
}

