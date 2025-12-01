<?php

namespace App\Services\Statistics;

use App\Models\Poem;
use App\Models\Article;
use App\Models\Video;
use App\Models\PoemCategory;
use App\Models\ArticleCategory;
use App\Models\UnifiedComment;
use App\Models\UnifiedLike;
use App\Models\UnifiedView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContentStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:content:all', $cacheMinutes * 60, function () {
            $thisMonth = Carbon::now()->startOfMonth();
            
            return [
                'poems' => [
                    'total' => Poem::count(),
                    'this_month' => Poem::where('created_at', '>=', $thisMonth)->count(),
                    'with_category' => Poem::whereNotNull('category')
                        ->where('category', '!=', '')
                        ->count(),
                    'by_category' => Poem::whereNotNull('category')
                        ->where('category', '!=', '')
                        ->select('category', DB::raw('count(*) as count'))
                        ->groupBy('category')
                        ->orderByDesc('count')
                        ->limit(10)
                        ->pluck('count', 'category')
                        ->toArray(),
                    'with_comments' => Poem::whereHas('comments')->count(),
                    'with_likes' => Poem::whereHas('likes')->count(),
                    'with_views' => Poem::whereHas('views')->count(),
                    'total_comments' => UnifiedComment::where('commentable_type', Poem::class)->count(),
                    'total_likes' => UnifiedLike::where('likeable_type', Poem::class)->count(),
                    'total_views' => UnifiedView::where('viewable_type', Poem::class)->count(),
                ],
                'articles' => [
                    'total' => Article::count(),
                    'this_month' => Article::where('created_at', '>=', $thisMonth)->count(),
                    'with_category' => Article::whereNotNull('category_id')->count(),
                    'by_category' => Article::whereNotNull('category_id')
                        ->select('article_categories.name', DB::raw('count(*) as count'))
                        ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
                        ->groupBy('article_categories.name')
                        ->pluck('count', 'name')
                        ->toArray(),
                    'with_tags' => Article::whereHas('tags')->count(),
                    'total_tags' => DB::table('article_tag')->count(),
                    'with_comments' => Article::whereHas('comments')->count(),
                    'with_likes' => Article::whereHas('likes')->count(),
                    'with_views' => Article::whereHas('views')->count(),
                    'total_comments' => UnifiedComment::where('commentable_type', Article::class)->count(),
                    'total_likes' => UnifiedLike::where('likeable_type', Article::class)->count(),
                    'total_views' => UnifiedView::where('viewable_type', Article::class)->count(),
                ],
                'videos' => [
                    'total' => Video::count(),
                    'this_month' => Video::where('created_at', '>=', $thisMonth)->count(),
                    'with_snapshots' => Video::whereHas('snaps')->count(),
                    'total_snapshots' => DB::table('video_snaps')->count(),
                    'with_comments' => Video::whereHas('comments')->count(),
                    'with_likes' => Video::whereHas('likes')->count(),
                    'with_views' => Video::whereHas('views')->count(),
                    'total_comments' => UnifiedComment::where('commentable_type', Video::class)->count(),
                    'total_likes' => UnifiedLike::where('likeable_type', Video::class)->count(),
                    'total_views' => UnifiedView::where('viewable_type', Video::class)->count(),
                ],
                'engagement' => [
                    'total_comments' => UnifiedComment::count(),
                    'total_likes' => UnifiedLike::count(),
                    'total_views' => UnifiedView::count(),
                    'comments_by_type' => UnifiedComment::select('commentable_type', DB::raw('count(*) as count'))
                        ->groupBy('commentable_type')
                        ->pluck('count', 'commentable_type')
                        ->toArray(),
                    'likes_by_type' => UnifiedLike::select('likeable_type', DB::raw('count(*) as count'))
                        ->groupBy('likeable_type')
                        ->pluck('count', 'likeable_type')
                        ->toArray(),
                    'views_by_type' => UnifiedView::select('viewable_type', DB::raw('count(*) as count'))
                        ->groupBy('viewable_type')
                        ->pluck('count', 'viewable_type')
                        ->toArray(),
                ],
            ];
        });
    }
}

