<?php

namespace App\Observers;

use App\Models\Photo;
use App\Services\ActivityService;
use App\Services\BadgeService;
use Illuminate\Support\Facades\Log;

class PhotoObserver
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the Photo "created" event.
     */
    public function created(Photo $photo): void
    {
        // Log activity
        if ($photo->user) {
            ActivityService::logCreate($photo->user, $photo, request());
            
            // Check and award badges for photos
            $this->badgeService->checkAndAwardBadge($photo->user, 'photos', $photo);
        }
    }

    /**
     * Handle the Photo "updated" event.
     */
    public function updated(Photo $photo): void
    {
        // Log activity for important changes
        if ($photo->user && $photo->wasChanged(['title', 'description', 'is_public'])) {
            ActivityService::logUpdate($photo->user, $photo, request());
        }
    }

    /**
     * Handle the Photo "deleted" event.
     */
    public function deleted(Photo $photo): void
    {
        // Log activity before deletion
        if ($photo->user) {
            ActivityService::logDelete(
                $photo->user,
                'App\\Models\\Photo',
                $photo->id,
                $photo->title ?? 'Foto',
                request()
            );
        }

        // Delete file from storage
        $this->deletePhotoFiles($photo);
    }

    /**
     * Delete photo files from storage
     */
    protected function deletePhotoFiles(Photo $photo): void
    {
        try {
            // Delete main image
            if ($photo->image_path) {
                if (str_starts_with($photo->image_path, 'http')) {
                    // External URL, skip file deletion
                } elseif (str_starts_with($photo->image_path, '/storage/')) {
                    $filePath = str_replace('/storage/', '', $photo->image_path);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
                } else {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->image_path);
                }
            }

            // Delete thumbnail if exists
            if ($photo->thumbnail_path) {
                if (str_starts_with($photo->thumbnail_path, 'http')) {
                    // External URL, skip file deletion
                } elseif (str_starts_with($photo->thumbnail_path, '/storage/')) {
                    $thumbPath = str_replace('/storage/', '', $photo->thumbnail_path);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($thumbPath);
                } else {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->thumbnail_path);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error deleting photo files for photo {$photo->id}: " . $e->getMessage());
        }
    }

    /**
     * Handle the Photo "restored" event.
     */
    public function restored(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "force deleted" event.
     */
    public function forceDeleted(Photo $photo): void
    {
        //
    }
}

