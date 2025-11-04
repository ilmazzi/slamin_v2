<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VideoSnap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SnapController extends Controller
{
    /**
     * Create a new snap
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'video_id' => 'required|exists:videos,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'timestamp' => 'required|integer|min:0',
        ]);

        $snap = VideoSnap::create([
            'video_id' => $validated['video_id'],
            'user_id' => Auth::id(),
            'timestamp' => $validated['timestamp'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => 'approved', // Auto-approve for now
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Snap creato con successo!'),
            'snap' => $snap
        ]);
    }
}
