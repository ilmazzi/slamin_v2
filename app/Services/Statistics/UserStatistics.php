<?php

namespace App\Services\Statistics;

use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserPoints;
use App\Models\UserSubscription;
use App\Models\UserLanguage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:users:all', $cacheMinutes * 60, function () {
            $today = Carbon::today();
            $thisWeek = Carbon::now()->startOfWeek();
            $thisMonth = Carbon::now()->startOfMonth();
            $thisYear = Carbon::now()->startOfYear();
            
            return [
                'totals' => [
                    'all' => User::count(),
                    'verified' => User::whereNotNull('email_verified_at')->count(),
                    'unverified' => User::whereNull('email_verified_at')->count(),
                    'with_peertube' => User::whereNotNull('peertube_user_id')->count(),
                    'tutorial_completed' => User::whereNotNull('tutorial_completed_at')->count(),
                    'terms_accepted' => User::whereNotNull('terms_accepted_at')->count(),
                    'soft_deleted' => User::onlyTrashed()->count(),
                ],
                'by_role' => User::select('roles.name', DB::raw('count(*) as count'))
                    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->where('model_has_roles.model_type', User::class)
                    ->groupBy('roles.name')
                    ->pluck('count', 'name')
                    ->toArray(),
                'registrations' => [
                    'today' => User::whereDate('created_at', $today)->count(),
                    'this_week' => User::where('created_at', '>=', $thisWeek)->count(),
                    'this_month' => User::where('created_at', '>=', $thisMonth)->count(),
                    'this_year' => User::where('created_at', '>=', $thisYear)->count(),
                ],
                'activity' => [
                    'online_now' => User::where('last_seen_at', '>=', Carbon::now()->subMinutes(5))->count(),
                    'active_today' => User::whereDate('last_seen_at', $today)->count(),
                    'active_this_week' => User::where('last_seen_at', '>=', $thisWeek)->count(),
                    'active_this_month' => User::where('last_seen_at', '>=', $thisMonth)->count(),
                    'never_active' => User::whereNull('last_seen_at')->count(),
                ],
                'subscriptions' => [
                    'active' => User::whereHas('subscriptions', function($q) {
                        $q->where('status', 'active')->where('end_date', '>', Carbon::now());
                    })->count(),
                    'expired' => User::whereHas('subscriptions', function($q) {
                        $q->where('status', 'active')->where('end_date', '<=', Carbon::now());
                    })->count(),
                    'total' => UserSubscription::count(),
                ],
                'gamification' => [
                    'with_badges' => User::whereHas('badges')->count(),
                    'without_badges' => User::whereDoesntHave('badges')->count(),
                    'total_badges_assigned' => UserBadge::count(),
                    'with_points' => User::whereHas('userPoints')->count(),
                    'total_points' => UserPoints::sum('total_points') ?? 0,
                ],
                'languages' => [
                    'with_languages' => User::whereHas('languages')->count(),
                    'total_language_configs' => UserLanguage::count(),
                ],
            ];
        });
    }
}

