<?php

namespace App\Services\Statistics;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupAnnouncement;
use App\Models\GroupInvitation;
use App\Models\GroupJoinRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GroupStatistics
{
    public static function getAll($cacheMinutes = 15)
    {
        return Cache::remember('statistics:groups:all', $cacheMinutes * 60, function () {
            return [
                'totals' => [
                    'all' => Group::count(),
                    'public' => Group::where('visibility', 'public')->count(),
                    'private' => Group::where('visibility', 'private')->count(),
                ],
                'members' => [
                    'total' => GroupMember::count(),
                    'unique_users' => GroupMember::distinct('user_id')->count('user_id'),
                    'average_per_group' => Group::has('members')->withCount('members')->get()->avg('members_count') ?? 0,
                    'groups_with_members' => Group::has('members')->count(),
                    'groups_without_members' => Group::doesntHave('members')->count(),
                ],
                'content' => [
                    'with_announcements' => Group::whereHas('announcements')->count(),
                    'total_announcements' => GroupAnnouncement::count(),
                    'with_events' => Group::whereHas('events')->count(),
                ],
                'invitations' => [
                    'total' => GroupInvitation::count(),
                    'pending' => GroupInvitation::where('status', 'pending')->count(),
                    'accepted' => GroupInvitation::where('status', 'accepted')->count(),
                    'declined' => GroupInvitation::where('status', 'declined')->count(),
                    'expired' => GroupInvitation::where('status', 'expired')->count(),
                ],
                'join_requests' => [
                    'total' => GroupJoinRequest::count(),
                    'pending' => GroupJoinRequest::where('status', 'pending')->count(),
                    'approved' => GroupJoinRequest::where('status', 'approved')->count(),
                    'rejected' => GroupJoinRequest::where('status', 'rejected')->count(),
                ],
            ];
        });
    }
}

