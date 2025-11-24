<?php

namespace App\Http\Controllers;

use App\Models\ForumVote;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumVoteController extends Controller
{
    public function vote(Request $request)
    {
        $validated = $request->validate([
            'voteable_type' => 'required|in:post,comment',
            'voteable_id' => 'required|integer',
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        // Get the voteable model
        $voteableClass = $validated['voteable_type'] === 'post' ? ForumPost::class : ForumComment::class;
        $voteable = $voteableClass::findOrFail($validated['voteable_id']);

        // Check existing vote
        $existingVote = ForumVote::where('user_id', Auth::id())
            ->where('voteable_type', $voteableClass)
            ->where('voteable_id', $validated['voteable_id'])
            ->first();

        $action = 'added';

        // If clicking the same vote, remove it
        if ($existingVote && $existingVote->vote_type === $validated['vote_type']) {
            // Remove vote
            if ($validated['vote_type'] === 'upvote') {
                $voteable->decrement('upvotes');
            } else {
                $voteable->decrement('downvotes');
            }
            
            $existingVote->delete();
            $action = 'removed';
        } else {
            // Change or add vote
            if ($existingVote) {
                // Change vote
                $oldType = $existingVote->vote_type;
                
                if ($oldType === 'upvote') {
                    $voteable->decrement('upvotes');
                    $voteable->increment('downvotes');
                } else {
                    $voteable->decrement('downvotes');
                    $voteable->increment('upvotes');
                }
                
                $existingVote->update(['vote_type' => $validated['vote_type']]);
                $action = 'changed';
            } else {
                // New vote
                ForumVote::create([
                    'user_id' => Auth::id(),
                    'voteable_type' => $voteableClass,
                    'voteable_id' => $validated['voteable_id'],
                    'vote_type' => $validated['vote_type'],
                ]);
                
                if ($validated['vote_type'] === 'upvote') {
                    $voteable->increment('upvotes');
                } else {
                    $voteable->increment('downvotes');
                }
            }
        }

        // Update score
        $voteable->updateScore();

        return response()->json([
            'success' => true,
            'action' => $action,
            'score' => $voteable->score,
            'upvotes' => $voteable->upvotes,
            'downvotes' => $voteable->downvotes,
        ]);
    }
}

