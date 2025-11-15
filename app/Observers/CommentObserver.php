<?php

namespace App\Observers;

use App\Models\UnifiedComment;
use App\Services\BadgeService;

class CommentObserver
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the Comment "created" event.
     */
    public function created(UnifiedComment $comment): void
    {
        \Log::info('CommentObserver: Comment created', [
            'comment_id' => $comment->id,
            'user_id' => $comment->user_id,
            'has_user' => $comment->user ? 'yes' : 'no'
        ]);
        
        if ($comment->user) {
            \Log::info('CommentObserver: Checking badges for user', [
                'user_id' => $comment->user->id,
                'user_name' => $comment->user->name
            ]);
            
            // Check and award badges for comments
            $earnedBadges = $this->badgeService->checkAndAwardBadge($comment->user, 'comments', $comment);
            
            \Log::info('CommentObserver: Badge check completed', [
                'earned_badges_count' => count($earnedBadges),
                'earned_badges' => $earnedBadges
            ]);
        } else {
            \Log::warning('CommentObserver: Comment has no user', [
                'comment_id' => $comment->id,
                'user_id' => $comment->user_id
            ]);
        }
    }
}

