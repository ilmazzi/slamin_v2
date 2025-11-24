<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class ModerationHelper
{
    /**
     * Check if a content type should be auto-approved
     *
     * @param string $contentType (poems, articles, photos, videos, events, gigs, forum_posts, forum_comments)
     * @return bool
     */
    public static function shouldAutoApprove(string $contentType): bool
    {
        return Cache::get("moderation.auto_approve.{$contentType}", false);
    }

    /**
     * Get the moderation status for a content type
     *
     * @param string $contentType
     * @return string ('approved' or 'pending')
     */
    public static function getModerationStatus(string $contentType): string
    {
        return self::shouldAutoApprove($contentType) ? 'approved' : 'pending';
    }

    /**
     * Get approved_at timestamp if auto-approve is enabled
     *
     * @param string $contentType
     * @return \Carbon\Carbon|null
     */
    public static function getApprovedAt(string $contentType): ?\Carbon\Carbon
    {
        return self::shouldAutoApprove($contentType) ? now() : null;
    }
}

