<?php

namespace App\Services\Statistics;

use App\Models\Subreddit;
use App\Models\ForumPost;
use App\Models\ForumComment;
use App\Models\ForumVote;
use App\Models\ForumReport;
use App\Models\ForumBan;
use App\Models\ForumModerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ForumStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:forum:all', $cacheMinutes * 60, function () {
            return [
                'subreddits' => [
                    'total' => Subreddit::count(),
                    'active' => Subreddit::where('is_active', true)->count(),
                    'inactive' => Subreddit::where('is_active', false)->count(),
                    'public' => Subreddit::where('is_private', false)->count(),
                    'private' => Subreddit::where('is_private', true)->count(),
                    'with_moderators' => Subreddit::whereHas('moderators')->count(),
                    'total_moderators' => ForumModerator::count(),
                ],
                'posts' => [
                    'total' => ForumPost::count(),
                    'text' => ForumPost::where('type', 'text')->count(),
                    'link' => ForumPost::where('type', 'link')->count(),
                    'image' => ForumPost::where('type', 'image')->count(),
                    'sticky' => ForumPost::where('is_sticky', true)->count(),
                    'locked' => ForumPost::where('is_locked', true)->count(),
                    'total_upvotes' => ForumPost::sum('upvotes'),
                    'total_downvotes' => ForumPost::sum('downvotes'),
                    'total_score' => ForumPost::sum('score'),
                    'total_views' => ForumPost::sum('views_count'),
                ],
                'comments' => [
                    'total' => ForumComment::count(),
                    'total_upvotes' => ForumComment::sum('upvotes'),
                    'total_downvotes' => ForumComment::sum('downvotes'),
                ],
                'votes' => [
                    'total' => ForumVote::count(),
                    'upvotes' => ForumVote::where('vote_type', 'upvote')->count(),
                    'downvotes' => ForumVote::where('vote_type', 'downvote')->count(),
                ],
                'reports' => [
                    'total' => ForumReport::count(),
                    'pending' => ForumReport::where('status', 'pending')->count(),
                    'resolved' => ForumReport::where('status', 'resolved')->count(),
                    'dismissed' => ForumReport::where('status', 'dismissed')->count(),
                ],
                'bans' => [
                    'total' => ForumBan::count(),
                    'active' => ForumBan::where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', Carbon::now());
                    })->count(),
                    'expired' => ForumBan::where('expires_at', '<=', Carbon::now())->count(),
                ],
            ];
        });
    }
}

