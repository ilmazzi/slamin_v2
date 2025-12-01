<?php

namespace App\Services\Statistics;

use App\Models\Gig;
use App\Models\GigApplication;
use App\Models\GigPosition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class GigStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:gigs:all', $cacheMinutes * 60, function () {
            return [
                'totals' => [
                    'all' => Gig::count(),
                    'open' => Gig::where('is_closed', false)->count(),
                    'closed' => Gig::where('is_closed', true)->count(),
                ],
                'positions' => [
                    'total' => GigPosition::count(),
                    'active' => GigPosition::where('is_active', true)->count(),
                ],
                'applications' => [
                    'total' => GigApplication::count(),
                    'pending' => GigApplication::where('status', 'pending')->count(),
                    'accepted' => GigApplication::where('status', 'accepted')->count(),
                    'rejected' => GigApplication::where('status', 'rejected')->count(),
                ],
                'features' => [
                    'with_applications' => Gig::whereHas('applications')->count(),
                    'without_applications' => Gig::whereDoesntHave('applications')->count(),
                ],
            ];
        });
    }
}

