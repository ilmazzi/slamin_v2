<?php

namespace App\Services\Statistics;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\EventRanking;
use App\Models\EventRound;
use App\Models\EventScore;
use App\Models\EventInvitation;
use App\Models\RecentVenue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EventStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:events:all', $cacheMinutes * 60, function () {
            $today = Carbon::today();
            $thisWeek = Carbon::now()->startOfWeek();
            $thisMonth = Carbon::now()->startOfMonth();
            
            return [
                'totals' => [
                    'all' => Event::count(),
                    'upcoming' => Event::where('start_datetime', '>=', $today)->count(),
                    'past' => Event::where('start_datetime', '<', $today)->count(),
                    'today' => Event::whereDate('start_datetime', $today)->count(),
                ],
                'by_period' => [
                    'this_week' => Event::whereBetween('start_datetime', [$thisWeek, Carbon::now()->endOfWeek()])->count(),
                    'this_month' => Event::whereMonth('start_datetime', Carbon::now()->month)->count(),
                ],
                'participants' => [
                    'total' => EventParticipant::count(),
                    'unique_users' => EventParticipant::distinct('user_id')->count('user_id'),
                    'average_per_event' => Event::has('participants')->withCount('participants')->get()->avg('participants_count') ?? 0,
                ],
                'features' => [
                    'with_rankings' => Event::whereHas('rankings')->count(),
                    'with_rounds' => Event::whereHas('rounds')->count(),
                    'with_scores' => Event::whereHas('scores')->count(),
                    'with_invitations' => Event::whereHas('invitations')->count(),
                    'total_rankings' => EventRanking::count(),
                    'total_rounds' => EventRound::count(),
                    'total_scores' => EventScore::count(),
                    'total_invitations' => EventInvitation::count(),
                ],
                'venues' => [
                    'unique_venues' => RecentVenue::whereNotNull('venue_name')
                        ->where('venue_name', '!=', '')
                        ->distinct('venue_name')
                        ->count('venue_name'),
                    'most_used' => RecentVenue::select('venue_name', DB::raw('SUM(usage_count) as count'))
                        ->whereNotNull('venue_name')
                        ->where('venue_name', '!=', '')
                        ->groupBy('venue_name')
                        ->orderByDesc('count')
                        ->limit(10)
                        ->pluck('count', 'venue_name')
                        ->toArray(),
                ],
            ];
        });
    }
}

