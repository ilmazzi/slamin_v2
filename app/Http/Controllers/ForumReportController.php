<?php

namespace App\Http\Controllers;

use App\Models\ForumReport;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumReportController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'target_type' => 'required|in:post,comment',
            'target_id' => 'required|integer',
            'reason' => 'required|in:spam,harassment,hate_speech,inappropriate_content,misinformation,violence,self_harm,other',
            'description' => 'nullable|string|max:1000',
        ]);

        $targetClass = $validated['target_type'] === 'post' ? ForumPost::class : ForumComment::class;
        $target = $targetClass::findOrFail($validated['target_id']);

        // Check if already reported by this user
        $existingReport = ForumReport::where('reporter_id', Auth::id())
            ->where('target_type', $targetClass)
            ->where('target_id', $validated['target_id'])
            ->where('status', 'pending')
            ->exists();

        if ($existingReport) {
            return response()->json([
                'error' => 'Hai già segnalato questo contenuto',
            ], 422);
        }

        ForumReport::create([
            'reporter_id' => Auth::id(),
            'target_type' => $targetClass,
            'target_id' => $validated['target_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Segnalazione inviata. Grazie per aiutarci a mantenere la community sicura.',
        ]);
    }
}

