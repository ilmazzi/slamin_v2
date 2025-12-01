<?php

namespace App\Services\Statistics;

use App\Models\Carousel;
use App\Models\SupportTicket;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Report;
use App\Models\ActivityLog;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\PointTransaction;
use App\Models\TranslationPayment;
use App\Models\PoemTranslation;
use App\Models\PoemTranslationNegotiation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class OtherStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:other:all', $cacheMinutes * 60, function () {
            return [
                'carousels' => [
                    'total' => Carousel::count(),
                    'active' => Carousel::where('is_active', true)->count(),
                    'inactive' => Carousel::where('is_active', false)->count(),
                    'by_type' => Carousel::select('content_type', \DB::raw('count(*) as count'))
                        ->whereNotNull('content_type')
                        ->groupBy('content_type')
                        ->pluck('count', 'content_type')
                        ->toArray(),
                ],
                'support_tickets' => [
                    'total' => SupportTicket::count(),
                    'open' => SupportTicket::where('status', 'open')->count(),
                    'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
                    'resolved' => SupportTicket::where('status', 'resolved')->count(),
                    'closed' => SupportTicket::where('status', 'closed')->count(),
                    'by_category' => SupportTicket::select('category', \DB::raw('count(*) as count'))
                        ->groupBy('category')
                        ->pluck('count', 'category')
                        ->toArray(),
                ],
                'messages' => [
                    'conversations' => Conversation::count(),
                    'total_messages' => Message::count(),
                ],
                'reports' => [
                    'total' => Report::count(),
                    'pending' => Report::where('status', 'pending')->count(),
                    'resolved' => Report::where('status', 'resolved')->count(),
                    'rejected' => Report::where('status', 'rejected')->count(),
                ],
                'activity_logs' => [
                    'total' => ActivityLog::count(),
                    'last_24h' => ActivityLog::where('created_at', '>=', Carbon::now()->subDay())->count(),
                    'last_week' => ActivityLog::where('created_at', '>=', Carbon::now()->subWeek())->count(),
                ],
                'gamification' => [
                    'badges' => [
                        'total' => Badge::count(),
                        'assigned' => UserBadge::count(),
                    ],
                    'points' => [
                        'transactions' => PointTransaction::count(),
                        'total_awarded' => PointTransaction::where('type', 'credit')->sum('points') ?? 0,
                        'total_spent' => abs(PointTransaction::where('type', 'debit')->sum('points') ?? 0),
                    ],
                ],
                'translations' => [
                    'total' => PoemTranslation::count(),
                    'negotiations_active' => PoemTranslationNegotiation::whereHas('gigApplication', function ($query) {
                        $query->where('status', 'pending');
                    })->count(),
                ],
                'payments' => [
                    'total' => TranslationPayment::count(),
                    'completed' => TranslationPayment::where('status', 'completed')->count(),
                    'pending' => TranslationPayment::where('status', 'pending')->count(),
                    'failed' => TranslationPayment::where('status', 'failed')->count(),
                    'total_revenue' => TranslationPayment::where('status', 'completed')->sum('commission_total') ?? 0,
                ],
            ];
        });
    }
}

