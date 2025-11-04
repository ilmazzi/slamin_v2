<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoViewController extends Controller
{
    /**
     * Increment video view count
     */
    public function increment(Request $request, Video $video)
    {
        // Increment views only if user is not the owner
        $incremented = $video->incrementViewIfNotOwner();
        
        // Reload to get updated count
        $video->refresh();
        
        return response()->json([
            'success' => true,
            'incremented' => $incremented,
            'view_count' => $video->view_count ?? 0
        ]);
    }
}
