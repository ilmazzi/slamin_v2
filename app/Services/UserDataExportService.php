<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserDataExportService
{
    /**
     * Generate a complete data export for a user
     */
    public function generateExport(User $user): array
    {
        return [
            'export_date' => now()->toIso8601String(),
            'export_version' => '1.0',
            'gdpr_compliance' => 'Article 15 - Right of access',
            
            'personal_information' => $this->getPersonalInformation($user),
            'account_activity' => $this->getAccountActivity($user),
            'content' => $this->getContent($user),
            'interactions' => $this->getInteractions($user),
            'privacy_settings' => $this->getPrivacySettings($user),
        ];
    }
    
    /**
     * Get user personal information
     */
    protected function getPersonalInformation(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'phone' => $user->phone,
            'bio' => $user->bio,
            'location' => $user->location,
            'city' => $user->city,
            'region' => $user->region,
            'country' => $user->country,
            'website' => $user->website,
            'birth_date' => $user->birth_date?->toDateString(),
            'profile_photo_url' => $user->profile_photo,
            'banner_image_url' => $user->banner_image,
            'created_at' => $user->created_at->toIso8601String(),
            'email_verified_at' => $user->email_verified_at?->toIso8601String(),
            'terms_accepted_at' => $user->terms_accepted_at?->toIso8601String(),
            'privacy_accepted_at' => $user->privacy_accepted_at?->toIso8601String(),
        ];
    }
    
    /**
     * Get account activity
     */
    protected function getAccountActivity(User $user): array
    {
        return [
            'status' => $user->status,
            'last_active_at' => $user->last_active_at?->toIso8601String(),
            'login_streak' => $user->login_streak,
            'total_logins' => $user->total_logins,
        ];
    }
    
    /**
     * Get user content
     */
    protected function getContent(User $user): array
    {
        return [
            'poems' => $user->poems()->get()->map(function ($poem) {
                return [
                    'id' => $poem->id,
                    'title' => $poem->title,
                    'content' => $poem->content,
                    'likes_count' => $poem->likes_count,
                    'views_count' => $poem->views_count,
                    'created_at' => $poem->created_at->toIso8601String(),
                ];
            }),
            
            'articles' => $user->articles()->get()->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'content' => $article->content,
                    'likes_count' => $article->likes_count,
                    'views_count' => $article->views_count,
                    'created_at' => $article->created_at->toIso8601String(),
                ];
            }),
            
            'videos' => $user->videos()->get()->map(function ($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'description' => $video->description,
                    'views_count' => $video->views_count,
                    'likes_count' => $video->likes_count,
                    'created_at' => $video->created_at->toIso8601String(),
                ];
            }),
            
            'comments' => $user->comments()->get()->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'commentable_type' => $comment->commentable_type,
                    'commentable_id' => $comment->commentable_id,
                    'created_at' => $comment->created_at->toIso8601String(),
                ];
            }),
        ];
    }
    
    /**
     * Get user interactions
     */
    protected function getInteractions(User $user): array
    {
        return [
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
            'likes_given' => $user->likes()->count(),
            'likes_received' => $user->likes_count ?? 0,
            'comments_count' => $user->comments()->count(),
        ];
    }
    
    /**
     * Get privacy settings
     */
    protected function getPrivacySettings(User $user): array
    {
        return [
            'email_public' => $user->email_public,
            'phone_public' => $user->phone_public,
            'birth_date_public' => $user->birth_date_public,
            'location_privacy' => $user->location_privacy,
            'public_location' => $user->public_location,
        ];
    }
    
    /**
     * Generate downloadable JSON file
     */
    public function generateDownloadableFile(User $user): string
    {
        $data = $this->generateExport($user);
        $filename = 'user_data_export_' . $user->id . '_' . now()->format('Y-m-d_H-i-s') . '.json';
        $filePath = 'exports/' . $filename;
        
        Storage::disk('local')->put($filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        return $filePath;
    }
}

