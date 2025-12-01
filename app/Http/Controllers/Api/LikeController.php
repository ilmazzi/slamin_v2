<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnifiedLike;
use App\Models\Poem;
use App\Models\Video;
use App\Models\Article;
use App\Models\Event;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\SocialInteractionReceived;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => __('social.login_to_like'),
            ], 401);
        }

        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:poem,video,article,event,photo',
        ]);

        $modelMap = [
            'poem' => Poem::class,
            'video' => Video::class,
            'article' => Article::class,
            'event' => Event::class,
            'photo' => Photo::class,
        ];

        $modelClass = $modelMap[$request->type] ?? null;
        if (!$modelClass) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid content type'
            ], 400);
        }

        // Verifica che il contenuto esista
        $model = $modelClass::find($request->id);
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found'
            ], 404);
        }

        // Check if already liked
        $existingLike = UnifiedLike::where('user_id', Auth::id())
            ->where('likeable_type', $modelClass)
            ->where('likeable_id', $request->id)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $model->decrement('like_count');
            
            return response()->json([
                'success' => true,
                'liked' => false,
                'count' => $model->fresh()->like_count ?? 0,
            ]);
        } else {
            // Like
            $like = UnifiedLike::create([
                'user_id' => Auth::id(),
                'likeable_type' => $modelClass,
                'likeable_id' => $request->id,
            ]);

            $model->increment('like_count');

            // Send notification to content owner if different from liker
            // Handle different owner field names (user_id for poems/videos/articles, organizer_id for events)
            $ownerId = null;
            $contentOwner = null;
            
            if ($model instanceof Event) {
                $ownerId = $model->organizer_id;
                $contentOwner = $model->organizer;
            } else {
                $ownerId = $model->user_id ?? null;
                $contentOwner = $model->user ?? null;
            }
            
            if ($ownerId && $ownerId !== Auth::id() && $contentOwner) {
                \Log::info('Dispatching SocialInteractionReceived event', [
                    'liker_id' => Auth::id(),
                    'owner_id' => $contentOwner->id,
                    'content_type' => get_class($model),
                    'content_id' => $model->id,
                ]);
                event(new SocialInteractionReceived($like, Auth::user(), $contentOwner, $model, 'like'));
            }
            
            return response()->json([
                'success' => true,
                'liked' => true,
                'count' => $model->fresh()->like_count ?? 1,
            ]);
        }
    }

    public function getLikers(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:poem,video,article,event,photo',
        ]);

        $modelMap = [
            'poem' => Poem::class,
            'video' => Video::class,
            'article' => Article::class,
            'event' => Event::class,
            'photo' => Photo::class,
        ];

        $modelClass = $modelMap[$request->type] ?? null;
        if (!$modelClass) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid content type'
            ], 400);
        }

        // Recupera tutti gli utenti che hanno messo like
        $likes = UnifiedLike::where('likeable_type', $modelClass)
            ->where('likeable_id', $request->id)
            ->with('user:id,first_name,last_name,name,nickname,avatar,profile_picture,profile_photo')
            ->orderBy('created_at', 'desc')
            ->get();

        $users = $likes->map(function ($like) {
            $user = $like->user;
            $name = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
            if (empty($name)) {
                $name = $user->name ?? 'Utente';
            }
            
            return [
                'id' => $user->id,
                'name' => $name,
                'nickname' => $user->nickname,
                'avatar' => $user->avatar ?? $user->profile_picture ?? $user->profile_photo ?? null,
            ];
        });

        // Se l'utente è autenticato, ordina i follow per primi
        if (Auth::check()) {
            $currentUser = Auth::user();
            $followingIds = $currentUser->following()->pluck('users.id')->toArray();
            
            $users = $users->sortByDesc(function ($user) use ($followingIds) {
                return in_array($user['id'], $followingIds) ? 1 : 0;
            })->values();
        }

        return response()->json([
            'success' => true,
            'users' => $users->take(10)->values(), // Limita a 10 utenti
            'total' => $likes->count(),
        ]);
    }
}

