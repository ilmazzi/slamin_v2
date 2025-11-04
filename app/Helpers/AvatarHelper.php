<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class AvatarHelper
{
    /**
     * Get user avatar URL with fallback
     */
    public static function getUserAvatarUrl($user, $size = 200)
    {
        if (!$user || !is_object($user)) {
            return "https://ui-avatars.com/api/?name=User&size={$size}&background=059669&color=fff";
        }

        // Check profile_photo_path (storage)
        if (!empty($user->profile_photo_path) && Storage::exists($user->profile_photo_path)) {
            return Storage::url($user->profile_photo_path);
        }

        // Check profile_photo_url (computed attribute)
        if (!empty($user->profile_photo_url)) {
            return $user->profile_photo_url;
        }

        // Fallback to UI Avatars
        $name = $user->name ?? $user->email ?? 'User';
        return "https://ui-avatars.com/api/?name=" . urlencode($name) . "&size={$size}&background=059669&color=fff";
    }

    /**
     * Get user banner URL with fallback
     */
    public static function getUserBannerUrl($user)
    {
        if (!$user || !is_object($user)) {
            return null;
        }

        // Check banner_photo_path (storage)
        if (!empty($user->banner_photo_path) && Storage::exists($user->banner_photo_path)) {
            return Storage::url($user->banner_photo_path);
        }

        // Check banner_photo_url (computed attribute)
        if (!empty($user->banner_photo_url)) {
            return $user->banner_photo_url;
        }

        return null;
    }

    /**
     * Get user display name
     */
    public static function getDisplayName($user)
    {
        if (!$user || !is_object($user)) {
            return 'User';
        }

        return $user->name ?? $user->nickname ?? $user->email ?? 'User';
    }
}
