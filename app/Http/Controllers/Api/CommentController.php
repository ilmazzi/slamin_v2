<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnifiedComment;
use App\Models\Poem;
use App\Models\Video;
use App\Models\Article;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:poem,video,article,event,gallery',
        ]);

        $modelMap = [
            'poem' => Poem::class,
            'video' => Video::class,
            'article' => Article::class,
            'event' => Event::class,
        ];

        $modelClass = $modelMap[$request->type] ?? null;
        if (!$modelClass) {
            return response()->json(['success' => false], 400);
        }

        $comments = UnifiedComment::with('user')
            ->where('commentable_type', $modelClass)
            ->where('commentable_id', $request->id)
            ->whereNull('parent_id') // Solo commenti principali
            ->latest()
            ->get()
            ->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=059669&color=fff',
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments,
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => __('social.login_to_comment'),
            ], 401);
        }

        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:poem,video,article,event,gallery',
            'content' => 'required|string|min:2|max:1000',
        ]);

        $modelMap = [
            'poem' => Poem::class,
            'video' => Video::class,
            'article' => Article::class,
            'event' => Event::class,
        ];

        $modelClass = $modelMap[$request->type] ?? null;
        if (!$modelClass) {
            return response()->json(['success' => false], 400);
        }

        // Create comment
        $comment = UnifiedComment::create([
            'user_id' => Auth::id(),
            'commentable_type' => $modelClass,
            'commentable_id' => $request->id,
            'content' => $request->content,
            'status' => 'approved', // Auto-approve for now
        ]);

        // Update counter
        $model = $modelClass::find($request->id);
        if ($model) {
            $model->increment('comment_count');
        }

        return response()->json([
            'success' => true,
            'message' => __('social.comment_added'),
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'name' => Auth::user()->name,
                    'avatar' => Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=059669&color=fff',
                ],
                'created_at' => $comment->created_at->diffForHumans(),
            ],
        ]);
    }
}

